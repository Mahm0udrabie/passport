<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiAuthController extends Controller
{
    protected $model;
    public function __construct(User $user)
    {
        $this->model = $user;
    }
    public function register (Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $request['password']=Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $user = $this->model->create(array_merge($request->toArray(), [
            'api_token' => bcrypt(Str::random(20)),
            'channel'  => $this->create_uuid(),
        ]));
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token' => $token];
        return response()->json(
            [
                "status" => "success",
                "data"   =>  $user,
                "token"  => $response, 
            ],
            200
        );
    }
    public function login (Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = array_merge($user->toArray(), ["token"=>$token]);
                return response()->json([
                    "status" => "success",
                    "data" => $response
                ], 200);
            } else {
                $response = ["message" => "Password mismatch"];
                return response(new UserResource($response), 422);
            }
        } else {
            $response = ["message" =>'User does not exist'];
            return response($response, 422);

        }
    }
    public function logout(Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
    private function create_uuid() {
        return time()."-".Str::random(5)."-".Str::random(5)."-".Str::random(5)."-".Str::random(5);
    }
}
