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
            $table->foreignId('category_id')->constrained('category');
            $table->timestamp('serviceTime')->nullable();
            $table->string('status');
            $table->decimal('serviceValue', 8, 2);
            $table->timestamps();

            // $table->id();
            // $table->unsignedBigInteger('barber_id');
            // $table->unsignedBigInteger('client_id');
            // $table->unsignedBigInteger('category_id');
            // $table->dateTime('serviceTime');
            // $table->string('status');
            // $table->decimal('serviceValue', 8, 2);
            // $table->timestamps();
    
            // $table->foreign('barber_id')->references('id')->on('barbers');
            // $table->foreign('client_id')->references('id')->on('clients');
            // $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedulling');
    }
};
