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
        Schema::create('evaluation_takens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained(
                table: 'users',
                // indexName: 'message_receiver_id'
            );
            $table->foreignId('teacher_id')->constrained(
                table: 'users',
                // indexName: 'message_receiver_id'
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_takens');
    }
};
