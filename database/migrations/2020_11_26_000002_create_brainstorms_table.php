<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateBrainstormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         *  Conversations Table Schema
         */
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('from_id')->nullable();
            $table->foreign('from_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('to_id')->nullable();
            $table->string('to_type')->default('App\\\Models\\\Conversation')->comment('1 => Message, 2 => Brainstorm Message');
            
            $table->unsignedBigInteger('reply_to')->nullable();
            
            $table->text('message');
            $table->tinyInteger('message_type')->default(0)->comment('0 => text message, 1 => image, 2 => pdf, 3 => doc, 4 => voice');
            $table->tinyInteger('status')->default(0)->comment('0 => unread message, 1 => seen message');
            $table->text('file_name')->nullable();
            $table->json('url_details')->nullable()->change();
            $table->timestamps();
            
            $table->foreign('reply_to')->references('id')->on('conversations')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });


        /**
         *  Brainstorms Table Schema
         */
        Schema::create('brainstorms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('photo_url')->nullable();
            $table->integer('privacy')->comment('0 => Public (Anyone can access), 1 => Private (Only Members can access) ');
            $table->integer('brainstorm_type')->comment('1 => Open (Anyone can send message), 2 => Close (Only Admin can send message) ');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('created_by')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
                
        });


        /**
         *  Brainstorm Users Table Schema
         */
        Schema::create('brainstorm_users', function (Blueprint $table) {
            $table->id();
            $table->string('brainstorm_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('role')->default(1)->comment('1 => Open (Anyone can send message), 2 => Close (Only Admin can send message) ');
            $table->unsignedBigInteger('added_by');
            $table->unsignedBigInteger('removed_by')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();

            $table->foreign('brainstorm_id')
                ->references('id')->on('brainstorms')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('removed_by')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
                
            $table->foreign('added_by')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });


        /**
         *  Brainstorm Users Table Schema
         */
        Schema::create('brainstorm_message_recipients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('conversation_id');
            $table->string('brainstorm_id');
            $table->dateTime('read_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('conversation_id')
                ->references('id')->on('conversations')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });


        /**
         *  Last Conversations Table Schema
         */
        Schema::create('last_conversations', function (Blueprint $table) {
            $table->id();
            $table->string('brainstorm_id');
            $table->unsignedBigInteger('conversation_id');
            $table->unsignedBigInteger('user_id');
            $table->json('brainstorm_details');

            $table->index('brainstorm_id');

            $table->foreign('brainstorm_id')
                ->references('id')->on('brainstorms')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('conversation_id')
                ->references('id')->on('conversations')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
        });


        /**
         *  Brainstorm Notebook pivot Table Schema
         */
        Schema::create('brainstorm_notebook', function (Blueprint $table) {
            $table->id();

            $table->string('brainstorm_id')->index();
            $table->foreign('brainstorm_id')->references('id')->on('brainstorms')->onDelete('cascade');

            $table->unsignedBigInteger('notebook_id')->index();
            $table->foreign('notebook_id')->references('id')->on('notebooks')->onDelete('cascade');

            $table->timestamps();
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
            'conversations',
            'brainstorms',
            'brainstorm_users',
            'brainstorm_message_recipients',
            'last_conversations',
            'brainstorm_notebook',
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach($tables as $table) {
            Schema::drop($table);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
