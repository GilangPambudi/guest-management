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

        Schema::create('guests', function (Blueprint $table) {
            $table->id('guest_id');
            $table->string('guest_name', 255);
            $table->string('guest_category', 255);
            $table->string('guest_contact', 255);
            $table->string('guest_address', 255);
            $table->string('guest_qr_code', 255);
            $table->enum('guest_attendance_status', ["Yes", "No", "Pending", "-"]);
            $table->enum('guest_invitation_status', ["Sent", "Opened", "-"]);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('users');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
