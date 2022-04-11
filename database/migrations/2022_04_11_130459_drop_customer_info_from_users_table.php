<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropCustomerInfoFromUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table -> dropColumn('line1');
            $table -> dropColumn('line2');
            $table -> dropColumn('city');
            $table -> dropColumn('state');
            $table -> dropColumn('country');
            $table -> dropColumn('postal_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table -> string('line1') -> nullable();
            $table -> string('line2') -> nullable();
            $table -> string('city') -> nullable();
            $table -> string('state') -> nullable();
            $table -> string('country') -> nullable();
            $table -> string('postal_code') -> nullable();
        });
    }
}
