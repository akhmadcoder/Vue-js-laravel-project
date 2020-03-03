<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpendingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spendings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('cost');
            $table->string('description', 255)->nullable();
            $table->dateTime('date');
            $table->integer('quantity');
            $table->bigInteger('expense_id')->unsigned();
            $table->bigInteger('money_id')->unsigned();
            $table->timestamps();

            $table->foreign('expense_id')
                ->references('id')
                ->on('expenses')
                ->onDelete('cascade')
                ->onUpdate('no action');

            $table->foreign('money_id')
                ->references('id')
                ->on('money')
                ->onDelete('cascade')
                ->onUpdate('no action');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spendings');
    }
}
