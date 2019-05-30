<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_collections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organisation_id')->index();
            $table->string('name', 50);
            $table->string('description', 500);
            $table->dateTime('booking_starts_at');
            $table->dateTime('booking_ends_at');
            $table->dateTime('payment_starts_at');
            $table->dateTime('payment_ends_at');
            $table->dateTime('activities_start_at');
            $table->dateTime('activities_end_at');
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
        Schema::dropIfExists('activity_collections');
    }
}
