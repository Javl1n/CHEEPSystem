<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('content');
            // $table->unsignedBigInteger('user_id');
            // $table->foreign('user_id')->references('id')->on('users');
            $table->foreignId('sender_id')->constrained(
                table: 'users', 
                // indexName: 'message_sender_id'
            );
            $table->foreignId('receiver_id')->constrained(
                table: 'users', 
                // indexName: 'message_receiver_id'
            );
            $table->boolean('read')->default(false);
            $table->boolean('liked')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
