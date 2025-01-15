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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100); // 'title' with max length 100, required
            $table->text('description'); // 'description' field, required
            $table->date('date'); // 'date' field, required
            $table->time('time'); // 'time' field, required
            $table->unsignedBigInteger('venue_id'); // Foreign key to 'venues' table
            $table->unsignedBigInteger('created_by'); // Foreign key to 'users' table
            $table->timestamp('created_at')->useCurrent(); // Default 'created_at' to current timestamp
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // Default 'updated_at' to current timestamp and update on record update

            // Define foreign key constraints
            $table->foreign('venue_id')->references('id')->on('venues')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
};
