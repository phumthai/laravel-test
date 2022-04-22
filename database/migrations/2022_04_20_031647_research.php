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
        Schema::create('research', function (Blueprint $table) {
            $table->id("researchNumber");
            //Foreign Key Constraints

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_Number');
            $table->unsignedBigInteger('file_Number');
            $table->unsignedBigInteger('permission_Number');
        
            //ฟิวด์ที่เพิ่มเข้ามา
            $table->string('researchName',255);
            $table->string('description',255);
            $table->string('keyword',50);
            $table->integer('downloadCount')->default(0);
            $table->timestamps();

            $table->foreign('file_Number')->references('fileNumber')->on('files')->onDelete('cascade');
            $table->foreign('category_Number')->references('categoryNumber')->on('category')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('permission_Number')->references('permissionNumber')->on('permission')->onDelete('cascade');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('research');
    }
};
