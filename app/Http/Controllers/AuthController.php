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

      return redirect('/');

    }

    public function login(Request $request) {
      $this->validate($request, [
        "email" => "required|email",
        "password" => "required",
        //todo require other parameters
      ]);

      if($request->client_id != "Ll7K65x9a8EpEEw9vsPto3u25FVMWLIqrgoA") {
        return response()->json(['message' => 'Invalid client'], 400);
      }

      $user = User::where('email', $request->email)->first();

      if($user == NULL) {
        return response()->json(['message' => 'Invalid username or password'], 401);
      }

      if(app('hash')->check($request->password, $user->password)) {

        $redirect_uri = $request->redirect_uri . "#state=" . $request->state . "&access_token=" . $user->alexa_token . "&token_type=Bearer";
        return response()->json([ 'link' => $request->input('redirect_uri') . '#state=' . $request->input('state') .'&access_token=' . $user->alexa_token . '&token_type=bearer' ], 200);

      } else {

        return response()->json(['message' => 'Invalid username or password'], 401);
      }

    }










}
