<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublishIQVQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('publish_i_q_v_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('IQVQuestion_id')->nullable()->constrained();
            $table->unsignedInteger('IQVTest_id')->nullable();
            $table->dateTime('DateRollout')->nullable();
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
        Schema::dropIfExists('publish_i_q_v_questions');
    }
}
