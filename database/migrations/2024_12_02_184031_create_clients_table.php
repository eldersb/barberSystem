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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 50);
            $table->string('last_name', 100);
            $table->enum('gender', ['Masculino', 'Feminino', 'Outros']);
            $table->date('birthDate')->nullable();
            $table->string('document', 50);
            $table->char('telephone', 11);
            $table->string('street_name', 255)->nullable();
            $table->string('street_number', 20)->nullable();
            $table->string('city', 255)->nullable();
            $table->char('state', 2)->nullable();
            $table->string('neighborhood', 255)->nullable();
            $table->string('email');
            $table->string('cep')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
    */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
