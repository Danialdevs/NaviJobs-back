<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationRatingsTable extends Migration
{
    public function up()
    {
        Schema::create('application_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications');
            $table->text('comment');
            $table->integer('stars');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('application_ratings');
    }
}
