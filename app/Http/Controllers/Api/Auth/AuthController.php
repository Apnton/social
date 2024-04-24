<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\LoginAction;
use App\Actions\Auth\LogoutAction;
use App\Actions\Auth\RegistrationAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;


class AuthController extends Controller
{
    use ApiResponser;

    public function signUp(RegistrationRequest $request, RegistrationAction $action): JsonResponse
    {
        try {
            $user = $action->execute($request->get('name'), $request->get('email'), $request->get('password'));
            return $this->successResponse($user, 'We have sent you a confirmation email');
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }
    }

    public function signIn(LoginRequest $request, LoginAction $action): JsonResponse
    {
        return $this->successResponse($action->execute($request->get('email'), $request->get('password')));
    }

    public function logout(LogoutAction $action)
    {
        $action->execute();

        return $this->emptyResponse();
    }
//
//    public function verifyEmail(Request $request)
//    {
//        dd($request->all());
//    }
}
