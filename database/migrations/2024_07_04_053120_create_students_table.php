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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('salutation');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('date_of_birth');
            $table->string('student_phone_number')->unique();
            $table->string('language');
            $table->enum('gender', ['male', 'female', 'other'])->default('other');
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed','engaged', 'de_facto', 'separated'])->default('single');
            $table->enum('country_of_birth', ['bangladesh', 'australia', 'other'])->default('bangladesh');
            $table->string('passport_number');
            $table->string('passort_expiry_date');
//            $table->string('country_of_passport');
            $table->string('current_student_location');
            $table->boolean('is_18_or_older');
            $table->string('team_assignment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
