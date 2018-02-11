<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class AlexaOAuthToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      $access_token = $request->bearerToken();

      $user = User::where('alexa_token', $access_token)->first();

      if (is_null($user)) {
          return response('Unauthorized.', 401);
      }

      $request->user = $user;
      return $next($request);
    }
}
