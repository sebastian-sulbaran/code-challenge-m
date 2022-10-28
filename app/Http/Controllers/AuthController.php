<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(Request $request) {
        
        $request->validate([
            'email' => 'string|email|required',
            'password' => 'string|required|max:20',
        ]);

        //Check email
        $user = User::where('email',$request->email)->first();

        //Check password
        if(!$user || !Hash::check($request->password,$user['password'])) {
            return response([
                'message' => 'Check the credentials',
                'status' => "error"
            ],401);
        }

        try {

            $token = $user->createToken($request->email,['test','newAbility'])->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token,
                'message' => 'User was logged in succesfully',
                'status' => "success"
            ];

            return response($response,200);
        } catch (\Throwable $th) {
            return response([
                'message' => 'Something happened while processing the request',
                'status' => "error",
                'error' => $th->getMessage()
            ],400);
        }
    }

    public function logout(Request $request) {
        
        try {
            
            $user = $request->user();
            $user->tokens()->delete();
            
            return response([
                'message' => 'User was logged out succesfully',
                'status' => 'success'
            ],200);
        
        } catch (\Throwable $th) {
            return response([
                'message' => 'User could not be logged out',
                'status' => 'error',
                'error' => $th
            ],400);
        }

    }

    public function me(Request $request)
    {
        $user = $request->user();
        return response()->json($user->toArray(),200);
    }
}
