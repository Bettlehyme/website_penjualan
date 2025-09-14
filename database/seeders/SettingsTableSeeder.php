<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            ['key' => 'site_name', 'value' => 'My Website'],
            ['key' => 'sales_photo', 'value' => 'https://mywebsite.com/price-list.pdf'],
            ['key' => 'sales_name', 'value' => 'Best Sales Team'],
            ['key' => 'sales_description', 'value' => 'We provide top-quality services and products.'],
            ['key' => 'twitter', 'value' => 'https://twitter.com/yourpage'],
            ['key' => 'instagram', 'value' => 'https://instagram.com/yourpage'],
            ['key' => 'youtube', 'value' => 'https://youtube.com/yourchannel'],
            ['key' => 'facebook', 'value' => 'https://facebook.com/yourpage'],
            ['key' => 'whatsapp_number', 'value' => '+6281234567890'],
            ['key' => 'footer_description', 'value' => '© 2025 My Website. All rights reserved.'],
            ['key' => 'price_list', 'value' => 'https://mywebsite.com/price-list.pdf'],
            ['key' => 'logo', 'value' => 'https://mywebsite.com/price-list.pdf'],

        ]);
    }
}
