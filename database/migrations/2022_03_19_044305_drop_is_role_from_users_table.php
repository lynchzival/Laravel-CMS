<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropIsRoleFromUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table -> dropColumn('is_admin');
            $table -> dropColumn('is_author');
            $table -> dropColumn('is_reader');
            // $table -> unsignedBigInteger('role_id') -> nullable();
            // $table -> foreign('role_id')->references('id')->on('roles');
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
            $table -> boolean('is_admin') -> after('profile_img') -> default(false);
            $table -> boolean('is_author') -> after('profile_img') -> default(false);
            $table -> boolean('is_reader') -> after('profile_img') -> default(false);
            // $table -> dropForeign(['role_id']);
            // $table -> dropColumn('role_id');
        });
    }
}
