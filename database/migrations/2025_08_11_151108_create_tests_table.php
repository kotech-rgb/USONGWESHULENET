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
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('studentT');
            $table->string('subjectT');
            $table->decimal('test1')->nullable();
            $table->decimal('test2')->nullable();
            $table->decimal('test3')->nullable();
            $table->decimal('test4')->nullable();
            $table->decimal('test5')->nullable();
            $table->string('termT');
            $table->string('yearT');   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};
