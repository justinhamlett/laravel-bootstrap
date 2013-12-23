<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUploadsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploads', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('path',255); // The path the original filename resides in
            $table->string('filename',255); // The original filename
            $table->string('extension',4);  // The extension
            $table->integer('order')->unsigned(); // The order to retrieve in
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
        Schema::drop('uploads');
    }

}
