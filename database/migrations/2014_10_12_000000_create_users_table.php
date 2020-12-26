<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
         * Users Table
         */
        Schema::create('users', function ($table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('username')->unique()->nullable();
            $table->string('password');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->timestamp("last_seen")->nullable();
            $table->tinyInteger("is_online")->default(0)->nullable();
            $table->tinyInteger("is_active")->default(0)->nullable();
            $table->text("bio")->nullable();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
        });

        /**
         * User upload image table
         */
        Schema::create('user_uploads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('caption')->nullable();

            $table->bigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tables = [
            'users',
            'user_uploads',
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach($tables as $table) {
            Schema::drop($table);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
