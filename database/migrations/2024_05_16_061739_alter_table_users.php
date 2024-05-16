<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('phone_number')->nullable();
            $table->string('username');
            $table->string('profile_image')->nullable();
            $table->string('user_types_id')->nullable();
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
            //
            $table->dropColumn('phone_number')->nullable();
            $table->dropColumn('username');
            $table->dropColumn('profile_image')->nullable();
            $table->dropColumn('user_types_id')->nullable();
        });
    }
};
