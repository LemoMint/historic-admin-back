<?php


namespace App\Services;

use App\Models\Role;
use App\Models\User;
use App\Http\Requests\SortRequest;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\UserCreateDto;
use App\Http\Requests\User\UserUpdateDto;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(private UserRepository $userRepository) { }

    public function getAll(SortRequest $search)
    {
        return $this->userRepository->all($search, Auth::user()->isSuperAdmin());
    }

    public function find(int $id): ?User
    {
        return $this->userRepository->find($id, Auth::user()->isSuperAdmin());
    }

    public function store(UserCreateDto $userDto)
    {
        $user = new User($userDto->safe()->all());
        $user->password = Hash::make($userDto->safe()->only('password')["password"]);
        $user->save();

        return $user;
    }

    public function update(UserUpdateDto $userDto, User $user): User
    {
        $role = null;
        $oldPassword = $user->password;
        $newPassword = $userDto->safe()->only('password')['password'];

        $user->fill($userDto->safe()->all());

        if (!$newPassword) {
            $user->password = Hash::make($oldPassword);
        } else {
            $user->password = Hash::make($newPassword);
        }

        $user->update();

        return $user;
    }

    public function destroy(User $user): void
    {
        $user->forceDelete();
    }

    public function block(User $user): void
    {
        if ($user->deleted_at ) {
            $user->restore();

            $user->deleted_at = null;
            $user->save();
        } else {
            $user->delete();
        }
    }
}
