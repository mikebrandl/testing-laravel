<?php

namespace App\Services;

use App\Exceptions\InvalidHeadersException;

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
}
