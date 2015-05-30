<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyTagUserRelation extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		        Schema::table('tag_user', function(Blueprint $table) {
            $table->drop();
        });
			Schema::table('tags', function(Blueprint $table)
		{
			$table->char('user_id', 36);
			$table->foreign('user_id')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tags', function(Blueprint $table)
		{
			$table->dropColumn('user_id');
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
	}

}
