<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Initialize extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('remember_token');
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

		Schema::create('notebooks', function(Blueprint $table) {
            $table->bigIncrements('id');
            // $table->foreign('parent_id')->references('id')->on('notebooks')->nullable();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->tinyInteger('type')->unsigned()->default(0);
            $table->string('title');
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });
        DB::statement('ALTER TABLE notebooks ADD FOREIGN KEY (parent_id) REFERENCES notebooks (id) ON DELETE CASCADE ON UPDATE CASCADE');

        Schema::create('notebook_user', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('notebook_id')->unsigned();
            $table->foreign('notebook_id')->references('id')->on('notebooks')->onDelete('cascade');
            $table->tinyInteger('umask');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

		Schema::create('notes', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('notebook_id')->unsigned();
            $table->foreign('notebook_id')->references('id')->on('notebooks');
            $table->string('title');
            $table->string('content_preview');
            $table->text('content');
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::create('note_user', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('note_id')->unsigned();
            $table->foreign('note_id')->references('id')->on('notes')->onDelete('cascade');
            $table->tinyInteger('umask');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

		Schema::create('tags', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::create('tag_user', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('tag_id')->unsigned();
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('tag_note', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('note_id')->unsigned();
            $table->foreign('note_id')->references('id')->on('notes')->onDelete('cascade');
            $table->bigInteger('tag_id')->unsigned();
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('shortcuts', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('notebook_id')->unsigned();
            $table->foreign('notebook_id')->references('id')->on('notebooks')->onDelete('cascade');
            $table->tinyInteger('sortkey')->unsigned();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('shortcuts', function(Blueprint $table) {
            $table->drop();
        });
        Schema::table('tag_user', function(Blueprint $table) {
            $table->drop();
        });
        Schema::table('tag_note', function(Blueprint $table) {
            $table->drop();
        });
        Schema::table('tags', function(Blueprint $table) {
            $table->drop();
        });
        Schema::table('note_user', function(Blueprint $table) {
            $table->drop();
        });
        Schema::table('notes', function(Blueprint $table) {
            $table->drop();
        });
        Schema::table('notebook_user', function(Blueprint $table) {
            $table->drop();
        });
        Schema::table('notebooks', function(Blueprint $table) {
            $table->drop();
        });
        Schema::table('users', function(Blueprint $table) {
            $table->drop();
        });
  	}
}
