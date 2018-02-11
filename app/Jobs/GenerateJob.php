<?php

namespace App\Jobs;

use App\Game;
use App\Sequence;
use App\Color;
use App\User;
use App\Libraries\LifxApi;

class GenerateJob extends Job
{

    protected $game;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

      $ids = array("id:d073d532ad4f", "id:d073d5123b9f", "id:d073d52013c2", "id:d073d511fe55", "id:d073d532ad22");
      $colors = array("red", "purple", "blue", "green", "yellow", "orange");
      shuffle($ids);
      shuffle($colors);

      LifxApi::setSelectorProperity('group:AshOffice', 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', null, "off");

      $current_color = 0;
      foreach($ids as $id) {
        LifxApi::setSelectorProperity($id, 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', $colors[$current_color], "on");
        $current_color++;
        LifxApi::setSelectorProperity($id, 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', null, "off");

        $color = Color::where('color', $colors[$current_color])->first();


        $sequence = new Sequence;
        $sequence->level = $this->game->level;
        $sequence->order = $current_color;
        $sequence->game()->associate($this->game->id);
        $sequence->color()->associate($color->id);
        $sequence->save();

      }

      LifxApi::setSelectorProperity('group:AshOffice', 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', "cyan", "off");
      LifxApi::setSelectorProperity('group:AshOffice', 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', "cyan", "on", 5);

      echo("it works");
    }


    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        // Send user notification of failure, etc...
    }


}
