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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date_received');
            $table->decimal('price', 10, 2);
            $table->integer('pieces')->unsigned();
            $table->string('pokemon_tcg_id')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->jsonb('pokemon_tcg_data')->nullable();
            $table->tinyInteger('condition')->unsigned()->default(1)->comment('Condition from 1 to 10');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
