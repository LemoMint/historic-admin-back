<?php


namespace Tests\Feature\Http\Controllers;

use App\Models\Document;
use App\Models\Publication;
use App\Models\PublishingHouse;
use Tests\Feature\Http\TestUsers;
use App\Http\Resources\PublicationResource;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Requests\Publication\PublicationSortRequest;

class PublicationControllerTest extends TestUsers
{
    use WithoutMiddleware;
    use DatabaseTransactions;

    protected $seeder = null;

    private const ROUTE = self::DEFAULT_ROUTE.'/publications';

    public function test_find_all_ok()
    {
        $this->actingAs($this->user);

        Publication::factory()->count(5)->create();

        $response = $this->get(self::ROUTE);

        $this->assertTrue($response->isOk());
        $this->assertEquals(PublicationResource::collection(Publication::all())->toJson(), $response->getContent());
    }

    public function test_find_with_sort()
    {
        $this->actingAs($this->user);

        $pHouse = PublishingHouse::factory()->create();
        $document = Document::factory()->create();

        Publication::factory()->create([
            'name' => "Апубликация",
            'description' => "Аописание",
            'publication_year' => 1999,
            'publication_century' => 20,
            'publishing_house_id' => $pHouse->id,
            'document_id' => $document->id
        ]);

        Publication::factory()->create([
            'name' => ">Бпубликация",
            'description' => "Бописание",
            'publication_year' => 2000,
            'publication_century' => 21,
            'publishing_house_id' => $pHouse->id,
            'document_id' => $document->id
        ]);

        $response = $this->get(self::ROUTE.'?_sortBy=name&_sortOrder=DESC');

        $this->assertTrue($response->isOk());
        $this->assertEquals(PublicationResource::collection(Publication::orderBy('name', 'DESC')->get())->toJson(), $response->getContent());
    }

    public function test_find_with_sort_by_year_and_search()
    {
        $this->actingAs($this->user);

        $pHouse = PublishingHouse::factory()->create();
        $document = Document::factory()->create();

        Publication::factory()->create([
            'name' => "Апубликация",
            'description' => "Аописание",
            'publication_year' => 1999,
            'publication_century' => 20,
            'publishing_house_id' => $pHouse->id,
            'document_id' => $document->id
        ]);

        Publication::factory()->create([
            'name' => ">Бпубликация",
            'description' => "Бописание",
            'publication_year' => 2000,
            'publication_century' => 21,
            'publishing_house_id' => $pHouse->id,
            'document_id' => $document->id
        ]);

        Publication::factory()->create([
            'name' => ">Бпубликация1",
            'description' => "Бописание1",
            'publication_year' => 2004,
            'publication_century' => 21,
            'publishing_house_id' => $pHouse->id,
            'document_id' => $document->id
        ]);

        $response = $this->get(self::ROUTE.'?_sortBy=publication_year&_sortOrder=DESC&_search=Бпублик');

        $this->assertTrue($response->isOk());
        $this->assertTrue(count(json_decode($response->getContent(), true)) === 2);
        $this->assertEquals(PublicationResource::collection(Publication::orderBy('publication_year', 'DESC')->where('name', 'like', '%Бпублик%')->get())->toJson(), $response->getContent());
    }

    public function test_find()
    {
        $this->actingAs($this->user);
        $publication = Publication::factory()->create();

        $response = $this->get(self::ROUTE.'/'.$publication->id);
        $assert = Publication::find($publication->id);

        $this->assertTrue($response->isOk());
        $this->assertEquals(json_encode(new PublicationResource($assert)), $response->getContent());
    }

    public function test_store()
    {
        $this->actingAs($this->user);

    }
}
