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
            $table->char('id', 36)->default(NULL)->primary();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::create('settings', function(Blueprint $table) {
            $table->char('id', 36)->default(NULL)->primary();
            $table->char('user_id', 36);
            $table->foreign('user_id')->references('id')->on('users');
            $table->char('ui_language', 2);
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::create('languages', function(Blueprint $table) {
            $table->char('id', 36)->default(NULL)->primary();
            $table->char('language_code', 7);
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'afr'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'ara'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'aze'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'bel'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'ben'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'bul'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'cat'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'ces'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'chi-sim'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'chi-tra'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'chr'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'dan'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'deu'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'ell'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'eng'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'enm'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'epo'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'equ'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'est'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'eus'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'fin'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'fra'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'frk'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'frm'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'glg'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'grc'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'heb'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'hin'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'hrv'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'hun'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'ind'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'isl'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'ita'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'jpn'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'kan'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'kor'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'lav'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'lit'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'mal'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'mkd'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'mlt'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'msa'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'nld'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'nor'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'pol'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'por'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'ron'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'rus'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'slk'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'slv'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'spa'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'sqi'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'srp'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'swa'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'swe'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'tam'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'tel'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'tgl'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'tha'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'tur'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'ukr'));
        DB::table('languages')->insert(array('id'=> \Uuid::generate(4),'language_code' => 'vie'));

        Schema::create('language_user', function(Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->char('user_id', 36);
            $table->foreign('user_id')->references('id')->on('users');
            $table->char('language_id', 36);
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('notebooks', function(Blueprint $table) {
            $table->char('id', 36)->default(NULL)->primary();
            $table->char('parent_id', 36)->nullable();
            $table->tinyInteger('type')->unsigned()->default(0);
            $table->string('title');
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });
        Schema::table('notebooks', function(Blueprint $table){
            $table->foreign("parent_id")->references("id")->on("notebooks")->onDelete('cascade')->onUpdate("cascade");
        });

        Schema::create('notebook_user', function(Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->char('user_id', 36);
            $table->foreign('user_id')->references('id')->on('users');
            $table->char('notebook_id', 36);
            $table->foreign('notebook_id')->references('id')->on('notebooks')->onDelete('cascade');
            $table->tinyInteger('umask');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('versions', function(Blueprint $table) {
            $table->char('id', 36)->default(NULL)->primary();
            $table->char('previous_id', 36)->nullable();
            $table->char('next_id', 36)->nullable();
            $table->string('title');
            $table->string('content_preview');
            $table->text('content');
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });
        Schema::table('versions', function(Blueprint $table) {
            $table->foreign("previous_id")->references("id")->on("versions")->onDelete('set null')->onUpdate("cascade");
            $table->foreign("next_id")->references("id")->on("versions")->onDelete('set null')->onUpdate("cascade");
        });

        Schema::create('attachments', function(Blueprint $table) {
            $table->char('id', 36)->default(NULL)->primary();
            $table->timestamps();
            $table->string('filename');
            $table->string('fileextension');
            $table->text('content')->nullable();
            $table->string('mimetype');
            $table->bigInteger('filesize')->unsigned();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::create('attachment_version', function(Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->char('attachment_id', 36);
            $table->foreign('attachment_id')->references('id')->on('attachments')->onDelete('cascade');
            $table->char('version_id', 36);
            $table->foreign('version_id')->references('id')->on('versions')->onDelete('cascade');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('notes', function(Blueprint $table) {
            $table->char('id', 36)->default(NULL)->primary();
            $table->char('notebook_id', 36);
            $table->foreign('notebook_id')->references('id')->on('notebooks');
            $table->char('version_id', 36);
            $table->foreign('version_id')->references('id')->on('versions');
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::create('note_user', function(Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->char('user_id', 36);
            $table->foreign('user_id')->references('id')->on('users');
            $table->char('note_id', 36);
            $table->foreign('note_id')->references('id')->on('notes')->onDelete('cascade');
            $table->tinyInteger('umask');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

		Schema::create('tags', function(Blueprint $table) {
            $table->char('id', 36)->default(NULL)->primary();
            $table->string('title');
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::create('tag_user', function(Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->char('user_id', 36);
            $table->foreign('user_id')->references('id')->on('users');
            $table->char('tag_id', 36);
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('tag_note', function(Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->char('note_id', 36);
            $table->foreign('note_id')->references('id')->on('notes')->onDelete('cascade');
            $table->char('tag_id', 36);
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('shortcuts', function(Blueprint $table) {
            $table->char('id', 36)->default(NULL)->primary();
            $table->char('user_id', 36);
            $table->foreign('user_id')->references('id')->on('users');
            $table->char('notebook_id', 36);
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
        Schema::table('tag_note', function(Blueprint $table) {
            $table->drop();
        });
        Schema::table('tag_user', function(Blueprint $table) {
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
        Schema::table('attachment_version', function(Blueprint $table) {
            $table->drop();
        });
        Schema::table('attachments', function(Blueprint $table) {
            $table->drop();
        });
        Schema::table('versions', function(Blueprint $table) {
            $table->drop();
        });
        Schema::table('notebook_user', function(Blueprint $table) {
            $table->drop();
        });
        Schema::table('notebooks', function(Blueprint $table) {
            $table->drop();
        });
        Schema::table('language_user', function(Blueprint $table) {
            $table->drop();
        });
        Schema::table('languages', function(Blueprint $table) {
            $table->drop();
        });
        Schema::table('settings', function(Blueprint $table) {
            $table->drop();
        });
        Schema::table('users', function(Blueprint $table) {
            $table->drop();
        });
  	}
}
