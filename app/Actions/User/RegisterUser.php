<?php

namespace App\Actions\User;

use App\Exceptions\CustomException;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class RegisterUser
{
    public function execute(Request $request)
    {
        $response = [
            'message' => '',
            'code' => 0,
            'error' => false,
            'data' => []
        ];

        try {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|string|email|unique:users,email',
                'birthDate' => 'required|date',
                'password' => 'required|string|min:6'
            ]);

            if ($validator->fails()) {
                throw new CustomException($validator->errors()->first(), 400);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            $response['message'] = 'User created successfully';
            $response['code'] = 201;
            $response['data'] = [
                'name' => $user->name,
                'email' => $user->email
            ];
        } catch (CustomException $customE) {
            $response['message'] = $customE->getMessage();
            $response['code'] = $customE->getCode();
            $response['error'] = true;
        } catch (Exception $e) {
            $response['message'] = 'Something went wrong, please try again later.';
            $response['code'] = 500;
            $response['error'] = true;
        }

        return response()->json($response);
    }
}