<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'currency_code',
        'locale',
        'role',
        'balance',
        'referred_by',
        'referral_milestone_bonus_at',
        'password',
        // referral_code is set in model boot / migrations only (not user-editable)
    ];

    protected static function booted(): void
    {
        static::creating(function (User $user): void {
            if ($user->referral_code === null || $user->referral_code === '') {
                $user->referral_code = static::generateUniqueReferralCode();
            }
        });
    }

    /** Permanent shareable code (unique). */
    public static function generateUniqueReferralCode(): string
    {
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        for ($attempt = 0; $attempt < 100; $attempt++) {
            $code = '';
            for ($i = 0; $i < 10; $i++) {
                $code .= $chars[random_int(0, strlen($chars) - 1)];
            }
            if (! static::query()->where('referral_code', $code)->exists()) {
                return $code;
            }
        }

        throw new \RuntimeException('Unable to generate a unique referral code.');
    }

    /** Code shown in UI / APIs (always set after migrations). */
    public function publicReferralCode(): string
    {
        return (string) ($this->referral_code ?: $this->displayUsername());
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'balance' => 'decimal:2',
            'referral_milestone_bonus_at' => 'datetime',
        ];
    }

    public function displayUsername(): string
    {
        return (string) ($this->username ?: $this->name);
    }

    /**
     * Who referred this account (public fields only). Null if not referred or referrer missing.
     *
     * @return array{id: int|string, username: string, referral_code: string}|null
     */
    public function referrerSummary(): ?array
    {
        if ($this->referred_by === null) {
            return null;
        }

        $r = $this->relationLoaded('referrer')
            ? $this->referrer
            : $this->referrer()->first();

        if ($r === null) {
            return null;
        }

        return [
            'id' => $r->getKey(),
            'username' => $r->displayUsername(),
            'referral_code' => $r->publicReferralCode(),
        ];
    }

    /**
     * Real inbox for third-party tools (Intercom). Null when `email` is the synthetic `{username}@{player_domain}` placeholder.
     */
    public function intercomContactEmail(): ?string
    {
        $email = trim((string) $this->email);
        if ($email === '') {
            return null;
        }

        $domain = strtolower((string) config('auth.player_email_domain', 'players.local'));
        if (str_ends_with(strtolower($email), '@'.$domain)) {
            return null;
        }

        return $email;
    }

    /** JSON shape for SPA (`/api/me`, login/register responses). */
    public function toApiArray(): array
    {
        return [
            'id' => $this->getKey(),
            'username' => $this->displayUsername(),
            'name' => (string) $this->name,
            'email' => (string) $this->email,
            'intercom_email' => $this->intercomContactEmail(),
            'phone' => $this->phone !== null ? (string) $this->phone : null,
            'referral_code' => $this->publicReferralCode(),
            'referrer' => $this->referrerSummary(),
            'currency_code' => $this->currency_code,
            'currency_symbol' => $this->currencySymbol(),
            'balance' => (string) ($this->balance ?? '0.00'),
            'role' => $this->role,
            /** Unix seconds for Intercom / analytics. */
            'created_at' => $this->created_at?->getTimestamp(),
        ];
    }

    public function currencySymbol(): string
    {
        return match (strtoupper((string) $this->currency_code)) {
            'INR' => '₹',
            'PKR' => '₨',
            'NPR' => 'Rs',
            default => '৳',
        };
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /** @return HasMany<UserReferralTier, $this> */
    public function referralTiers(): HasMany
    {
        return $this->hasMany(UserReferralTier::class)->orderBy('position');
    }

    /** @return HasMany<UserReferralLedgerEntry, $this> */
    public function referralLedgerEntries(): HasMany
    {
        return $this->hasMany(UserReferralLedgerEntry::class)->orderByDesc('created_at');
    }

    /** @return BelongsTo<User, $this> */
    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    /** @return HasMany<User, $this> */
    public function referees(): HasMany
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    /** @return HasMany<UserDeposit, $this> */
    public function deposits(): HasMany
    {
        return $this->hasMany(UserDeposit::class);
    }

    /** @return HasMany<UserWithdrawal, $this> */
    public function withdrawals(): HasMany
    {
        return $this->hasMany(UserWithdrawal::class);
    }
}
