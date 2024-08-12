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
        Schema::create('booking_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('booking_id')->default(0);
            $table->string('session_id')->default(0);
            $table->unsignedInteger('user_id')->default(0);
            $table->unsignedInteger('number_of_rooms')->default(0);
            $table->unsignedInteger('room_type_id')->default(0);
            $table->date('check_in')->nullable();
            $table->date('check_out')->nullable();
            $table->decimal('total_amount', 28,8)->default(0);
            $table->decimal('discount', 28,8)->default(0);
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('booking_requests');
    }
};
