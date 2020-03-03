<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoneyTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('money_transfers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('client_from_id')->unsigned();
            $table->bigInteger('client_to_id')->unsigned();
            $table->bigInteger('money_id')->unsigned();
            $table->decimal('amount');
            $table->decimal('rate');
            $table->bigInteger('money_to_id')->unsigned();
            $table->decimal('amount_to');
            $table->dateTime('time');
            $table->longText('description')->nullable();
            $table->timestamps();

            $table->foreign('client_from_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('no action');

            $table->foreign('client_to_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('no action');

            $table->foreign('money_id')
                ->references('id')
                ->on('money')
                ->onDelete('cascade')
                ->onUpdate('no action');

            $table->foreign('money_to_id')
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
        Schema::dropIfExists('money_transfers');
    }
}
