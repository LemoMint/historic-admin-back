<?php


namespace App\Services;

use App\Repositories\RoleRepository;
use Illuminate\Database\Eloquent\Collection;

class RoleService
{
    public function __construct(private RoleRepository $roleRepository) {}

    public function getAll(): Collection
    {
        return $this->roleRepository->all();
    }
}
