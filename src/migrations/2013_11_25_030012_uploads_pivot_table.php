<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UploadsPivotTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('uploadables') ) {
			Schema::create('uploadables', function($table)
	    {
				$table->engine = 'InnoDB';
				$table->increments('id');
				$table->integer('uploads_id')->unsigned();
				$table->integer('uploadable_id')->unsigned();
				$table->string('uploadable_type',255);
				$table->index('id');
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
		Schema::drop('uploadables');
	}

}