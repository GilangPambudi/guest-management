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
            $table->string('wedding_name', 255);
            $table->string('groom_name', 255);
            $table->string('bride_name', 255);
            $table->string('groom_alias', 255);
            $table->string('bride_alias', 255);
            $table->date('wedding_date');
            $table->time('wedding_time_start');
            $table->time('wedding_time_end');
            $table->string('wedding_venue', 255);
            $table->string('wedding_location', 255);
            $table->string('wedding_maps', 255);
            $table->string('wedding_image', 255)->nullable();
            $table->timestamps();
        });

        Schema::table('guests', function (Blueprint $table) {
            $table->unsignedBigInteger('event_id')->nullable();
            $table->foreign('event_id')->references('event_id')->on('wedding_events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
            $table->dropColumn('event_id');
        });

        Schema::dropIfExists('invitation');
    }
};
