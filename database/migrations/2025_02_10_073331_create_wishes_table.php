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
        Schema::disableForeignKeyConstraints();

        Schema::create('wishes', function (Blueprint $table) {
            $table->id('wish_id');
            $table->unsignedBigInteger('guest_id');
            $table->foreign('guest_id')->references('guest_id')->on('guests');
            $table->string('message', 255);
            $table->timestamp('posted_at');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishes');
    }
};
