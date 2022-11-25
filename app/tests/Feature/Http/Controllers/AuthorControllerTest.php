<?php


namespace Tests\Feature\Http\Controllers;

use App\Models\Author;
use Tests\Feature\Http\TestUsers;
use App\Http\Resources\AuthorResource;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Auth;

class AuthorControllerTest extends TestUsers
{
    use RefreshDatabase;
    use WithoutMiddleware;

    private const ROUTE = self::DEFAULT_ROUTE.'/authors';

    public function test_get_method_ok()
    {
        $this->actingAs($this->adminUser);

        Author::factory()->count(5)->create();
        $response = $this->get(self::ROUTE);

        $this->assertTrue($response->isOk());
        $this->assertEquals(AuthorResource::collection(Author::all())->toJson(), $response->getContent());
    }

    public function test_get_method_with_search()
    {
        $assertAuthorFound = Author::factory()->create([
            'surname' => "Нефедов",
            'name' => "Демид",
            'patronymic_name' => "Васильевич",
        ]);

        $assertAuthorFound2 = Author::factory()->create([
            'surname' => "Петров",
            'name' => "Демид",
            'patronymic_name' => "Нефедович",
        ]);

        Author::factory()->create([
            'surname' => "Раков",
            'name' => "Матвей",
            'patronymic_name' => "Андреевич",
        ]);

        $this->actingAs($this->adminUser);
        $response = $this->get(self::ROUTE.'?_search=Нефедов');

        $this->assertTrue($response->isOk());
        $this->assertEquals(AuthorResource::collection([$assertAuthorFound, $assertAuthorFound2 ])->toJson(), $response->getContent());
    }


    public function test_create_item_method_ok()
    {
        $this->actingAs($this->user);

        $response = $this->post(self::ROUTE, [
            'name' => "new test",
            'surname' => "new test",
            'patronymic_name' => null
        ]);

        $this->assertTrue($response->isOk());
    }

    public function test_update_item_method_ok()
    {
        $this->actingAs($this->user);
        $author = Author::factory()->create();

        $response = $this->put(self::ROUTE."/".$author->id, [
            'name' => "new test updated",
            'surname' => "new test",
            'patronymic_name' => null
        ]);

        $this->assertTrue($response->isOk());
    }

    public function test_delete_item_method_ok()
    {
        $this->actingAs($this->user);
        $author = Author::factory()->create();

        $response = $this->delete(self::ROUTE."/".$author->id);

        $this->assertTrue($response->isOk());
    }
}
