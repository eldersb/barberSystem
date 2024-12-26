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
        Schema::create('schedullings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients'); 
            $table->foreignId('barber_id')->constrained('barbers'); 
            $table->dateTime('serviceTime');
            $table->string('status')->default('Em andamento');
            $table->decimal('serviceValue', 8, 2)->nullable();
            $table->string('payment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedullings');
    }
};
