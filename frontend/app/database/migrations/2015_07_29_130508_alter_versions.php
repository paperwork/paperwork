<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterVersions extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('versions', function (Blueprint $table) {
            $table->mediumText('content_new');
        });

        DB::update('update versions set content_new = content');

        Schema::table('versions', function (Blueprint $table) {
            $table->dropColumn('content');

            $table->renameColumn('content_new', 'content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('versions', function (Blueprint $table) {
            $table->text('content')->change();
        });
    }

}
