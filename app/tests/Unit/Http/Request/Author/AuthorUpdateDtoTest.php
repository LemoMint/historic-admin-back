<?php

namespace Tests\Unit\Http\Request\Author;

use App\Http\Requests\Author\AuthorUpdateDto;
use Tests\TestCase;
use Illuminate\Support\Facades\Validator;

class AuthorUpdateDtoTest extends TestCase
{
    protected array $rules;

    public function setUp(): void
    {
        parent::setUp();

        $request = new AuthorUpdateDto();

        $this->rules = $request->rules();
    }

    public function test_request_validation_errors()
    {
        $validator = Validator::make([], $this->rules);

        $this->assertFalse($validator->passes());
        $this->assertContains('name', $validator->errors()->keys());
        $this->assertContains('surname', $validator->errors()->keys());
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
