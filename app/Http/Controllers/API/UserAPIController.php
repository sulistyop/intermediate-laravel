<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserAPIController extends BaseController
{
    /**
     * Login api
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
           'email' => 'required|email'
        ]);
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['email'] =  $user->email;

            return $this->sendResponse($success, 'User login successfully.');
        }
        else{
            return $this->sendError('Unauthorised.', ['error'=> 'Email atau Password anda salah']);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return $this->sendError('Validasi Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $createToken = $user->createToken('MyApp')->plainTextToken;
        $success['token'] =  $createToken;
        $success['email'] =  $user->email;

        return $this->sendResponse($success, 'Pendaftaran Berhasil dilakukan.');
    }
}
