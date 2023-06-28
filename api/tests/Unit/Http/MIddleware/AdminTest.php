<?php


namespace Tests\Unit\Http\MIddleware;

use App\Http\Middleware\Admin;
use App\Http\Middleware\SuperAdmin;
use Tests\TestCase;
use Illuminate\Http\Request;
use Tests\Unit\Http\TestUsers;

class AdminTest extends TestUsers
{
    public function test_admin_allowed()
    {
        $this->actingAs($this->adminUser);

        $request = Request::create('/roles', 'GET');
        $middleware = new Admin();

        $response = $middleware->handle($request, function () {});

        $this->assertEquals($response, null);
    }

    public function test_not_admin_forbidden()
    {
        $this->actingAs($this->user);

        $request = Request::create('/roles', 'GET');
        $middleware = new Admin();

        $response = $middleware->handle($request, function () {});

        $this->assertEquals($response->getContent(), "Доступ разрешен только админам!");
        $this->assertEquals($response->getStatusCode(), 403);
    }

    public function test_super_admin_allowed()
    {
        $this->actingAs($this->superAdminUser);

        $request = Request::create('/users', 'GET');
        $middleware = new SuperAdmin();

        $response = $middleware->handle($request, function () {});

        $this->assertEquals($response, null);
    }

    public function test_admin_forbidden_to_super_admin_route()
    {
        $this->actingAs($this->adminUser);

        $request = Request::create('/users', 'GET');
        $middleware = new SuperAdmin();

        $response = $middleware->handle($request, function () {});

        $this->assertEquals($response->getStatusCode(), 403);
        $this->assertEquals($response->getContent(), "Доступ разрешен только главным администраторам!");
    }

    public function test_not_admin_forbidden_to_super_admin_route()
    {
        $this->actingAs($this->user);

        $request = Request::create('/users', 'GET');
        $middleware = new SuperAdmin();

        $response = $middleware->handle($request, function () {});

        $this->assertEquals($response->getStatusCode(), 403);
        $this->assertEquals($response->getContent(), "Доступ разрешен только главным администраторам!");
    }
}
