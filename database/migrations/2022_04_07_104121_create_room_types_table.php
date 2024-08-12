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
        Schema::create('room_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->integer('total_adult')->default(0);
            $table->integer('total_child')->default(0);
            $table->decimal('fare', 28,16)->nullable();
            $table->text('keywords')->nullable();
            $table->text('description')->nullable();
            $table->integer('total_room')->default(0);
            $table->string('beds', 255)->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('room_types');
    }
};
