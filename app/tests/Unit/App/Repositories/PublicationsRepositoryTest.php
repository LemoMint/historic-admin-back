<?php


namespace Tests\Unit\App\Repositories;

use Mockery;
use Tests\TestCase;
use App\Models\User;
use App\Models\Author;
use App\Models\Document;
use App\Models\Publication;
use App\Models\PublishingHouse;
use Illuminate\Support\Facades\Auth;
use App\Repositories\AuthorRepository;
use Database\Seeders\PublicationSeeder;
use App\Repositories\PublicationRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PublicationsRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    protected $seeder = PublicationSeeder::class;

    protected PublicationRepository $publicationRepository;

    public function setUp( ): void
    {
        $this->publicationRepository = new PublicationRepository();

        parent::setUp();
    }

    public function test_repository_returns_appropriate_fields()
    {
        $expectedPublicationId = Publication::first()->id;

        $publication = $this->publicationRepository->find($expectedPublicationId);
        $publicationFileds = $publication->toArray();

        $this->assertArrayHasKey('id', $publicationFileds);
        $this->assertArrayHasKey('name', $publicationFileds);
        $this->assertArrayHasKey('description', $publicationFileds);
        $this->assertArrayHasKey('publication_year', $publicationFileds);
        $this->assertArrayHasKey('publication_century', $publicationFileds);
        $this->assertArrayHasKey('created_at', $publicationFileds);
        $this->assertArrayHasKey('updated_at', $publicationFileds);
        $this->assertArrayHasKey('deleted_at', $publicationFileds);

        $this->assertInstanceOf(Document::class, $publication->document);
        $this->assertInstanceOf(PublishingHouse::class, $publication->publishingHouse);

        foreach ($publication->authors as $author) {
            $this->assertInstanceOf(Author::class, $author);
        }
    }

    public function test_find_method()
    {
        $expectedPublicationId = Publication::factory()->count(1)->create()->first()->id;

        $actualPublication = $this->publicationRepository->find($expectedPublicationId);
        $expectedPublication = Publication::with(['document', 'user', 'authors'])->find($expectedPublicationId);

        $this->assertEquals($actualPublication, $expectedPublication);
    }

    public function test_all_count_method()
    {
        $expectedAuthorsCount = count(Publication::all());
        $actualAuthorsCount = count($this->publicationRepository->all());

        $this->assertTrue($expectedAuthorsCount !== 0);
        $this->assertEquals($expectedAuthorsCount, $actualAuthorsCount);
    }

}
