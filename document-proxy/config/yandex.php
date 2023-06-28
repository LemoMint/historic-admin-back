<?php

return [
    'IAmToken' => [
        'getByFunctionUrl' =>env("YANDEX_I_AM_TOKEN_URL")
    ],
    'ApiToken' => [
        'getByUrl' => env('YANDEX_API_TOKEN_URL')
    ],
    'ServiceAccount' => env('YANDEX_SERVICE_ACCOUNT_IDENTIFER'),
    'FolderIdentifer' => env('YANDEX_FOLDER_iDENTIFER'),
    'OcrUrl' => env('YANDEX_OCR_URL')
];
