<?php

namespace Tests\Unit\Http\MIddleware;

use Tests\Unit\Http\TestUsers;
use Laravel\Sanctum\Sanctum;

class AuthMiddleware extends TestUsers
{
    // public function test_forbiden_guest()
    // {
    //     Sanctum::actingAs(
    //         $this->user,
    //         ['*']
    //     );

    //     $response = $this->get('/api/v1/auth/logout');

    //     $response->assertOk();
    // }

    // public function test_allowed_user()
    // {
    //     $response = $this->get('/api/v1/auth/logout');

    //     $response->assertForbidden();
    // }
}
