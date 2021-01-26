<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('flight_number');
            $table->foreignId('airline_id')->constrained('airlines')->onDelete('cascade');
            $table->foreignId('from_airport_id')->constrained('airports')->onDelete('cascade');
            $table->foreignId('to_airport_id')->constrained('airports')->onDelete('cascade');
            $table->foreignId('airplane_id')->constrained('airplanes')->onDelete('cascade');
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
        Schema::dropIfExists('flights');
    }
}
