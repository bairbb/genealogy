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
        Schema::create('spouses', function (Blueprint $table) {
            $table->id();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('name');
            $table->string('lastname')->nullable();
            $table->string('surname')->nullable();
            $table->year('birth_year')->nullable();
            $table->year('death_year')->nullable();
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->foreignId('person_id')->constrained(table: 'persons', indexName: 'spouses_person_id_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spouses');
    }
};
