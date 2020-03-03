<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCalculationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_calculations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('quantity');
            $table->bigInteger('production_id')->unsigned();
            $table->bigInteger('raw_materials_id')->unsigned();
            $table->timestamps();

            $table->foreign('production_id')
                ->references('id')
                ->on('productions')
                ->onDelete('cascade')
                ->onUpdate('no action');

            $table->foreign('raw_materials_id')
                ->references('id')
                ->on('raw_materials')
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
        Schema::dropIfExists('product_calculations');
    }
}
