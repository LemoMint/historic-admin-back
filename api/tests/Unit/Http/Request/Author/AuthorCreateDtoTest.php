<?php


namespace Tests\Unit\Http\Request\Author;

use Tests\TestCase;
use App\Models\Author;
use Database\Seeders\PublicationSeeder;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Author\AuthorCreateDto;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthorCreateDtoTest extends TestCase
{
    use DatabaseTransactions;

    protected $seeder = PublicationSeeder::class;
    protected array $rules;

    public function setUp(): void
    {
        parent::setUp();

        $request = new AuthorCreateDto();

        $this->rules = $request->rules();
    }

    public function test_request_validation_errors()
    {
        $validator = Validator::make([], $this->rules);

        $this->assertFalse($validator->passes());
        $this->assertContains('name', $validator->errors()->keys());
        $this->assertContains('surname', $validator->errors()->keys());
    }

    public function test_request_validation_errors_already_exists()
    {
        $author = Author::first();
        $customInput = ['name' => $author->name, 'surname' => $author->surname, 'patronymic_name' => $author->patronymic_name];
        $dto = new AuthorCreateDto($customInput);
        $customRules = $dto->rules();

        $validator = Validator::make($customInput, $customRules);

        $this->assertFalse($validator->passes());
        $this->assertContains('name', $validator->errors()->keys());
    }

    public function test_semi_filled_request()
    {
        $validator = Validator::make(['name' => 'test'], $this->rules);

        $this->assertFalse($validator->passes());
        $this->assertContains('surname', $validator->errors()->keys());
    }

    public function test_wrong_type_simple_data()
    {
        $vlidator = Validator::make(['surname' => 42], $this->rules);

        $this->assertFalse($vlidator->passes());
        $this->assertContains('surname', $vlidator->errors()->keys());
        $this->assertContains('name', $vlidator->errors()->keys());
    }

    public function test_success_validation()
    {
        $vlidator = Validator::make(['name' => 'test', 'surname' => 'test'], $this->rules);

        $this->assertTrue($vlidator->passes());
    }
}
