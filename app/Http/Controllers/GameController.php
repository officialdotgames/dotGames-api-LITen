<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;
use App\Sequence;
use App\Color;
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
      $game->level = 0;
      $game->user()->associate($request->user->id);
      $game->save();

      return $game;
      }

      public function EndGame() {
      return "test";
      }

      //convert to async
      public function GenerateRound(Request $request) {

        $ids = array("id:d073d532ad4f", "id:d073d5123b9f", "id:d073d52013c2", "id:d073d511fe55", "id:d073d532ad22");
        $colors = array("red", "purple", "blue", "green", "yellow", "orange");
        shuffle($ids);
        shuffle($colors);

        $game = Game::where('user_id', $request->user->id)->where('active', 1)->first();
        if($game == null) {
          return response()->json(['message' => 'Create a game first.'], 400);
        }
        $game->level = $game->level + 1;
        $game->save();

        LifxApi::setSelectorProperity('group:AshOffice', 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', null, "off");

        $current_color = 0;
        foreach($ids as $id) {
          LifxApi::setSelectorProperity($id, 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', $colors[$current_color], "on");
          $current_color++;
          LifxApi::setSelectorProperity($id, 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', null, "off");

          $color = Color::where('color', $colors[$current_color])->first();

          $sequence = new Sequence;
          $sequence->level = $game->level;
          $sequence->order = $current_color;
          $sequence->game()->associate($game->id);
          $sequence->color()->associate($color->id);
          $sequence->save();
        }

        LifxApi::setSelectorProperity('group:AshOffice', 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', "cyan", "off");
        LifxApi::setSelectorProperity('group:AshOffice', 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', "cyan", "on", 5);


        return "prompt user now";
    }

    public function SubmitRound(Request $request) {

      $this->validate($request, [
        "sequence" => "required"
      ]);
      $game = Game::where('user_id', $request->user->id)->where('active', 1)->first();

      if($game == null) {
        return response()->json(['message' => 'Create a game first.'], 400);
      }

      $correct_sequence = Sequence::where('level', $game->level)
                            ->where('game_id', $game->id)
                            ->orderBy('order', 'asc')
                            ->get();
      $user_sequence = explode(" ", $request->sequence);

      for($i = 0; $i < count($correct_sequence); $i++) {
        $color = Color::where('id', $correct_sequence[$i]->color_id)->first();
        if($user_sequence[$i] != $color->color) {

          $game->active = 0;
          $game->save();
          LifxApi::setSelectorProperity('group:AshOffice', 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', "red", "on");
          LifxApi::setSelectorProperity('group:AshOffice', 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', "cyan", "off");
          LifxApi::setSelectorProperity('group:AshOffice', 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', "cyan", "on");

          return response()->json(['correct' => false, 'score' => $game->level]);

          //make lights red
        }
      }
      LifxApi::setSelectorProperity('group:AshOffice', 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', "cyan", "off");
      LifxApi::setSelectorProperity('group:AshOffice', 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', "green", "on");
      LifxApi::setSelectorProperity('group:AshOffice', 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', "cyan", "off");
      LifxApi::setSelectorProperity('group:AshOffice', 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', "cyan", "on", 5);
      return response()->json(['correct' => true ]);

      //make lights green
    }

}
