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
        Schema::create('booking_action_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('type')->default(1);
            $table->unsignedInteger('booking_id')->default(0);
            $table->unsignedInteger('room_id')->default(0);
            $table->unsignedInteger('admin_id')->default(0);
            $table->unsignedInteger('receptionist_id')->default(0);
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
        Schema::dropIfExists('booking_action_histories');
    }
};
