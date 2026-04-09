<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarksReversalsTable extends Migration
{
    public function up()
    {
        Schema::create('marks_reversals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('class');
            $table->string('subject');
            $table->string('term');
            $table->string('year');
            $table->text('reason')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

public function down()
{
    Schema::dropIfExists('marks_reversals');
}
}