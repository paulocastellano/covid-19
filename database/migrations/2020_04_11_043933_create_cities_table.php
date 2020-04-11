<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('state', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('city_ibge_code', 255)->nullable();
            $table->bigInteger('confirmed')->nullable();
            $table->decimal('confirmed_per_100k_inhabitants', 16, 2)->nullable();
            $table->decimal('death_rate', 16, 2)->nullable();
            $table->bigInteger('deaths')->nullable();
            $table->bigInteger('estimated_population_2019')->nullable();
            $table->boolean('is_last')->nullable();
            $table->bigInteger('order_for_place')->nullable();
            $table->string('place_type', 255)->nullable();
            $table->date('date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
