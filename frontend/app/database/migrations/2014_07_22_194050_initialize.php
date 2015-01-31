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
            $table->bigIncrements('id')->unsigned();
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
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->char('ui_language', 2);
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::create('languages', function(Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->char('language_code', 7);
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        DB::table('languages')->insert(array('language_code' => 'afr'));
        DB::table('languages')->insert(array('language_code' => 'ara'));
        DB::table('languages')->insert(array('language_code' => 'aze'));
        DB::table('languages')->insert(array('language_code' => 'bel'));
        DB::table('languages')->insert(array('language_code' => 'ben'));
        DB::table('languages')->insert(array('language_code' => 'bul'));
        DB::table('languages')->insert(array('language_code' => 'cat'));
        DB::table('languages')->insert(array('language_code' => 'ces'));
        DB::table('languages')->insert(array('language_code' => 'chi-sim'));
        DB::table('languages')->insert(array('language_code' => 'chi-tra'));
        DB::table('languages')->insert(array('language_code' => 'chr'));
        DB::table('languages')->insert(array('language_code' => 'dan'));
        DB::table('languages')->insert(array('language_code' => 'deu'));
        DB::table('languages')->insert(array('language_code' => 'ell'));
        DB::table('languages')->insert(array('language_code' => 'eng'));
        DB::table('languages')->insert(array('language_code' => 'enm'));
        DB::table('languages')->insert(array('language_code' => 'epo'));
        DB::table('languages')->insert(array('language_code' => 'equ'));
        DB::table('languages')->insert(array('language_code' => 'est'));
        DB::table('languages')->insert(array('language_code' => 'eus'));
        DB::table('languages')->insert(array('language_code' => 'fin'));
        DB::table('languages')->insert(array('language_code' => 'fra'));
        DB::table('languages')->insert(array('language_code' => 'frk'));
        DB::table('languages')->insert(array('language_code' => 'frm'));
        DB::table('languages')->insert(array('language_code' => 'glg'));
        DB::table('languages')->insert(array('language_code' => 'grc'));
        DB::table('languages')->insert(array('language_code' => 'heb'));
        DB::table('languages')->insert(array('language_code' => 'hin'));
        DB::table('languages')->insert(array('language_code' => 'hrv'));
        DB::table('languages')->insert(array('language_code' => 'hun'));
        DB::table('languages')->insert(array('language_code' => 'ind'));
        DB::table('languages')->insert(array('language_code' => 'isl'));
        DB::table('languages')->insert(array('language_code' => 'ita'));
        DB::table('languages')->insert(array('language_code' => 'jpn'));
        DB::table('languages')->insert(array('language_code' => 'kan'));
        DB::table('languages')->insert(array('language_code' => 'kor'));
        DB::table('languages')->insert(array('language_code' => 'lav'));
        DB::table('languages')->insert(array('language_code' => 'lit'));
        DB::table('languages')->insert(array('language_code' => 'mal'));
        DB::table('languages')->insert(array('language_code' => 'mkd'));
        DB::table('languages')->insert(array('language_code' => 'mlt'));
        DB::table('languages')->insert(array('language_code' => 'msa'));
        DB::table('languages')->insert(array('language_code' => 'nld'));
        DB::table('languages')->insert(array('language_code' => 'nor'));
        DB::table('languages')->insert(array('language_code' => 'pol'));
        DB::table('languages')->insert(array('language_code' => 'por'));
        DB::table('languages')->insert(array('language_code' => 'ron'));
        DB::table('languages')->insert(array('language_code' => 'rus'));
        DB::table('languages')->insert(array('language_code' => 'slk'));
        DB::table('languages')->insert(array('language_code' => 'slv'));
        DB::table('languages')->insert(array('language_code' => 'spa'));
        DB::table('languages')->insert(array('language_code' => 'sqi'));
        DB::table('languages')->insert(array('language_code' => 'srp'));
        DB::table('languages')->insert(array('language_code' => 'swa'));
        DB::table('languages')->insert(array('language_code' => 'swe'));
        DB::table('languages')->insert(array('language_code' => 'tam'));
        DB::table('languages')->insert(array('language_code' => 'tel'));
        DB::table('languages')->insert(array('language_code' => 'tgl'));
        DB::table('languages')->insert(array('language_code' => 'tha'));
        DB::table('languages')->insert(array('language_code' => 'tur'));
        DB::table('languages')->insert(array('language_code' => 'ukr'));
        DB::table('languages')->insert(array('language_code' => 'vie'));

        Schema::create('language_user', function(Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('language_id')->unsigned();
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

		Schema::create('notebooks', function(Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
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
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('notebook_id')->unsigned();
            $table->foreign('notebook_id')->references('id')->on('notebooks')->onDelete('cascade');
            $table->tinyInteger('umask');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('versions', function(Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('previous_id')->unsigned()->nullable();
            $table->bigInteger('next_id')->unsigned()->nullable();
            $table->string('title');
            $table->string('content_preview');
            $table->text('content');
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });
        DB::statement('ALTER TABLE versions ADD FOREIGN KEY (previous_id) REFERENCES versions (id) ON DELETE SET NULL ON UPDATE CASCADE');
        DB::statement('ALTER TABLE versions ADD FOREIGN KEY (next_id) REFERENCES versions (id) ON DELETE SET NULL ON UPDATE CASCADE');
        // DB::statement('ALTER TABLE versions ADD FULLTEXT search(title, content)');

        Schema::create('attachments', function(Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->timestamps();
            $table->string('filename');
            $table->string('fileextension');
            $table->text('content');
            $table->string('mimetype');
            $table->bigInteger('filesize')->unsigned();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });
        // DB::statement('ALTER TABLE attachments ADD FULLTEXT search(content)');

        Schema::create('attachment_version', function(Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('attachment_id')->unsigned();
            $table->foreign('attachment_id')->references('id')->on('attachments')->onDelete('cascade');
            $table->bigInteger('version_id')->unsigned();
            $table->foreign('version_id')->references('id')->on('versions')->onDelete('cascade');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

		Schema::create('notes', function(Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('notebook_id')->unsigned();
            $table->foreign('notebook_id')->references('id')->on('notebooks');
            $table->bigInteger('version_id')->unsigned();
            $table->foreign('version_id')->references('id')->on('versions');
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::create('note_user', function(Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('note_id')->unsigned();
            $table->foreign('note_id')->references('id')->on('notes')->onDelete('cascade');
            $table->tinyInteger('umask');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

		Schema::create('tags', function(Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('title');
            $table->timestamps();
            $table->softDeletes();
            $table->engine = 'InnoDB';
        });

        Schema::create('tag_user', function(Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('tag_id')->unsigned();
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('tag_note', function(Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('note_id')->unsigned();
            $table->foreign('note_id')->references('id')->on('notes')->onDelete('cascade');
            $table->bigInteger('tag_id')->unsigned();
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::create('shortcuts', function(Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
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
