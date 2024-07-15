<?php

namespace Tests\Unit;

use App\Exceptions\InvalidHeadersException;
use App\Services\CsvUploadService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Mockery\MockInterface;
use Tests\TestCase;

class CsvUploadServiceTest extends TestCase
{
    private CsvUploadService $service;

    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new CsvUploadService();
    }

    public function testValidationPasses(): void
    {
        $headers = ['name', 'color'];
        $result = $this->service->validateHeaders($headers);
        $this->assertTrue($result);
    }

    public function testValidationFails(): void
    {
        $headers = ['name', 'colour', 'test'];
        $this->expectException(InvalidHeadersException::class);
        $this->service->validateHeaders($headers);
    }

    public function testUploadFiles()
    {
        // If we are going to mock. Let's mock as little as possible.
        $headers = ['name', 'color'];
        $data = ['apple', 'red'];
        $fileName = 'fruit.csv';
        $mock = $this->partialMock(CsvUploadService::class, function (MockInterface $mock) {
            $mock->shouldReceive('processRecords')
                ->once()
                ->andReturn(true);
        });
        $file = UploadedFile::fake()
            ->createWithContent(
                $fileName,
                implode(',', $headers).PHP_EOL.implode(',', $data)
            );
        $mock->uploadFile($file, []);
    }
}
