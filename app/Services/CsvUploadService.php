<?php

namespace App\Services;

use App\Exceptions\InvalidHeadersException;
use Exception;
use Illuminate\Http\UploadedFile;

class CsvUploadService
{
    public function validateHeaders(array $fileHeaders): true
    {
        $allowedHeaders = ['name', 'color'];
        if (
            array_diff($fileHeaders, $allowedHeaders) !=
            array_diff($allowedHeaders, $fileHeaders)
        ) {
            throw new InvalidHeadersException(
                'Headers in file are not correct. Only '.implode(',', $allowedHeaders).' are allowed.'
            );
        }

        return true;
    }

    public function uploadFile(UploadedFile $file): int
    {
        try {
            $handle = fopen($file, 'r');
            if (! $handle) {
                throw new Exception('There is a failure while opening file.');
            }
            $fileHeaders = fgetcsv($handle);
            $this->validateHeaders($fileHeaders);
            $result = $this->processRecords($handle);
            fclose($handle);

            return $result;
        } catch (\Throwable $e) {
            throw $e;
            fclose($handle);
        }
    }

    public function processRecords($handle): int
    {
        $numConnections = 0;

        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            $numConnections++;
        }

        return $numConnections;
    }
}
