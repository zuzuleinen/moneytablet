<?php

use Illuminate\Database\Migrations\Migration;

class CreateTabletsTable extends Migration
{

    /**
     * Create tablets table
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tablets', function($table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned();
                $table->foreign('user_id')->references('id')->on('users');
                $table->string('name', 50);
                $table->decimal('total_amount', 10, 2)->default(0);
                $table->decimal('total_expenses', 10, 2)->default(0);
                $table->decimal('current_sum', 10, 2)->default(0);
                $table->decimal('economies', 10, 2)->default(0);
                $table->smallInteger('is_active');
                $table->index('is_active');
                $table->timestamps();
            });
    }

    /**
     * Drop tablets table
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tablets');
    }

}