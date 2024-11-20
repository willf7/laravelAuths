<?php

namespace App\Actions\User;

use App\Models\User;
use App\Exceptions\CustomException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginUser
{
    public function execute(Request $request): object
    {
        $response = [
            'message' => '',
            'code' => 0,
            'error' => false,
            'data' => []
        ];

        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email',
                'password' => 'required|string|min:6'
            ]);

            if ($validator->fails()) {
                throw new CustomException('Email or password invalid, please try again.', 400);
            }

            $user = User::where('email', $request->email)->first();

            // if (!$user->hasVerifiedEmail()) {
            //     throw new CustomException('Email not verified. Please verify your email before logging in.', 400);
            // }

            if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                throw new CustomException('Email or password invalid, please try again.', 400);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            $response['message'] = 'User logged successfully';
            $response['code'] = 200;
            $response['data'] = [
                'authorization' => [
                    'token' => $token
                ]
            ];
        } catch (CustomException $customE) {
            $response['message'] = $customE->getMessage();
            $response['code'] = $customE->getCode();
            $response['error'] = $customE->getError();
        } catch (Exception $e) {
            $response['message'] = 'Something went wrong, please try again later.';
            $response['code'] = 500;
            $response['error'] = true;
        }

        return response()->json($response);
    }
}