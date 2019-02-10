<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->engine = 'InnoDB';
            $table->uuid('id')->primary();
            $table->string('agent_code')->nullable();
            $table->string('email')->unique();
            $table->string('name');
            $table->string('surname');
            $table->string('contact_number');
            $table->string('alternate_number')->nullable();
            $table->string('address')->nullable();
            $table->date('dob')->nullable();
            $table->uuid('location_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('profile_picture_url')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
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
}
