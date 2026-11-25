<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CurrencyService
{
    private const BASE_CURRENCY = 'IDR';

    private const TARGET_CURRENCIES = [
        'USD',
        'EUR',
        'JPY',
        'SGD',
        'GBP',
    ];

    public function getRates(): array
    {
        return Cache::remember('spendly.currency.rates', 3600, function () {
            try {
                $response = Http::timeout(5)
                    ->connectTimeout(3)
                    ->get('https://api.frankfurter.dev/v2/rates', [
                        'base' => self::BASE_CURRENCY,
                        'quotes' => implode(',', self::TARGET_CURRENCIES),
                    ]);

                if (! $response->successful()) {
                    return $this->fallback();
                }

                $rows = $response->json();

                if (! is_array($rows) || empty($rows)) {
                    return $this->fallback();
                }

                $rates = [];

                foreach ($rows as $row) {
                    if (
                        isset($row['quote'], $row['rate']) &&
                        in_array($row['quote'], self::TARGET_CURRENCIES, true)
                    ) {
                        $rates[$row['quote']] = $row['rate'];
                    }
                }

                if (empty($rates)) {
                    return $this->fallback();
                }

                return [
                    'success' => true,
                    'date' => $rows[0]['date'] ?? null,
                    'rates' => $rates,
                ];
            } catch (\Throwable $e) {
                report($e);

                return $this->fallback();
            }
        });
    }

    private function fallback(): array
    {
        return [
            'success' => false,
            'date' => null,
            'rates' => [],
        ];
    }
}
