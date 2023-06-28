<?php

namespace App\Services\Recognition\Drivers;

use Exception;
use App\Models\Document;
use Spatie\PdfToText\Pdf;
use Symfony\Component\Process\Process;
use App\Services\Recognition\Drivers\AbstractDriver;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Local extends AbstractDriver
{
    public function pdfHandle(Document $document): ?string
    {
        $filePath = self::getFilePath($document);

        if ($filePath) {
           return Pdf::getText($filePath);
        }

        throw new Exception("Recognition configuration error!");
    }

    public function mp3Handle(Document $document)
    {
        $filePath = self::getFilePath($document);

        $process = new Process(['python3', '/var/www/proxy/scripts/AudioToText.py', $filePath]);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }

    public function mp4Handle(Document $document)
    {
        $filePath = self::getFilePath($document);

        $process = new Process(['python3', '/var/www/proxy/scripts/VideoToText.py', $filePath]);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }
}
