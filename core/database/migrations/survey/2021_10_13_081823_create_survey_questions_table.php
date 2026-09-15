<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('survey_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained();
            $table->foreignId('survey_id')->nullable()->constrained();
            $table->unsignedInteger('questiontype_id')->nullable();
            $table->longText('question')->nullable();
            $table->boolean('isPublished')->nullable()->default(false);
            $table->boolean('isBeenAnswered')->nullable()->default(false);
            $table->unsignedInteger('point')->nullable();           
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_questions');
    }
}
