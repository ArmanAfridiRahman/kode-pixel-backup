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
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('uid',100)->index()->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->string("name");
            $table->string("slug");
            $table->string("subject")->nullable();
            $table->longText("body")->nullable();
            $table->longText("sms_body")->nullable();
            $table->json("sort_code")->nullable();
            $table->enum('status',[0,1])->default(1)->comment('Active : 1,Deactive : 0');   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};
