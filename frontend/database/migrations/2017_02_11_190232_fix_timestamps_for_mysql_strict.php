<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixTimestampsForMysqlStrict extends Migration
{

    private $table_names = array(
        'attachments',
        'attachment_version',
        'language_user',
        'notebooks',
        'notebook_user',
        'notes',
        'note_user',
        // password_reminders has created_at
        'settings',
        'shortcuts',
        'tag_note',
        'tags',
        'users',
        'versions',
    );

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->table_names as $table_name) {
            Schema::table($table_name, function($table) {
                $table->dateTime('created_at')->nullable()->default(null)->change();
                $table->dateTime('updated_at')->nullable()->default(null)->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->table_names as $table_name) {
            Schema::table($table_name, function($table) {
                $table->dateTime('created_at')->nullable(false)->change();
                $table->dateTime('updated_at')->nullable(false)->change();
            });
        }
    }
}
