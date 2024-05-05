<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('admin_id')->constrained()->onUpdate('cascade'); 
            $table->foreignId('category_id')->constrained()->onUpdate('cascade'); 
            $table->string('name'); 
            $table->string('memo');
            $table->integer('price'); 
            $table->string('img_path'); 
            $table->timestamps(); 
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
};
