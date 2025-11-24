<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class ShippingController extends Controller
{
    /**
     * Calculate shipping cost and details based on mode and distance
     * Used during checkout for live calculation
     */
    public function calculateShipping(Request $request)
    {
        $mode = $request->get('mode', 'reguler');
        $distance = $request->get('distance', 10); // km, default 10km
        $weight = $request->get('weight', 1); // kg, default 1kg

        // Validasi mode
        if (!in_array($mode, ['reguler', 'same_day', 'instant'])) {
            return response()->json(['error' => 'Invalid shipping mode'], 400);
        }

        // Hitung biaya berdasarkan mode dan jarak
        $baseCost = 5000; // Rp 5000 base cost
        $shippingData = $this->getShippingDetails($mode, $distance, $weight);

        if ($shippingData['available'] === false) {
            return response()->json([
                'error' => $shippingData['reason'],
                'available' => false
            ], 400);
        }

        return response()->json($shippingData);
    }

    /**
     * Get detailed shipping information for a given mode
     */
    private function getShippingDetails($mode, $distance, $weight)
    {
        $baseCost = 5000;
        $distanceCost = 500; // Rp 500 per km

        switch ($mode) {
            case 'reguler':
                return [
                    'mode' => 'reguler',
                    'label' => 'Reguler (1-3 hari kerja)',
                    'cost' => $baseCost + ($distance * $distanceCost),
                    'estimatedHours' => '48-72',
                    'estimatedDays' => '1-3 hari kerja',
                    'maxWeight' => 50,
                    'available' => true,
                    'cutoffTime' => null,
                    'pickupRequired' => true,
                    'trackingType' => 'standard'
                ];

            case 'same_day':
                // Same Day hanya tersedia untuk area tertentu (distance <= 15km)
                // dan sebelum cutoff time (14:00)
                $available = $distance <= 15 && $weight <= 5;
                $cutoffTime = Carbon::today()->setHour(14)->setMinute(0);
                $canOrder = Carbon::now() < $cutoffTime;

                return [
                    'mode' => 'same_day',
                    'label' => 'Same Day (6-12 jam)',
                    'cost' => $available ? $baseCost * 3 + ($distance * $distanceCost * 2) : 0,
                    'estimatedHours' => '6-12',
                    'estimatedDays' => 'Hari ini sebelum pukul 20:00',
                    'maxWeight' => 5,
                    'available' => $available && $canOrder,
                    'cutoffTime' => $cutoffTime->toIso8601String(),
                    'cutoffExceeded' => !$canOrder,
                    'pickupRequired' => true,
                    'trackingType' => 'realtime',
                    'reason' => !$available 
                        ? ($distance > 15 ? 'Area terlalu jauh untuk Same Day' : 'Berat paket melebihi batas (maks 5kg)')
                        : (!$canOrder ? 'Sudah melewati jam cutoff (sebelum pukul 14:00)' : null)
                ];

            case 'instant':
                // Instant hanya untuk area sangat dekat (distance <= 5km)
                // dan sebelum cutoff time (12:00)
                $available = $distance <= 5 && $weight <= 3;
                $cutoffTime = Carbon::today()->setHour(12)->setMinute(0);
                $canOrder = Carbon::now() < $cutoffTime;

                return [
                    'mode' => 'instant',
                    'label' => 'Instant (1-3 jam)',
                    'cost' => $available ? $baseCost * 5 + ($distance * $distanceCost * 3) : 0,
                    'estimatedHours' => '1-3',
                    'estimatedDays' => 'Tiba dalam 1-3 jam',
                    'maxWeight' => 3,
                    'available' => $available && $canOrder,
                    'cutoffTime' => $cutoffTime->toIso8601String(),
                    'cutoffExceeded' => !$canOrder,
                    'pickupRequired' => true,
                    'trackingType' => 'live',
                    'reason' => !$available 
                        ? ($distance > 5 ? 'Area terlalu jauh untuk Instant (maks 5km)' : 'Berat paket melebihi batas (maks 3kg)')
                        : (!$canOrder ? 'Sudah melewati jam cutoff (sebelum pukul 12:00)' : null)
                ];

            default:
                return [
                    'available' => false,
                    'reason' => 'Mode pengiriman tidak valid'
                ];
        }
    }

    /**
     * Get available shipping modes for checkout
     * Returns all 3 modes with availability and pricing
     */
    public function getAvailableModes(Request $request)
    {
        $distance = $request->get('distance', 10);
        $weight = $request->get('weight', 1);

        $modes = [];
        foreach (['reguler', 'same_day', 'instant'] as $mode) {
            $details = $this->getShippingDetails($mode, $distance, $weight);
            $modes[] = $details;
        }

        return response()->json([
            'modes' => $modes,
            'now' => Carbon::now()->toIso8601String()
        ]);
    }

    /**
     * Get estimated delivery time
     */
    public function getEstimatedDelivery($mode)
    {
        return match ($mode) {
            'reguler' => Carbon::now()->addDays(2),     // +2 hari
            'same_day' => Carbon::now()->addHours(12),  // +12 jam
            'instant' => Carbon::now()->addHours(3),    // +3 jam
            default => Carbon::now()->addDays(3)
        };
    }

    /**
     * Check if shipping mode is still available (cutoff check)
     */
    public function checkAvailability(Request $request)
    {
        $mode = $request->get('mode');
        $distance = $request->get('distance', 10);
        $weight = $request->get('weight', 1);

        $details = $this->getShippingDetails($mode, $distance, $weight);

        return response()->json([
            'available' => $details['available'],
            'reason' => $details['reason'] ?? null,
            'cutoffTime' => $details['cutoffTime'] ?? null
        ]);
    }
}
