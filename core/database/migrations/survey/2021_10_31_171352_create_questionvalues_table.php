<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionvaluesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questionvalues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_question_id')->nullable();
            $table->unsignedInteger('MinVal')->nullable();
            $table->unsignedInteger('MaxVal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questionvalues');
    }
}
