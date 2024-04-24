<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginAction
{
    public function execute(string $email, string $password): array
    {
        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password))
            throw ValidationException::withMessages(['email' => ['The provided credentials are incorrect.']]);

        if (!$user->hasVerifiedEmail())
            throw ValidationException::withMessages(['email' => ['Please confirm your email.']]);

        return ['token' => $user->createToken(config('app.name'))->plainTextToken];
    }
}
