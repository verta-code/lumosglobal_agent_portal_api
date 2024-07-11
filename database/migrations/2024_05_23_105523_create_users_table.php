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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('organizationName');
            $table->string('legalEntityName')->nullable();;
            $table->string('firstName');
            $table->string('lastName');
            $table->enum('agentRole',['admin','agent','director','counsellor','owner','ceo','regioanl manager','franchise owner','marketing','manager'])->default('agent');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('mobile_number')->unique();
            $table->enum('Country', ['bangladesh', 'australia', 'other'])->default('bangladesh');
            $table->enum('status',['active','inactive'])->default('active');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
