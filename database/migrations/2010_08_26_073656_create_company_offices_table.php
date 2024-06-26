<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyOfficesTable extends Migration
{
    public function up()
    {
        Schema::create('company_offices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->foreignId('company_id')->constrained('companies');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('company_offices');
    }
}
