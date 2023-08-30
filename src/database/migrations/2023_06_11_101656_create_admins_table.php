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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('uid',100)->index()->nullable();
            $table->string('user_name')->unique();
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->longText('notification_settings')->nullable();
            $table->longText('permissions')->nullable();
            $table->longText('address')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable;
            $table->enum('status',[0,1])->default(1)->comment('Active : 1,Deactive : 0');
            $table->enum('super_admin',[0,1])->default(0)->comment('Yes : 1,No : 0');
            $table->timestamp('last_login')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
