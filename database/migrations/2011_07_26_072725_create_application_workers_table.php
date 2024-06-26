<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationWorkersTable extends Migration
{
    public function up()
    {
        Schema::create('application_workers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('application_id')->constrained('applications');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('application_workers');
    }
}
