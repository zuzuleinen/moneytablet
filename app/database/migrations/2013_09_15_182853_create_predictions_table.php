<?php

use Illuminate\Database\Migrations\Migration;

class CreatePredictionsTable extends Migration
{

    /**
     * Create predictions table
     *
     * @return void
     */
    public function up()
    {
        Schema::create('predictions', function($table) {
                $table->increments('id');
                $table->integer('tablet_id')->unsigned();
                $table->foreign('tablet_id')->references('id')->on('tablets');
                $table->string('name', 50);
                $table->decimal('predicted', 10, 2)->default(0);
                $table->decimal('value', 10, 2)->default(0);
                $table->timestamps();
            });
    }

    /**
     * Delete predictions table
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('predictions');
    }

}