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
            $table->unsignedTinyInteger('week');
            $table->unsignedTinyInteger('day');
            $table->unsignedSmallInteger('time');
            $table->string('tools')->nullable();
            $table->string('name');
            $table->text('objective');
            $table->text('instructions');
            $table->string('file_path');
            $table->enum('type', [0, 1, 2, 3, 4]);
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
        Schema::dropIfExists('items');
    }
};
