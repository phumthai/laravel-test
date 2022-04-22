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
        Schema::create('files', function (Blueprint $table) {
            $table->id("fileNumber");
            //ฟิวด์ที่เพิ่มเข้ามา
            $table->string('fileName',50);
            $table->string('fileType',50);
            $table->string('fileDirectory',50);
            $table->timestamps();
        });
        DB::statement("ALTER TABLE files ADD fileData LONGBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
};
