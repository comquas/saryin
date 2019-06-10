<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('currency')->default("MMK")->change();
            $table->float('amount',8,2)->default(0)->change();
            $table->bigInteger('categoryID')->default(0)->change();
            $table->string('name')->default("")->change();
            $table->string('description')->default("")->change();
            $table->string('attachment')->default("")->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
        });
    }
}
