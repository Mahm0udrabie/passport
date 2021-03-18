<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sender_id')->unsigned()->index()->nullable();
            $table->foreign('sender_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            $table->bigInteger('receiver_id')->unsigned()->index()->nullable();
            $table->foreign('receiver_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            $table->text('body')->nullable();
            $table->tinyInteger('is_opened')->default(0);
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
        Schema::dropIfExists('chats');
    }
}
