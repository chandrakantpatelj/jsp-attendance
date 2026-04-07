<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('regularizations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('attendance_id');
            $table->string('requested_punch_in');
            $table->string('requested_punch_out');
            $table->text('reason');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
            
            $table->foreign('employee_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('attendance_id')->references('id')->on('attendances')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('regularizations');
    }
};