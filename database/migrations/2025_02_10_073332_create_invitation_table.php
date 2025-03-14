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

        Schema::create('invitation', function (Blueprint $table) {
            $table->id('invitation_id');
            $table->unsignedBigInteger('guest_id');
            $table->foreign('guest_id')->references('guest_id')->on('guests');
            $table->string('wedding_name', 255);
            $table->unsignedBigInteger('groom_id');
            $table->foreign('groom_id')->references('couple_id')->on('couples');
            $table->unsignedBigInteger('bride_id');
            $table->foreign('bride_id')->references('couple_id')->on('couples');
            $table->date('wedding_date');
            $table->timestamp('wedding_time_start');
            $table->timestamp('wedding_time_end');
            $table->string('location', 255);
            $table->enum('status', ["sent", "opened"]);
            $table->timestamp('opened_at')->nullable();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitation');
    }
};
