<?php

namespace App\Services;

use App\Helpers\FileHelper;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Requests\User\ResetPasswordDto;
use App\Http\Requests\User\UpdateProfileDto;
use Faker\Core\File;
use Psy\CodeCleaner\AssignThisVariablePass;

class AuthService
{
    public function login(LoginRequest $request)
    {
        if(!Auth::attempt($request->safe()->only(['email', 'password']))){
            return false;
        }

        $user = User::where('email', $request->email)->first();
        return $user->createToken("API TOKEN", [], now()->addDays(30))->plainTextToken;
    }

    public function getAuthenticatedUser(string $token): ?User
    {
        $token = PersonalAccessToken::findToken($token);

        $user = User::find($token->tokenable_id);

        if (!$user->deleted_at) {
            return $user;
        }

        return null;
    }

    public function isUserBlocked(LoginRequest $request)
    {
        return User::withTrashed()->where('email', $request->safe()->only(['email'])['email'])->first()->deleted_at;
    }

    public function confirmPassord(Request $request): bool
    {
        return Auth::attempt($request->only(['email', 'password']));
    }

    public function resetPassword(ResetPasswordDto $dto): bool
    {
        if (null !== $user = Auth::user()) {
            $user->password =  Hash::make($dto->safe()->only('password')['password']);

            return $user->save();
        }

        return false;
    }

    public function updateProfile(UpdateProfileDto $dto): ?User
    {
        $user = $user = Auth::user();

        if ($user != null) {
            $user->fill($dto->safe()->all());

            $avatar = $dto->file('avatar');

            if ($avatar && null !== $filePath = FileHelper::saveFile($avatar, User::AVATARS_DEFAULT_DISK)) {
                $user->avatar = $filePath;
            } else if (null !== $avatar = $user->avatar) {
                FileHelper::deleteFile($avatar, User::AVATARS_DEFAULT_DISK);
                $user->avatar = null;
            }

            $user->save();
        }

        return $user;
    }

    public function getProfileAvatar(): ?string
    {
        if (null != $avatar = Auth::user()->avatar) {
            return FileHelper::generateFilePathByName($avatar, User::AVATARS_DEFAULT_DISK);
        }

        return null;
    }
}
