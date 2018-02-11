<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;

class GameController extends Controller
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

    public function StartGame(Request $request) {

      $game = new Game;
      $game->active = 1;
      $game->level = 1;
      $game->user()->associate($request->user->id);
      $game->save();

      return $game;
    }

    public function EndGame() {
      return "test";
    }

    public function GenerateRound() {
      return "test";
    }

    public function SubmitRound() {
      return "test";
    }

}
