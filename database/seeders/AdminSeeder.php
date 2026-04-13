<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

/**
 * Staff login at /hakai/admin/login — run alone: php artisan db:seed --class=AdminSeeder
 */
class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::query()->firstOrCreate(
            ['email' => 'admin@localhost'],
            [
                'name' => 'Administrator',
                'password' => 'password',
            ]
        );
    }
}
