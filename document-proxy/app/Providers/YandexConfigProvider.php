<?php

namespace App\Providers;

use GuzzleHttp\Client;
use App\Helpers\EnvHelper;
use Illuminate\Support\Str;
use GuzzleHttp\Message\Request;
use GuzzleHttp\Message\Response;
use App\Helpers\FileStorageHelper;
use App\Helpers\DriverConfigHelper;
use Illuminate\Support\ServiceProvider;
use App\Services\Recognition\Drivers\Yandex;

class YandexConfigProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $apiToken = DriverConfigHelper::getToken('yandex', 'api', 'secret');
        if (!$apiToken) {
            $iamToken =  DriverConfigHelper::getToken('yandex','iam', 'access_token');
            if (!$iamToken) {
                $curl = curl_init(config('yandex.IAmToken.getByFunctionUrl'));
                curl_setopt_array($curl, [
                    CURLOPT_RETURNTRANSFER => true
                ]);

                $response = json_decode(curl_exec($curl), true);

                if ($response && isset($response["access_token"])) {
                    $response["created_at"] = time();
                    $iamToken = DriverConfigHelper::setAuthToken('yandex', $response, 'iam', 'access_token');
                }

                curl_close($curl);
            }

            $curl = curl_init(config('yandex.ApiToken.getByUrl'));

            curl_setopt_array($curl, [
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_HTTPHEADER => [
                        "Content-Type: application/json",
                        "Authorization: Bearer ".$iamToken
                    ],
                    CURLOPT_POSTFIELDS => json_encode([
                        "serviceAccountId" => config('yandex.ServiceAccount')
                    ]),
                ]);

            $response = json_decode(curl_exec($curl), true);

            if ($response && isset($response["secret"])) {
                $apiToken = DriverConfigHelper::setAuthToken('yandex', $response, 'api', 'secret');
            }

            curl_close($curl);
        }

        $this->app->bind(Yandex::class, function() use ($apiToken) {
            return new Yandex($apiToken);
        });
    }
}


//curl -X POST   -H "Content-Type: application/json"   -H "Authorization: Bearer t1.9euelZqenY7LkJTGiorNkZmPipHJl-3rnpWalJSPxpKOnMqWio3Iip6RjI7l9Pd7ehNj-e8WG1Dv3fT3OykRY_nvFhtQ7w.cIL5nOte88avq5AmIrAh1YYMG2V43DmccHKb01Ws-my_-R7YRGIyt02kHMJZWmpPXAv_4taWOKUj0fIw77niBA"   -d "{ \"serviceAccountId\": \"ajekkp9mqc5iur7uansq\" }"   https://iam.api.cloud.yandex.net/iam/v1/apiKeys
