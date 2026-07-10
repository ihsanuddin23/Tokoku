<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShippingService
{
    private ?string $apiKey;
    private string $baseUrl;
    private string $originCity;

    private const FALLBACK_COSTS = [
        'jne' => 15000, 'jnt' => 14000, 'sicepat' => 13000,
        'pos' => 12000, 'tiki' => 13500, 'anteraja' => 20000,
    ];

    private const SERVICES = [
        'jne' => 'REG', 'jnt' => 'EZ', 'sicepat' => 'REG',
        'pos' => 'Biasa', 'tiki' => 'REG', 'anteraja' => 'Same Day',
    ];

    private const ETAS = [
        'jne' => '2-3 hari', 'jnt' => '2-3 hari', 'sicepat' => '2-3 hari',
        'pos' => '3-5 hari', 'tiki' => '2-4 hari', 'anteraja' => '1-2 hari',
    ];

    public function __construct()
    {
        $this->apiKey = config('services.rajaongkir.key');
        $this->baseUrl = config('services.rajaongkir.base_url', 'https://api.rajaongkir.com/starter');
        $this->originCity = config('services.rajaongkir.origin_city', 'Jakarta');
    }

    public function getCouriers(): array
    {
        $couriers = [];
        foreach (array_keys(self::FALLBACK_COSTS) as $id) {
            $couriers[] = [
                'id' => $id,
                'name' => strtoupper($id),
                'service' => self::SERVICES[$id],
                'eta' => self::ETAS[$id],
            ];
        }
        return $couriers;
    }

    public function getShippingCost(string $courier, ?string $destinationCity = null, int $weight = 1000): array
    {
        if (! $this->apiKey || ! $destinationCity) {
            return [
                'cost' => self::FALLBACK_COSTS[$courier] ?? 15000,
                'service' => self::SERVICES[$courier] ?? 'REG',
                'eta' => self::ETAS[$courier] ?? '2-3 hari',
            ];
        }

        try {
            $response = Http::withHeaders(['key' => $this->apiKey])
                ->post("{$this->baseUrl}/cost", [
                    'origin' => $this->originCity,
                    'destination' => $destinationCity,
                    'weight' => $weight,
                    'courier' => $courier,
                ]);

            if ($response->successful()) {
                $data = $response->json('rajaongkir.results.0.costs.0');
                if ($data) {
                    return [
                        'cost' => $data['value'],
                        'service' => $data['service'],
                        'eta' => $data['etd'] ? $data['etd'] . ' hari' : '2-3 hari',
                    ];
                }
            }
        } catch (\Exception $e) {
            Log::warning('RajaOngkir API error: ' . $e->getMessage());
        }

        return [
            'cost' => self::FALLBACK_COSTS[$courier] ?? 15000,
            'service' => self::SERVICES[$courier] ?? 'REG',
            'eta' => self::ETAS[$courier] ?? '2-3 hari',
        ];
    }

    public function getCosts(): array
    {
        return self::FALLBACK_COSTS;
    }

    public function getServices(): array
    {
        return self::SERVICES;
    }
}
