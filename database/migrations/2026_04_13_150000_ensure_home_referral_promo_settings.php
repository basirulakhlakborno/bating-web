<?php

use App\Models\SiteSetting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('site_settings')) {
            return;
        }

        $defaults = [
            'home_referral_headline_en' => 'Refer friends and start earning',
            'home_referral_body_bn' => base64_decode('4Kas4Ka+4KaC4Kay4Ka+4Kam4KeH4Ka24KeH4KawIOCmqOCmgiDgp6cg4Kar4KeN4Kaw4KeH4Kao4KeN4KahIOCmsOCnh+Cmq+CmvuCmsOCnh+CmsiDgpqrgp43gprDgp4vgppfgp43gprDgpr7gpq4g4KaP4KaW4KaoIOCmj+CmluCmvuCmqOCnhyEg4KaP4KaV4Kac4KaoIOCmrOCmqOCnjeCmp+CngeCmleCnhyDgprDgp4fgpqvgpr7gprAg4KaV4Kaw4Kay4KeHIOCmq+CnjeCmsOCmvyDgp7Pgp6vgp6bgp6Yg4KaJ4Kaq4Ka+4Kaw4KeN4Kac4KaoIOCmleCmsOCngeCmqCDgpo/gpqzgpoIg4KaG4Kaq4Kao4Ka+4KawIOCmrOCmqOCnjeCmp+CngSDgpqrgp43gprDgpqTgpr/gpqzgpr7gprAg4Kac4Kau4Ka+IOCmpuCmv+CmsuCnhyDgpobgppzgp4Dgpqzgpqgg4Ka44Kaw4KeN4Kas4KeL4Kaa4KeN4KaaIOCnqCUg4KaV4Kau4Ka/4Ka24KaoIOCmquCmvuCmqCE=', true),
            'home_referral_mobile_section_bn' => 'প্রচার',
            'home_referral_mobile_headline_en' => 'Refer and earn with BABU88',
        ];

        foreach ($defaults as $key => $value) {
            if (! SiteSetting::query()->where('key', $key)->exists()) {
                SiteSetting::query()->create(['key' => $key, 'value' => $value]);
            }
        }
    }
};
