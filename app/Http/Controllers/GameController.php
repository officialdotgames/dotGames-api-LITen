<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;
use App\Sequence;
use App\Color;
use App\Libraries\LifxApi;
use App\Jobs\GenerateJob;
use App\Jobs\SubmitJob;
use App\Jobs\StartGameJob;

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

      $ids = array("id:d073d532ad4f", "id:d073d5123b9f", "id:d073d52013c2", "id:d073d511fe55", "id:d073d532ad22");
      $colors = array("red", "purple", "blue", "green", "yellow");

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

      dispatch(new StartGameJob($ids[0], $colors[0], false, true));
      dispatch(new StartGameJob($ids[1], $colors[1], false, false));
      dispatch(new StartGameJob($ids[2], $colors[2], false, false));
      dispatch(new StartGameJob($ids[3], $colors[3], false, false));
      dispatch(new StartGameJob($ids[4], $colors[4], false, false));
      dispatch(new StartGameJob($ids[4], $colors[4], true, false));


      return $game;
      }

      public function EndGame() {
      return "test";
      }

      //convert to async
      public function GenerateRound(Request $request) {


        $game = Game::where('user_id', $request->user->id)->where('active', 1)->first();
        if($game == null) {
          return response()->json(['message' => 'Create a game first.'], 400);
        }
        $game->level = $game->level + 1;
        $game->save();

        dispatch(new GenerateJob($game));

        return response()->json(['message' => 'Successfully queued sequence generation'], 200);



    }

    public function SubmitRound(Request $request) {


      //just gonna send it.
      //nother day nother beer.
      //🔥
      //💯

      /*$this->validate($request, [
        "sequence" => "required"
      ]);
      */

      $game = Game::where('user_id', $request->user->id)->where('active', 1)->first();

      if($game == null) {
        return response()->json(['message' => 'Create a game first.'], 400);
      }

      $correct_sequence = Sequence::where('level', $game->level)
                            ->where('game_id', $game->id)
                            ->orderBy('order', 'asc')
                            ->get();
      $user_sequence = explode(" ", $request->header('sequence'));

      if(count($correct_sequence) != count($user_sequence)) {
        $game->active = 0;
        $game->save();
        dispatch(new SubmitJob(false));
        return response()->json(['correct' => false, 'score' => $game->level]);
      }



      for($i = 0; $i < count($correct_sequence); $i++) {
        $color = Color::where('id', $correct_sequence[$i]->color_id)->first();
        if($user_sequence[$i] != $color->color) {
          $game->active = 0;
          $game->save();

          dispatch(new SubmitJob(false));
          return response()->json(['correct' => false, 'score' => $game->level]);

        }
      }
      dispatch(new SubmitJob(true));
      return response()->json(['correct' => true ]);
    }
}
