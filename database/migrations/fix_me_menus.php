<?php

use Illuminate\Database\Migrations\Migration;

class FixMenus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // DB::insert(

        //     "INSERT INTO `menus` (`parent_id`, `name`, `icon`, `order`, `link`, `has_children`) VALUES

        //         [ ]
        //         [ ]
        //         [ ]
        //         [ ]
        //         [ ]
        //         [ ]
        //         [ ]
        //         [ 'name' => 'Logs', 'icon' => 'fnoa fa-fw fa-terminal', 'link' => 'system/logs', 'has_children' => 0]
        //         [ 'name' => 'Localisation', 'icon' => 'fa fa-fw fa-language', 'link' => 'system/localisation', 'has_children' => 0]
        //         [ 'name' => 'Tutorials', 'icon' => 'fa fa-fw fa-book', 'link' => 'system/tutorials', 'has_children' => 0]
        //         [ ]
        // );

        // $now = "'".date('Y - m - dH:i:s')."'";

        // DB::update("update`menus`setcreated_at = $now, updated_at = $now");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
