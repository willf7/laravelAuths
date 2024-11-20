<?php

namespace App\Http\Controllers;

use App\Actions\User\ListUsers;
use App\Actions\User\LoginUser;
use App\Actions\User\LoginUserWithGoogle;
use App\Actions\User\RegisterUser;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    protected $registerUser;
    protected $loginUser;
    protected $loginUserWithGoogle;

    public function __construct(
        RegisterUser $registerUser,
        LoginUser $loginUser,
        LoginUserWithGoogle $loginUserWithGoogle
    )
    {
        $this->registerUser = $registerUser;
        $this->loginUser = $loginUser;
        $this->loginUserWithGoogle = $loginUserWithGoogle;
    }

    public function register(Request $request)
    {
        return $this->registerUser->execute($request);
    }

    public function login(Request $request)
    {
        return $this->loginUser->execute($request);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function loginWithGoogle()
    {
        return $this->loginUserWithGoogle->execute();
    }

}