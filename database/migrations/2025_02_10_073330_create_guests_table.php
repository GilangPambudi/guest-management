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
            $table->string('guest_id_qr_code', 255);
            $table->string('guest_name', 255);
            $table->enum('guest_gender', ["Male", "Female"]);
            $table->string('guest_category', 255);
            $table->string('guest_contact', 255);
            $table->string('guest_address', 255);
            $table->string('guest_qr_code', 255);
            $table->string('guest_attendance_status', 255)->default('-');
            $table->string('guest_arrival_time', 255)->default('-');
            $table->string('guest_invitation_status', 255)->default('-');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->timestamps();
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
