<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request){
        try {
            $validation = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:5',
            ]);

            if (Auth::attempt($validation)) {
                $user = Auth::user();
                $token = $user->createToken('token_formify')->plainTextToken;
                $data = [
                    'name' => $user->name,
                    'email'=> $user->email,
                    'accessToken' => $token,
                ];
                return $this->responseWithSuccess($data, 'Login success', 'user');
            } else {
                return $this->responseWithError('Email or password incorrect', 401);
            }
        } catch (ValidationException $th) {
            return $this->responseWithError('Invalid field', 422, $th->validator->errors());
        } catch (\Exception $e) {
            return $this->responseWithError('Unknown error', 500, $e->getMessage());
        }
    }

    public function logout(){
        Auth::user()->tokens()->delete();
        return response()->json([
            'message'=> 'Logout success'
        ]);
    }
}
