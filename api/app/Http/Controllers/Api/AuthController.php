<?php

namespace App\Http\Controllers\Api;

use PDO;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\ResetPasswordDto;
use App\Http\Requests\User\UpdateProfileDto;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AuthController extends Controller
{
    public function __construct(private UserService $userService, private AuthService $authService) { }

    // /**
    //  * Create User
    //  * @param Request $request
    //  * @return User
    //  */
    // public function createUser(UserRequest $request): JsonResponse
    // {
    //     try {
    //         $this->userService->store($request);

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'User Created Successfully',
    //         ], 200);

    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => $th->getMessage()
    //         ], 500);
    //     }
    // }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(LoginRequest $request): JsonResponse
    {
        try {
            if ($this->authService->isUserBlocked($request)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Ваш аккаунт заблокирован',
                ], 401);
            }
            $token = $this->authService->login($request);
            if ($token) {
                return response()->json([
                        'status' => true,
                        'message' => 'User Logged In Successfully',
                        'token' => $token,
                        'role' => $this->authService->getAuthenticatedUser($token)->role()->get()
                    ],
                    200
                );
            }

            return response()->json([
                'status' => false,
                'message' => 'Неверные данные',
            ], 401);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getUser(Request $request)
    {
        $user = $this->authService->getAuthenticatedUser($request->only('token')["token"]);
        return response()->json(
            new UserResource(
                $user
            )
        );
    }

    //TODO is it a good idea to implement it via middleware?

    public function confirmPassord(Request $request)
    {
        $allowed = $this->authService->confirmPassord($request);

        return response()->json(["allowed" => $allowed], $allowed ? 200 : 403);
    }

    public function resetPassword(ResetPasswordDto $dto): JsonResponse
    {
        try {
            return response()->json(["success" => $this->authService->resetPassword($dto)]);
        } catch (\Throwable $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function updateProfile(UpdateProfileDto $dto)
    {
        try {
            return response()->json(new UserResource(
                $this->authService->updateProfile($dto)
            ));
        } catch (\Throwable $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function logoutUser(Request $request): void
    {
        $request->user()->currentAccessToken()->delete();
    }

    //TODO move all try-catch to middleware
    public function getProfileAvatar(): Response|BinaryFileResponse|JsonResponse
    {
        try {
            $file = $this->authService->getProfileAvatar();

            if ($file) {
                return response()->file(
                    $file
                );
            }

            return new Response();
        } catch (\Throwable $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
}
