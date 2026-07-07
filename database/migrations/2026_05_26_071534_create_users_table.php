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
        $table->id(); // INT, AUTO_INCREMENT, PRIMARY KEY
        $table->string('fullname', 100); // VARCHAR(100)
        $table->string('username', 30)->unique(); // VARCHAR(30), UNIQUE
        $table->string('email', 50)->unique(); // VARCHAR(50), UNIQUE
        $table->string('password', 255); // VARCHAR(255) - tăng độ dài để lưu bcrypt hash
        $table->string('phone', 20)->unique(); // VARCHAR(20), UNIQUE
        $table->string('address', 255)->nullable(); // VARCHAR(255), NULL
        $table->tinyInteger('gender'); // tinyInteger (1: Nam, 2: Nữ, 0: Không cung cấp)
        $table->date('birthday')->nullable(); // Thêm trường ngày sinh
        $table->unsignedTinyInteger('role'); // tinyInteger, không âm (1: quản lý, 2: nhân viên)
        $table->tinyInteger('status')->default(1); // tinyInteger, default(1) (1: kích hoạt, 0: khóa)
        $table->rememberToken(); // Thêm cột remember_token cho chức năng ghi nhớ đăng nhập
        $table->timestamps(); // created_at và updated_at
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
