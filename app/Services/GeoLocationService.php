<?php

namespace App\Services;

use App\Contracts\GeoLocationServiceInterface;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

final readonly class GeoLocationService implements GeoLocationServiceInterface
{
    private const string API_BASE_URL = 'http://ip-api.com';
    private const string PUBLIC_IP_SERVICE_URL = 'https://ifconfig.me/ip';
    private const int TIMEOUT_SECONDS = 5;
    private const string STATUS_SUCCESS = 'success';

    /**
     * @throws ConnectionException
     */
    public function locate(?string $ip = null): ?array
    {
        $ip ??= $this->resolveIp();

        $data = $this->fetchGeoData($ip);

        if ($data === null) {
            return null;
        }

        return $this->mapToLocation($data, $ip);
    }

    /**
     * @throws ConnectionException
     */
    private function resolveIp(): string
    {
        if (app()->isProduction()) {
            return request()->ip();
        }

        return Http::timeout(self::TIMEOUT_SECONDS)
            ->get(self::PUBLIC_IP_SERVICE_URL)
            ->body();
    }

    /**
     * @throws ConnectionException
     */
    private function fetchGeoData(string $ip): ?array
    {
        $response = Http::baseUrl(self::API_BASE_URL)
            ->acceptJson()
            ->timeout(self::TIMEOUT_SECONDS)
            ->get("/json/{$ip}");

        if (!$response->successful()) {
            return null;
        }

        $data = $response->json();

        if (($data['status'] ?? null) !== self::STATUS_SUCCESS) {
            return null;
        }

        return $data;
    }

    private function mapToLocation(array $data, string $fallbackIp): array
    {
        return [
            'ip' => $data['query'] ?? $fallbackIp,
            'country' => $data['country'] ?? null,
            'country_code' => $data['countryCode'] ?? null,
            'region' => $data['regionName'] ?? null,
            'city' => $data['city'] ?? null,
            'latitude' => $data['lat'] ?? null,
            'longitude' => $data['lon'] ?? null,
            'timezone' => $data['timezone'] ?? null,
        ];
    }
}
