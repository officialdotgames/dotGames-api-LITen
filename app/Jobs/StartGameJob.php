<?php

namespace App\Jobs;

use App\Libraries\LifxApi;

class StartGameJob extends Job
{

    protected $id;
    protected $color;
    protected $end;
    protected $start;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id, $color, $end = false, $start = true)
    {
      $this->id = $id;
      $this->color = $color;
      $this->end = $end;
      $this->start = $start;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

      if($this->start == true) {
        LifxApi::setSelectorProperity('group:AshOffice', 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', "red", "off");
      }

      if($this->end == false) {

        LifxApi::setSelectorProperity($this->id, 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', $this->color, "on");

      } else {
        LifxApi::setSelectorProperity('group:AshOffice', 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', "red", "off");
        LifxApi::setSelectorProperity('group:AshOffice', 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', "cyan", "on", 5);
      }
    }

}
