<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class BaseApiService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.global.url_api');
    }

    protected function get(string $endpoint, array $params = []): Response
    {
        return Http::withoutVerifying()
            ->withHeaders([
                'Accept' => 'application/json',
            ])
            ->get($this->baseUrl . $endpoint, $params);
    }
}