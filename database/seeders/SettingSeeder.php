<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'TokoKu', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Belanja Mudah, Jualan Untung', 'group' => 'general'],
            ['key' => 'contact_email', 'value' => 'support@tokoku.id', 'group' => 'general'],
            ['key' => 'contact_phone', 'value' => '0800-1234-5678', 'group' => 'general'],
            ['key' => 'low_stock_threshold', 'value' => '5', 'group' => 'inventory'],
            ['key' => 'order_expiry_hours', 'value' => '24', 'group' => 'orders'],
            ['key' => 'min_order_amount', 'value' => '0', 'group' => 'orders'],
            ['key' => 'platform_commission_percent', 'value' => '0', 'group' => 'finance'],
            ['key' => 'min_payout_amount', 'value' => '100000', 'group' => 'finance'],
            ['key' => 'payout_fee', 'value' => '5000', 'group' => 'finance'],
            ['key' => 'social_facebook', 'value' => '', 'group' => 'social'],
            ['key' => 'social_instagram', 'value' => '', 'group' => 'social'],
            ['key' => 'social_twitter', 'value' => '', 'group' => 'social'],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'group' => $setting['group']],
            );
        }
    }
}
