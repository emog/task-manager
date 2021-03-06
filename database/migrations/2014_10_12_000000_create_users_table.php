<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
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
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
        DB::table('users')->insert(['email' => 'test@test.com', 'name' => 'Test', 'password' => Hash::make('password'), 'created_at' => now(), 'updated_at' => now()]);
        DB::table('users')->insert(['email' => 'test1@test.com', 'name' => 'Test', 'password' => Hash::make('password'), 'created_at' => now(), 'updated_at' => now()]);
        DB::table('users')->insert(['email' => 'test2@test.com', 'name' => 'Test', 'password' => Hash::make('password'), 'created_at' => now(), 'updated_at' => now()]);
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
}
