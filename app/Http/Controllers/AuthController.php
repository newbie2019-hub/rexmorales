<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['create', 'login']]);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }


    public function create(Request $request)
    {
        $this->validate($request, [
            'fname' => 'required',
            'email' => 'bail|required|email|unique:users',
            'password' => 'bail|required|min:6',
        ]);

        User::create([
            'name' => $request->fname,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json(['success' => 'Account created successfuly!'], 200);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Email or Password is incorrect'], 401);
        }
        // $token_validity = 24 * 60;
        // auth()->factory()->setTTL($token_validity);
        return $this->respondWithToken($token);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

}
