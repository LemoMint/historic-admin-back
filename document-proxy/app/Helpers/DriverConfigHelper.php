<?php

namespace App\Helpers;

use Termwind\Components\Dd;
use Illuminate\Support\Facades\Storage;

class DriverConfigHelper
{
    public static function setAuthToken(string $driver, array $tokenData, string $tokenName, string $tokenKeyName): ?string
    {
        if (Storage::disk('security_keys')->put($driver.'/'.$tokenName.'.json', json_encode($tokenData))) {
            return $tokenData[$tokenKeyName];
        }

        return null;
    }

    public static function getToken(string $driver, string $tokenName, string $tokenKeyName)
    {
        $tokenData = json_decode(Storage::disk('security_keys')->get($driver.'/'.$tokenName.'.json'), true);

        if ($tokenData !== null && isset($tokenData[$tokenKeyName])) {
            if (self::isTokenExpired($tokenData)) {
                return $tokenData[$tokenKeyName];
            }
        }

        return null;
    }

    private static function isTokenExpired(array $tokenData): bool
    {
        if (isset($tokenData['expires_in'])) {
            $now =  time();
            $expires = $tokenData['expires_in'] + $tokenData['created_at'];
            if ($expires - $now  > 30) {
                return true;
            }

            return false;
        }

        return true;
    }
}
