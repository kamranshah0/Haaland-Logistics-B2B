<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Region;
use App\Models\Rate;
use App\Models\RateTier;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RealWorldRatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Clear existing rates and tiers for a clean start
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        RateTier::truncate();
        Rate::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Official Data from Image
        $data = [
            ['country' => 'Netherlands', 'region' => 'Whse hand-out', 'tiers' => [110 => 2.76, 170 => 1.65]],
            ['country' => 'Netherlands', 'region' => 'All', 'tiers' => [110 => 5.46, 170 => 3.97, 350 => 3.80]],
            ['country' => 'Albania', 'region' => 'All', 'tiers' => [110 => 11.85, 170 => 9.09, 350 => 8.60]],
            ['country' => 'Austria', 'region' => 'All', 'tiers' => [110 => 7.88, 170 => 5.46, 350 => 5.13]],
            ['country' => 'Belgium', 'region' => 'All', 'tiers' => [110 => 5.46, 170 => 3.97, 350 => 3.80]],
            ['country' => 'Bulgaria', 'region' => 'All', 'tiers' => [110 => 11.85, 170 => 8.27, 350 => 7.44]],
            ['country' => 'Croatia', 'region' => 'All', 'tiers' => [110 => 9.70, 170 => 6.78, 350 => 6.28]],
            ['country' => 'Cyprus', 'region' => 'Nicosia', 'tiers' => [110 => 14.33, 170 => 11.57, 350 => 11.08]],
            ['country' => 'Czech Rep.', 'region' => 'All', 'tiers' => [110 => 7.88, 170 => 5.46, 350 => 5.13]],
            ['country' => 'Denmark', 'region' => 'Copenhagen', 'tiers' => [110 => 7.88, 170 => 5.46, 350 => 4.96]],
            ['country' => 'England', 'region' => 'Manchester & north', 'tiers' => [110 => 7.88, 170 => 5.46, 350 => 5.13]],
            ['country' => 'England', 'region' => 'Manchester south', 'tiers' => [110 => 9.70, 170 => 6.78, 350 => 6.28]],
            ['country' => 'Estonia', 'region' => 'All', 'tiers' => [110 => 11.85, 170 => 8.27, 350 => 7.44]],
            ['country' => 'Finland', 'region' => 'Helsinki', 'tiers' => [110 => 11.85, 170 => 7.44, 200 => 7.44, 350 => 6.78]],
            ['country' => 'France', 'region' => 'Paris & north', 'tiers' => [110 => 6.67, 170 => 4.63, 350 => 4.30]],
            ['country' => 'France', 'region' => 'east & west', 'tiers' => [110 => 7.88, 170 => 5.46, 350 => 4.96]],
            ['country' => 'France', 'region' => 'Lyon & south', 'tiers' => [110 => 7.88, 170 => 5.46, 350 => 4.96]],
            ['country' => 'Germany', 'region' => 'All', 'tiers' => [110 => 6.67, 170 => 4.63, 350 => 4.30]],
            ['country' => 'Greece', 'region' => 'Athens', 'tiers' => [110 => 11.85, 170 => 8.27, 350 => 7.44]],
            ['country' => 'Hungary', 'region' => 'All', 'tiers' => [110 => 9.70, 170 => 6.78, 350 => 6.12]],
            ['country' => 'Ireland', 'region' => 'All', 'tiers' => [110 => 9.70, 170 => 6.78, 350 => 6.12]],
            ['country' => 'Italy', 'region' => 'Rome & north', 'tiers' => [110 => 9.70, 170 => 6.78, 350 => 6.12]],
            ['country' => 'Italy', 'region' => 'Rome south', 'tiers' => [110 => 11.85, 170 => 8.66, 350 => 7.94]],
            ['country' => 'Latvia', 'region' => 'All', 'tiers' => [110 => 11.85, 170 => 8.27, 350 => 7.44]],
            ['country' => 'Lithuania', 'region' => 'All', 'tiers' => [110 => 11.85, 170 => 8.27, 350 => 7.44]],
            ['country' => 'Luxemburg', 'region' => 'All', 'tiers' => [110 => 5.46, 170 => 3.97, 350 => 3.80]],
            ['country' => 'Malta', 'region' => 'Valletta', 'tiers' => [110 => 14.33, 170 => 11.57, 350 => 11.08]],
            ['country' => 'Norway', 'region' => 'Oslo, Bergen & south', 'tiers' => [110 => 9.70, 170 => 6.78, 350 => 6.28]],
            ['country' => 'Norway', 'region' => 'north', 'tiers' => [110 => 16.53, 170 => 9.92, 200 => 9.09, 350 => 8.27]],
            ['country' => 'Poland', 'region' => 'All', 'tiers' => [110 => 9.70, 170 => 6.78, 350 => 6.12]],
            ['country' => 'Portugal', 'region' => 'Lisbon', 'tiers' => [110 => 9.70, 170 => 6.78, 350 => 6.12]],
            ['country' => 'Romania', 'region' => 'All', 'tiers' => [110 => 11.85, 170 => 8.27, 350 => 7.44]],
            ['country' => 'Serbia', 'region' => 'All', 'tiers' => [110 => 11.85, 170 => 9.09, 350 => 8.60]],
            ['country' => 'Slovakia', 'region' => 'All', 'tiers' => [110 => 12.12, 170 => 7.44, 350 => 6.78]],
            ['country' => 'Slovenia', 'region' => 'All', 'tiers' => [110 => 9.70, 170 => 6.78, 350 => 6.12]],
            ['country' => 'Spain', 'region' => 'All', 'tiers' => [110 => 9.70, 170 => 6.78, 350 => 6.12]],
            ['country' => 'Sweden', 'region' => 'Stockholm & south', 'tiers' => [110 => 9.70, 170 => 6.78, 350 => 6.28]],
            ['country' => 'Sweden', 'region' => 'north', 'tiers' => [110 => 14.88, 170 => 9.09, 350 => 8.27]],
            ['country' => 'Switzerland', 'region' => 'All', 'tiers' => [110 => 7.88, 170 => 5.46, 350 => 5.13]],
        ];

        // 3. Process and Insert
        foreach ($data as $row) {
            $country = Country::firstOrCreate(['name' => $row['country']], ['has_regions' => true]);
            $region = Region::firstOrCreate(['country_id' => $country->id, 'name' => $row['region']]);

            $rate = Rate::create([
                'origin_id' => 1, // Los Angeles Warehouse
                'country_id' => $country->id,
                'region_id' => $region->id,
                'shipping_service_id' => 1, // Standard Consolidation
                'service_type_id' => 1, // Warehouse to Door
                'service' => 'Standard Consolidation', // Legacy string
                'service_type' => 'Warehouse to Door', // Legacy string
                'rate_per_cft' => 0.00, // Legacy fallback
            ]);

            foreach ($row['tiers'] as $vol => $price) {
                RateTier::create([
                    'rate_id' => $rate->id,
                    'min_volume' => $vol,
                    'price_per_cft' => $price,
                ]);
            }
        }
    }
}
