<?php
/**
 * Created by PhpStorm.
 * User: nschu
 * Date: 20-5-2017
 * Time: 23:12
 */

namespace Terramania\Terramania\Updates;


use October\Rain\Database\Updates\Migration;
use October\Rain\Support\Facades\Schema;

class CreateThemesTable extends Migration
{
    public function up()
    {
        Schema::create('terramania_terramania_themes', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('domain')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('terramania_terramania_themes');
    }
}