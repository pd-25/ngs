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
        Schema::create('used_extra_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('booking_id')->default(0);
            $table->unsignedInteger('extra_service_id')->default(0);
            $table->unsignedInteger('room_id')->default(0);
            $table->unsignedInteger('qty')->default(0);
            $table->decimal('unit_price', 28,8)->default(0);
            $table->decimal('total_amount', 28,8)->default(0);
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
        Schema::dropIfExists('used_extra_services');
    }
};
