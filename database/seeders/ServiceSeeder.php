<?php

namespace Database\Seeders;

use App\Models\Rate;
use App\Models\Quote;
use App\Models\ShippingService;
use App\Models\ServiceType;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Default Services
        $standard = ShippingService::firstOrCreate(['name' => 'Standard Consolidation'], ['description' => 'Reliable and cost-effective shipping for non-urgent cargo.']);
        $express = ShippingService::firstOrCreate(['name' => 'Express Shipping'], ['description' => 'Fast delivery with priority handling.']);
        $economy = ShippingService::firstOrCreate(['name' => 'Economy Freight'], ['description' => 'Budget-friendly freight solutions for large volumes.']);

        // 2. Create Default Service Types
        $w2door = ServiceType::firstOrCreate(['name' => 'Warehouse to Door'], ['description' => 'Complete end-to-end delivery from warehouse to final address.']);
        $w2port = ServiceType::firstOrCreate(['name' => 'Warehouse to Port'], ['description' => 'Shipping from warehouse to destination port only.']);
        $w2w = ServiceType::firstOrCreate(['name' => 'Warehouse to Warehouse'], ['description' => 'Logistics between two regional warehouses.']);

        // 3. Migrate Existing Rates
        Rate::all()->each(function ($rate) use ($standard, $express, $economy, $w2door, $w2port, $w2w) {
            $service = match ($rate->service) {
                'Express Shipping' => $express,
                'Economy Freight' => $economy,
                default => $standard,
            };

            $type = match ($rate->service_type) {
                'Warehouse to Port' => $w2port,
                'Warehouse to Warehouse' => $w2w,
                default => $w2door,
            };

            $rate->update([
                'shipping_service_id' => $service->id,
                'service_type_id' => $type->id,
            ]);
        });

        // 4. Migrate Existing Quotes
        Quote::all()->each(function ($quote) use ($w2door, $w2port, $w2w) {
            $type = match ($quote->service_type) {
                'Warehouse to Port' => $w2port,
                'Warehouse to Warehouse' => $w2w,
                default => $w2door,
            };

            $quote->setRawAttributes(['service_type_id' => $type->id]);
            $quote->save();
        });
    }
}
