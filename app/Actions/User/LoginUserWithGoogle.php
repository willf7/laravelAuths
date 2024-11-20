<?php

namespace App\Actions\User;

use App\Models\User;
use App\Exceptions\CustomException;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class LoginUserWithGoogle
{
    public function execute(): object
    {
        $response = [
            'message' => '',
            'code' => 0,
            'error' => false,
            'data' => []
        ];

        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::updateOrCreate(
                    ['google_id' => $googleUser->getId()],
                    [
                        'name' => $googleUser->getName(),
                        'email' => $googleUser->getEmail(),
                        'password' => bcrypt(Str::random(16)),
                        'birthdate' => null
                    ]
                );

            Auth::login($user);

            $token = $user->createToken('auth_token')->plainTextToken;

            $response['message'] = 'User logged successfully';
            $response['code'] = 200;
            $response['data'] = [
                'authorization' => [
                    'token' => $token
                ]
            ];
        }
        catch (CustomException $customE) {
            $response['message'] = $customE->getMessage();
            $response['code'] = $customE->getCode();
            $response['error'] = $customE->getError();
        }
        catch (Exception $e) {
            $response['message'] = $e->getMessage();
            $response['code'] = 500;
            $response['error'] = true;
        }

        return response()->json($response);
    }
}