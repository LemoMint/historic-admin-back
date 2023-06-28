<?php


namespace Tests\Feature\Http\Controllers;

use App\Models\PublishingHouse;
use Tests\Feature\Http\TestUsers;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PublishingHouseResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PublishingHouseControllerTest extends TestUsers
{
    use RefreshDatabase;
    use WithoutMiddleware;

    private const ROUTE = self::DEFAULT_ROUTE.'/publishing-houses';

    public function test_get_method_ok()
    {
        PublishingHouse::factory()->count(5)->create();
        $this->actingAs($this->adminUser);
        $response = $this->get(self::ROUTE);

        $this->assertTrue($response->isOk());
        $this->assertEquals(PublishingHouseResource::collection(PublishingHouse::all())->toJson(), $response->getContent());
    }

    public function test_get_method_with_search()
    {
        $assertHouseFound = PublishingHouse::factory()->create([
            'name' => "ОНИКС",
            'address' => "г. Москва, ул тестовая"
        ]);

        $assertHouseFound2 = PublishingHouse::factory()->create([
            'name' => "Оникс1",
            'address' => "г. Новосибирск, ул новая"
        ]);

        PublishingHouse::factory()->create([
            'name' => "Интеллект",
            'address' => "Тест"
        ]);

        $this->actingAs($this->adminUser);
        $response = $this->get(self::ROUTE.'?_search=ОНИКС');

        $this->assertTrue($response->isOk());
        $this->assertEquals(PublishingHouseResource::collection([$assertHouseFound, $assertHouseFound2 ])->toJson(), $response->getContent());
    }


    public function test_create_item_method_ok()
    {
        $this->actingAs($this->user);

        $response = $this->post(self::ROUTE, [
            'name' => "new test",
            'address' => "new test"
        ]);

        $this->assertTrue($response->isOk());
    }

    public function test_update_item_method_ok()
    {
        $this->actingAs($this->user);
        $publishingHouse = PublishingHouse::factory()->create();

        $response = $this->put(self::ROUTE."/".$publishingHouse->id, [
            'name' => "new test updated",
            'address' => "new test"
        ]);

        $this->assertTrue($response->isOk());
    }

    public function test_delete_item_method_ok()
    {
        $this->actingAs($this->user);
        $publishingHouse = PublishingHouse::factory()->create();

        $response = $this->delete(self::ROUTE."/".$publishingHouse->id);

        $this->assertTrue($response->isOk());
    }
}
