<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateNotebooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         *  Notebook Table Schema
         */
        Schema::create('notebooks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('cover_image')->nullable();
            $table->text('summary')->nullable();
            $table->boolean('privacy')->default(1)->comment(' 0 => Public (Open for everyon to have access), 1 => Private (Hide from the public)');;
            $table->timestamps();
            $table->softDeletes();
        });


        /**
         *  Notebook User pivot Table Schema
         */
        Schema::create('notebook_user', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('notebook_id')->index();
            $table->foreign('notebook_id')->references('id')->on('notebooks')->onDelete('cascade');

            $table->bigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });


        /**
         *  Note Table Schema
         */
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content')->nullable();
            $table->boolean('privacy')->default(1)->comment(' 0 => Public (Open for everyon to have access), 1 => Private (Hide from the public)');;
            $table->timestamps();
            $table->softDeletes();
        });


        /**
         *  Note User Entries Table Schema
         */
        Schema::create('notebook_entries', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('note_id')->index();
            $table->foreign('note_id')->references('id')->on('notes')->onDelete('cascade');

            $table->unsignedBigInteger('notebook_id')->index();
            $table->foreign('notebook_id')->references('id')->on('notebooks')->onDelete('cascade');

            $table->bigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });


        /**
         * Note Members Schema
         */
        // Schema::create('note_members', function (Blueprint $table) {
        //     $table->id();

        //     $table->unsignedBigInteger('notebook_id')->index();
        //     $table->foreign('notebook_id')->references('id')->on('notebooks')->onDelete('cascade');

        //     $table->bigInteger('user_id')->unsigned()->index();
        //     $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
        //     $table->string('email');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tables = [
            'notes',
            'notebooks',
            'notebook_user',
            'notebook_entries',
            // 'note_members',
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($tables as $table) {
            Schema::drop($table);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
