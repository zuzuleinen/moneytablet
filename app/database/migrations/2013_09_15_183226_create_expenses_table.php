<?php

use Illuminate\Database\Migrations\Migration;

class CreateExpensesTable extends Migration
{

    /**
     * Create expenses table
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function($table) {
                $table->increments('id');
                $table->integer('prediction_id')->unsigned();
                $table->foreign('prediction_id')->references('id')->on('predictions');
                $table->decimal('value', 10, 2)->default(0);
                $table->timestamps();
            });
    }

    /**
     * Delete expenses table
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('expenses');
    }

}