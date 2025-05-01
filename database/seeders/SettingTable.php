<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingTable extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'name' => 'Site Name', 
            'phone_number' => '0123456789', 
            'email' => 'email@email.com', 
            'country' => 'Your Country', 
            'city' => 'Your City', 
            'street' => 'Your Street', 
            'social_links' => json_encode([]), 
            'logo' => ''
        ]);
    }
}
