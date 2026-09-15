<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIQVResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('i_q_v_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('AttemptBy')->nullable();
            $table->unsignedInteger('totalScoreObtained')->nullable();
            $table->dateTime('dateAttempt')->nullable();
            $table->boolean('passStatus')->nullable()->default(false);
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
        Schema::dropIfExists('i_q_v_results');
    }
}
