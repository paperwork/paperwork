<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixTimestampsForPostgresAgain extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(DB::getDriverName() === "pgsql") {
			DB::statement('ALTER TABLE attachment_version ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP(0);');
			DB::statement('ALTER TABLE attachment_version ALTER COLUMN updated_at SET DEFAULT CURRENT_TIMESTAMP(0);');
	
			DB::statement('ALTER TABLE attachments ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP(0);');
			DB::statement('ALTER TABLE attachments ALTER COLUMN updated_at SET DEFAULT CURRENT_TIMESTAMP(0);');
	
			DB::statement('ALTER TABLE language_user ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP(0);');
			DB::statement('ALTER TABLE language_user ALTER COLUMN updated_at SET DEFAULT CURRENT_TIMESTAMP(0);');
	
			DB::statement('ALTER TABLE note_user ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP(0);');
			DB::statement('ALTER TABLE note_user ALTER COLUMN updated_at SET DEFAULT CURRENT_TIMESTAMP(0);');
	
			DB::statement('ALTER TABLE notebook_user ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP(0);');
			DB::statement('ALTER TABLE notebook_user ALTER COLUMN updated_at SET DEFAULT CURRENT_TIMESTAMP(0);');
	
			DB::statement('ALTER TABLE notebooks ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP(0);');
			DB::statement('ALTER TABLE notebooks ALTER COLUMN updated_at SET DEFAULT CURRENT_TIMESTAMP(0);');
	
			DB::statement('ALTER TABLE notes ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP(0);');
			DB::statement('ALTER TABLE notes ALTER COLUMN updated_at SET DEFAULT CURRENT_TIMESTAMP(0);');
	
			DB::statement('ALTER TABLE settings ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP(0);');
			DB::statement('ALTER TABLE settings ALTER COLUMN updated_at SET DEFAULT CURRENT_TIMESTAMP(0);');
	
			DB::statement('ALTER TABLE shortcuts ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP(0);');
			DB::statement('ALTER TABLE shortcuts ALTER COLUMN updated_at SET DEFAULT CURRENT_TIMESTAMP(0);');
	
			DB::statement('ALTER TABLE tag_note ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP(0);');
			DB::statement('ALTER TABLE tag_note ALTER COLUMN updated_at SET DEFAULT CURRENT_TIMESTAMP(0);');
	
			DB::statement('ALTER TABLE tags ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP(0);');
			DB::statement('ALTER TABLE tags ALTER COLUMN updated_at SET DEFAULT CURRENT_TIMESTAMP(0);');
	
			DB::statement('ALTER TABLE users ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP(0);');
			DB::statement('ALTER TABLE users ALTER COLUMN updated_at SET DEFAULT CURRENT_TIMESTAMP(0);');
	
			DB::statement('ALTER TABLE versions ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP(0);');
			DB::statement('ALTER TABLE versions ALTER COLUMN updated_at SET DEFAULT CURRENT_TIMESTAMP(0);');
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		if(DB::getDriverName() === "pgsql") {
			DB::statement('ALTER TABLE attachment_version ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP;');
			DB::statement('ALTER TABLE attachment_version ALTER COLUMN updated_at SET DEFAULT CURRENT_TIMESTAMP;');
	
			DB::statement('ALTER TABLE attachments ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP;');
			DB::statement('ALTER TABLE attachments ALTER COLUMN updated_at SET DEFAULT CURRENT_TIMESTAMP;');
	
			DB::statement('ALTER TABLE language_user ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP;');
			DB::statement('ALTER TABLE language_user ALTER COLUMN updated_at SET DEFAULT CURRENT_TIMESTAMP;');
	
			DB::statement('ALTER TABLE note_user ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP;');
			DB::statement('ALTER TABLE note_user ALTER COLUMN updated_at SET DEFAULT CURRENT_TIMESTAMP;');
	
			DB::statement('ALTER TABLE notebook_user ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP;');
			DB::statement('ALTER TABLE notebook_user ALTER COLUMN updated_at SET DEFAULT CURRENT_TIMESTAMP;');
	
			DB::statement('ALTER TABLE notebooks ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP;');
			DB::statement('ALTER TABLE notebooks ALTER COLUMN updated_at SET DEFAULT CURRENT_TIMESTAMP;');
	
			DB::statement('ALTER TABLE notes ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP;');
			DB::statement('ALTER TABLE notes ALTER COLUMN updated_at SET DEFAULT CURRENT_TIMESTAMP;');
	
			DB::statement('ALTER TABLE settings ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP;');
			DB::statement('ALTER TABLE settings ALTER COLUMN updated_at SET DEFAULT CURRENT_TIMESTAMP;');
	
			DB::statement('ALTER TABLE shortcuts ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP;');
			DB::statement('ALTER TABLE shortcuts ALTER COLUMN updated_at SET DEFAULT CURRENT_TIMESTAMP;');
	
			DB::statement('ALTER TABLE tag_note ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP;');
			DB::statement('ALTER TABLE tag_note ALTER COLUMN updated_at SET DEFAULT CURRENT_TIMESTAMP;');
	
			DB::statement('ALTER TABLE tags ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP;');
			DB::statement('ALTER TABLE tags ALTER COLUMN updated_at SET DEFAULT CURRENT_TIMESTAMP;');
	
			DB::statement('ALTER TABLE users ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP;');
			DB::statement('ALTER TABLE users ALTER COLUMN updated_at SET DEFAULT CURRENT_TIMESTAMP;');
	
			DB::statement('ALTER TABLE versions ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP;');
			DB::statement('ALTER TABLE versions ALTER COLUMN updated_at SET DEFAULT CURRENT_TIMESTAMP;');
		}
	}
}
