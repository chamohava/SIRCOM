<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_menu', function (Blueprint $table) {
            $table->id();
            $table->string('nb_menu', 50)->nullable();
            $table->string('subopcion', 50)->nullable();
            $table->integer('padre');
            $table->integer('orden');
            $table->boolean('id_estatu');
            $table->string('url', 100)->nullable();
            $table->integer('rol_id');
            $table->integer('menu_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_menu');
    }
};
