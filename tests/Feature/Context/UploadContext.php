<?php

namespace Tests\Feature\Context;

use App\Services\CsvUploadService;
use Behat\Behat\Context\SnippetAcceptingContext;
use Illuminate\Http\UploadedFile;
use Illuminate\Testing\Assert;

class UploadContext implements SnippetAcceptingContext
{
    private UploadedFile $file;

    private CsvUploadService $csvUploadService;

    private int $count = 0;

    public function __construct()
    {
        $this->csvUploadService = new CsvUploadService();
    }

    /**
     * @Given there is a :arg1 file, with headers :headers and one row of data
     */
    public function thereIsAFileWithHeadersNameColorAndOneRowOfData($arg1, $arg2)
    {
        $headers = ['name', 'color'];
        $data = ['apple', 'red'];
        $fileName = 'fruit.csv';

        $this->file = UploadedFile::fake()
            ->createWithContent(
                $fileName,
                implode(',', $headers).PHP_EOL.implode(',', $data));
    }

    /**
     * @When I upload the file
     */
    public function iUploadTheFile()
    {
        $this->count = $this->csvUploadService->uploadFile($this->file);
    }

    /**
     * @Then I should have a count of :arg1 in response.
     */
    public function iShouldHaveACountOfInResponse($arg1)
    {
        Assert::assertEquals($arg1, $this->count);
    }
}
