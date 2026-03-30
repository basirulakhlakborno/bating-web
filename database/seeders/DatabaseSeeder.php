<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call(SiteContentSeeder::class);

        User::query()->create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@localhost',
            'phone' => null,
            'currency_code' => 'BDT',
            'locale' => 'bn',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);
    }
}
