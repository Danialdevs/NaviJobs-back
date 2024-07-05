<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('office_id')->nullable()->constrained('company_offices');
            $table->foreignId('company_id')->nullable()->constrained('companies');
            $table->string('surname');
            $table->string('name');
            $table->string('last_name');
            $table->enum('sex', ['male', 'female', 'other']);
            $table->date('data_birthday');
            $table->enum('role', ['admin', 'manager', 'workers']);
            $table->text('avatar')->nullable();
            $table->string('email');
            $table->string('password');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
