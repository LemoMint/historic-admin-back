<?php


namespace Tests\Unit\Http\Request;

use Tests\TestCase;
use App\Models\Author;
use App\Models\PublishingHouse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Publication\PublicationUpdateDto;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PublicationRequestTest extends TestCase
{
    use DatabaseTransactions;
    protected array $rules;
    public function setUp(): void
    {
        parent::setUp();

        $request = new PublicationUpdateDto();
        $this->rules = $request->rules();
    }

    public function test_request_passes_validation()
    {
        $authorsData = Author::all('id')->toArray();
        $authorsIds = [];

        foreach ($authorsData as $key => $id) {
            $authorsIds[] = $id["id"];
        }

        Storage::fake('test');

        $validator = Validator::make([
            'name' => 'test',
            'description' => 'test',
            'publishing_house' => PublishingHouse::first()->id,
            'document' =>  UploadedFile::fake()->create('test.pdf'),
            'authors' => [
                $authorsIds
            ],
            'publication_year' => 2022,
            'publication_century' => 22
        ],
            $this->rules
        );

        $this->assertTrue($validator->passes());
    }

    public function test_model_entity_does_not_exists()
    {
        $latestId = Author::get()->last()->id;
        $validator = Validator::make([
                'authors' => [$latestId + 1]
            ],
            $this->rules
        );

        $this->assertFalse($validator->passes());
        $this->assertEquals('The selected authors.0 is invalid.', $validator->errors()->messages()['authors.0'][0]);
    }

    public function test_numeric_failed()
    {
        $validator = Validator::make([
                'publication_year' => 3000
            ],
            $this->rules
        );

        $this->assertFalse($validator->passes());
        $this->assertContains('publication_year', $validator->errors()->keys());
    }
}
