<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttemptIQVQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('attempt_i_q_v_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attemptBy')->nullable();
            $table->foreignId('IQVQuestion_id')->nullable()->constrained();
            $table->boolean('status')->nullable()->default(false);
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
        Schema::dropIfExists('attempt_i_q_v_questions');
    }
}
