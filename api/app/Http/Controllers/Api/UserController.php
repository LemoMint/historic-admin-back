<?php

namespace App\Http\Controllers\Api;

use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\SortRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\User\UserCreateDto;
use App\Http\Requests\User\UserUpdateDto;

class UserController extends Controller
{
    public function __construct(private UserService $userService) {}

    public function index(SortRequest $request): JsonResponse
    {
        return response()->json(UserResource::collection(
            $this->userService->getAll($request)
        ));
    }

    public function show($id): JsonResponse
    {
        return response()->json(
            new UserResource(
                $this->userService->find($id)
            )
        );
    }

    public function store(UserCreateDto $dto): JsonResponse
    {
        return response()->json(new UserResource(
            $this->userService->store($dto)
        ));
    }

    public function update(UserUpdateDto $dto, int $id): JsonResponse
    {
        $user = $this->userService->find($id);

        $this->authorize('update', $user);

        return response()->json(new UserResource(
            $this->userService->update($dto, $user)
        ));
    }

    public function destroy(int $id): void
    {
        $user = $this->userService->find($id);

        $this->authorize('delete', $user);

        $this->userService->destroy($user);
    }

    public function block(int $id): void
    {
        $user = $this->userService->find($id);

        $this->authorize('block', $user);

        $this->userService->block($user);
    }
}
