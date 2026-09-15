<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReferMonthlyToPlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->unsignedInteger('daily_income')->nullable()->after('status');
            $table->unsignedInteger('refer_monthly')->nullable()->after('daily_income');
            $table->unsignedInteger('refer_commission')->nullable()->after('refer_commission');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('AddReferMonthlyToPlans');
    }
}
