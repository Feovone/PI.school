<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePropUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('users', function (Blueprint $table) {
             $table->string('first_name')->nullable(true)->change();
             $table->string('last_name')->nullable(true)->change();
             $table->renameColumn('mandatory_exchange_percentage','force_exchange_percentage')->change();
             $table->renameColumn('exchange_flag','force_exchange_flag')->change();
             $table->renameColumn('interest_rate','tax_rate')->change();
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
