<?php

namespace App\Jobs;

use App\Libraries\LifxApi;

class SubmitJob extends Job
{

    protected $status;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($status)
    {
        $this->status = $status;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

      if($this->status == false) {
        LifxApi::setSelectorProperity('group:AshOffice', 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', "cyan", "off");
        LifxApi::setSelectorProperity('group:AshOffice', 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', "red", "on");
        LifxApi::setSelectorProperity('group:AshOffice', 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', "cyan", "off");
        LifxApi::setSelectorProperity('group:AshOffice', 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', "cyan", "on", 5);
      } else {
        LifxApi::setSelectorProperity('group:AshOffice', 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', "cyan", "off");
        LifxApi::setSelectorProperity('group:AshOffice', 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', "green", "on");
        LifxApi::setSelectorProperity('group:AshOffice', 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', "cyan", "off");
        LifxApi::setSelectorProperity('group:AshOffice', 'c1b98fcbc42575c519d3227282f5956fc4e77ed97349e2942262b5bea985718d', "cyan", "on", 5);
      }

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
