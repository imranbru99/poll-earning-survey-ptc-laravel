<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublishSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('publish_surveys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_question_id')->nullable()->constrained();
            $table->unsignedInteger('question_id')->nullable();
            $table->dateTime('DateRollout')->nullable();
            $table->boolean('isPublished')->nullable()->default(false);
            $table->dateTime('DateTobeOnline')->nullable();
            $table->unsignedInteger('RollOutBy')->nullable();
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
        Schema::dropIfExists('publish_surveys');
    }
}
