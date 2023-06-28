<?php


namespace Tests\Feature\Http;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;

class TestUsers extends TestCase
{
    use RefreshDatabase;

    protected const DEFAULT_ROUTE = '/api/v1';
    protected User $adminUser;
    protected User $superAdminUser;
    protected User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user =  User::where('role_id', null)->first();
        $this->adminUser = User::where('role_id', Role::getAdmin()->id)->first();
        $this->superAdminUser = User::where('role_id', Role::getSuperAdmin()->id)->first();
    }
}
