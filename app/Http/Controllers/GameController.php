<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;
use App\Libraries\LifxApi;

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

      $games = Game::where('user_id', $request->user->id)->get();

      foreach($games as $game) {
        $game->active = 0;
        $game->save();
      }

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

      public function GenerateRound(Request $request) {

      $ids = array("id:d073d532ad4f", "id:d073d5123b9f", "id:d073d52013c2", "id:d073d511fe55", "id:d073d532ad22");
      $colors = array("red", "purple", "blue", "green", "yellow", "orange");
      shuffle($ids);
      shuffle($colors);

      LifxApi::setSelectorProperity('group:AshOffice', 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', null, "off");

      $current_color = 0;
      foreach($ids as $id) {
        LifxApi::setSelectorProperity($id, 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', $colors[$current_color], "on");
        $current_color++;
      }


      //end round
      LifxApi::setSelectorProperity('group:AshOffice', 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', "cyan", "off");
      LifxApi::setSelectorProperity('group:AshOffice', 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', "cyan", "on", 5);


      return "prompt user now";
    }

    public function SubmitRound(Request $request) {
      return "test";
    }

}
