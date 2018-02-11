<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use Webpatser\Uuid\Uuid;


class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //
    public function register(Request $request) {
      $this->validate($request, [
        "email" => "required|email",
        "password" => "required|confirmed",
        "password_confirmation" => "required"
      ]);

      if(User::where('email', $request->email)->first()) {
          $message = "User account already exists with email: " . $request->email;
          return response()->json(['message' => $message ], 409);
      }

      $user = new User;
      $user->email = $request->email;
      $user->password = app('hash')->make($request->password);
      $alexa_token = Uuid::generate(4)->string;
      $user->alexa_token = $alexa_token;
      $user->save();

      return response()->json(['message' => 'Account created with email: ' . $request->email], 200);
    }

    public function login(Request $request) {
      $this->validate($request, [
        "email" => "required|email",
        "password" => "required",
      ]);

      $user = User::where('email', $request->email)->first();

      if($user == NULL) {
        return response()->json(['message' => 'Invalid username or password'], 401);
      }

      if(app('hash')->check($request->password, $user->password)) {
        return response()->json($user);
      } else {
        return response()->json(['message' => 'Invalid username or password'], 401);
      }

    }










}
