<?php

namespace App\Services\Traits;

trait GatewayClientTrait
{
    protected function tokenHeaders(string $token): array
    {
        return [
            'X-API-TOKEN' => $token
        ];
    }

    protected function reportHeaders(): array
    {
        return $this->tokenHeaders(
            config('services.gateway.report_token')
        );
    }

    protected function cmpHeaders(): array
    {
        return $this->tokenHeaders(
            config('services.gateway.cmp_token')
        );
    }
}