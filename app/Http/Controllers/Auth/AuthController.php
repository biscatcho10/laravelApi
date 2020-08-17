<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public $loginAfterSignUp = true;

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|unique:users|max:255',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = auth()->login($user);
        return $this->respondWithToken($token);
    }



    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|string|max:255',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator);
        }

        $credentails = $request->only(['email', 'password']);

        try {
            if(!$token = auth()->attempt($credentails) ){
                return response()->json(['error' => 'You Are Unothorized'],401);
            }

        } catch (\Exception $tex) {
            return response()->json(['error' => 'Could Not Create Token'],500);
        }

        return $this->respondWithToken($token);
    }




    public function getAuthUser(Request $request)
    {
        return response()->json(auth()->user());
    }



    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }


    protected function respondWithToken($token)
    {
      return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth()->factory()->getTTL() * 60
      ]);
    }

}
