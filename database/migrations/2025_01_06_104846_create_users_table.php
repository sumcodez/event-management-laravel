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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 50); // 'first_name' with max length 50
            $table->string('last_name', 50); // 'last_name' with max length 50
            $table->string('email')->unique(); // 'email' with unique constraint
            $table->string('password'); // 'password' field
            $table->boolean('is_admin')->default(0); // 'is_admin' field with default value 0
            $table->timestamp('created_at')->useCurrent(); // Default 'created_at' to current timestamp
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
