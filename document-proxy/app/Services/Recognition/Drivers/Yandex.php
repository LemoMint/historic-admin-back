<?php

namespace App\Services\Recognition\Drivers;

use App\Models\Document;
use Illuminate\Support\Str;
use App\Helpers\FileStorageHelper;
use App\Services\Recognition\Drivers\AbstractDriver;
use Exception;

use function PHPUnit\Framework\countOf;

class Yandex extends AbstractDriver
{
    public function __construct( private string $apiToken) {}

    public function imagesHandle(Document $document): ?string
    {
        $fileEncoded = FileStorageHelper::getBase64File($document);
        $folderId = config('yandex.FolderIdentifer');

        if ($fileEncoded && $folderId) {
            $recognitionBody =[
                "folderId" => $folderId,
                "analyze_specs" => [[
                    "content" => $fileEncoded,
                    "features" => [[
                        "type" => "TEXT_DETECTION",
                        "text_detection_config" => [
                            "language_codes" => ["*"]
                        ]
                    ]]
                ]]
            ];

        $curl = curl_init(config('yandex.OcrUrl'));

        curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json",
                    "Authorization: Api-Key ".$this->apiToken
                ],
                CURLOPT_POSTFIELDS => json_encode($recognitionBody),
            ]);

            $response = curl_exec($curl);
            if (!curl_errno($curl)) {
                $http_code = (int)curl_getinfo($curl, CURLINFO_HTTP_CODE);
                if ($http_code !== 200) {
                    throw new Exception("Recognition error!");
                }

                return $this->parseResult($response);
            }

            throw new Exception("Recognition error!");
        }

        throw new Exception("Recognition configuration error!");
    }

    private function parseResult(string $response): string
    {
        $resultText = "";
        preg_match_all('/\"text\":\s\".*\"/', $response, $out);
        if ( count($out)) {
            foreach  ($out[0] as $wordString) {
                $resultText .= preg_filter(["/\"/", "/text/", "/:/"], "", $wordString);
            }
        }

        return $resultText;
    }
}
