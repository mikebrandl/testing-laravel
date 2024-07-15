<?php

namespace Tests\Unit;

use App\Exceptions\InvalidHeadersException;
use App\Services\CsvUploadService;
use PHPUnit\Framework\TestCase;

class CsvUploadServiceTest extends TestCase
{
    public function testValidationPasses(): void
    {
        $headers = ['name', 'color'];
        $service = new CsvUploadService();
        $result = $service->validateHeaders($headers);
        $this->assertTrue($result);
    }

    public function testValidationFails(): void
    {
        $headers = ['name', 'colour', 'test'];
        $this->expectException(InvalidHeadersException::class);
        $service = new CsvUploadService();
        $service->validateHeaders($headers);
    }
}
