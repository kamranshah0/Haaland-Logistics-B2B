<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LogisticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@haalandlogistics.com'],
            [
                'name' => 'Admin User',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'admin',
                'status' => 'approved',
            ]
        );

        // System Settings
        \App\Models\SystemSetting::create(['key' => 'origin_service_fee', 'value' => '3.00', 'type' => 'decimal']);
        \App\Models\SystemSetting::create(['key' => 'minimum_volume', 'value' => '100.00', 'type' => 'decimal']);

        // Warehouses - Official Data
        $la = \App\Models\Warehouse::create([
            'name' => 'Los Angeles Warehouse',
            'code' => 'LA',
            'address' => '15506 Minnesota Ave. Paramount CA. 90723',
            'opening_hours' => '9am - 4pm',
        ]);

        $miami = \App\Models\Warehouse::create([
            'name' => 'Miami Logistics Center',
            'code' => 'MIAMI',
            'address' => '6158 Nw 74 Ave. Miami FL. 33166',
            'opening_hours' => '9am - 4pm',
        ]);

        // Countries
        $neth = \App\Models\Country::create(['name' => 'Netherlands', 'has_regions' => true]);
        $eng = \App\Models\Country::create(['name' => 'England', 'has_regions' => true]);

        // Regions
        $neth_wh = \App\Models\Region::create(['country_id' => $neth->id, 'name' => 'Whse hand-out']);
        $neth_all = \App\Models\Region::create(['country_id' => $neth->id, 'name' => 'All']);
        
        $eng_north = \App\Models\Region::create(['country_id' => $eng->id, 'name' => 'Manchester & north']);
        $eng_south = \App\Models\Region::create(['country_id' => $eng->id, 'name' => 'Manchester south']);

        // Sample Tiered Rates for Netherlands (Whse hand-out)
        $rate1 = \App\Models\Rate::create([
            'origin_id' => $la->id,
            'country_id' => $neth->id,
            'region_id' => $neth_wh->id,
            'service_type' => 'Standard',
            'rate_per_cft' => 0.00, // Legacy fallback
        ]);
        \App\Models\RateTier::create(['rate_id' => $rate1->id, 'min_volume' => 110, 'price_per_cft' => 2.76]);
        \App\Models\RateTier::create(['rate_id' => $rate1->id, 'min_volume' => 170, 'price_per_cft' => 1.65]);

        // Sample Tiered Rates for England (Manchester & north)
        $rate2 = \App\Models\Rate::create([
            'origin_id' => $miami->id,
            'country_id' => $eng->id,
            'region_id' => $eng_north->id,
            'service_type' => 'Standard',
            'rate_per_cft' => 0.00,
        ]);
        \App\Models\RateTier::create(['rate_id' => $rate2->id, 'min_volume' => 110, 'price_per_cft' => 7.88]);
        \App\Models\RateTier::create(['rate_id' => $rate2->id, 'min_volume' => 170, 'price_per_cft' => 5.46]);
        \App\Models\RateTier::create(['rate_id' => $rate2->id, 'min_volume' => 350, 'price_per_cft' => 5.13]);
    }
}
