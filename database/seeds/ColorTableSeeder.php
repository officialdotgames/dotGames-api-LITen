<?php

use Illuminate\Database\Seeder;
use App\Color;

class ColorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $red = new Color;
        $red->color = "red";
        $red->save();

        $green = new Color;
        $green->color = "green";
        $green->save();

        $blue = new Color;
        $blue->color = "blue";
        $blue->save();

        $yellow = new Color;
        $yellow->color = "yellow";
        $yellow->save();

        $orange = new Color;
        $orange->color = "orange";
        $orange->save();

        $purple = new Color;
        $purple->color = "purple";
        $purple->save();

    }
}
