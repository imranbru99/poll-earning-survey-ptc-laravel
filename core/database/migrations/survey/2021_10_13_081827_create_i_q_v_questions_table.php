<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIQVQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('i_q_v_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('IQVTest_id')->nullable()->constrained();
            $table->foreignId('category_id')->nullable()->constrained();
            $table->longText('question')->nullable();
            $table->string('optionA')->nullable();
            $table->string('optionB')->nullable();
            $table->string('optionC')->nullable();
            $table->string('optionD')->nullable();
            $table->string('optionE')->nullable();
            $table->string('optionF')->nullable();
            $table->boolean('isAnswer')->nullable()->default(false);
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
        Schema::dropIfExists('i_q_v_questions');
    }
}
