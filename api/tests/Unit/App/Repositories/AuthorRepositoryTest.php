<?php


namespace Tests\Unit\App\Repositories;

use Tests\TestCase;
use App\Models\Author;
use Illuminate\Support\Facades\Auth;
use App\Repositories\AuthorRepository;

class AuthorRepositoryTest extends TestCase
{
    protected AuthorRepository $authorRepository;

    public function setUp( ): void
    {
        $this->authorRepository = new AuthorRepository();

        parent::setUp();
    }

    public function test_repository_returns_appropriate_fields()
    {
        $expectedAuthorId = Author::factory()->count(1)->create()->first()->id;

        $author = $this->authorRepository->find($expectedAuthorId)->toArray();

        $this->assertArrayHasKey('id', $author);
        $this->assertArrayHasKey('name', $author);
        $this->assertArrayHasKey('surname', $author);
        $this->assertArrayHasKey('patronymic_name', $author);
        $this->assertArrayHasKey('created_at', $author);
        $this->assertArrayHasKey('updated_at', $author);
    }

    public function test_find_method()
    {
        $expectedAuthorId = Author::factory()->count(1)->create()->first()->id;

        $actualAuthor = $this->authorRepository->find($expectedAuthorId);
        $expectedAuthor = Author::find($expectedAuthorId);

        $this->assertEquals($expectedAuthor, $actualAuthor);
    }

    public function test_all_count_method()
    {
        $expectedAuthorsCount = count(Author::all());
        $actualAuthorsCount = count($this->authorRepository->all(null));

        $this->assertTrue($expectedAuthorsCount !== 0);
        $this->assertEquals($expectedAuthorsCount, $actualAuthorsCount);
    }
}
