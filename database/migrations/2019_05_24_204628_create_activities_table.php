<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('organisation_id')->index();
            $table->unsignedBigInteger('activity_collection_id')->index();
            $table->string('name');
            $table->text('description');
            $table->date('starts_at');
            $table->date('ends_at');
            $table->unsignedInteger('places');
            $table->unsignedInteger('cost');
            $table->boolean('is_hidden')->default(false);
            $table->boolean('is_invite_only')->default(false);
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
        Schema::dropIfExists('activities');
    }
}
