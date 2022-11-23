<?php


namespace Tests\Unit\Http\Resources;


use App\Http\Resources\AuthorResource;
use Tests\TestCase;
use App\Models\Author;

class AuthorResourceTest extends TestCase
{
    public function test_author_resource()
    {
        $author = Author::factory()->create([
            'name' => 'test',
            'surname' => 'test'
        ]);

        $authorResponseDto = new AuthorResource($author);

        $this->assertEquals(Author::find($author->id)->toArray(), json_decode($authorResponseDto->toJson(), true));
    }
}
