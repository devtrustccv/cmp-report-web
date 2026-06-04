<?php
namespace App\Services;

class GatewayClientService{
    
    protected function tokenHeaders(string $token): array
{
        return ['X-API-TOKEN' => $token];
    }
}