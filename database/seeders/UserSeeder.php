<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo tài khoản admin cố định để dễ test đăng nhập
        DB::table('users')->insert([
            'fullname'   => 'Administrator',
            'username'   => 'admin',
            'email'      => 'admin@example.com',
            'password'   => Hash::make('123456'), // Mã hóa bcrypt
            'phone'      => '0900000000',
            'address'    => 'TP. Hồ Chí Minh',
            'gender'     => 1,
            'birthday'   => '1990-01-01',
            'role'       => 1, // Quản lý
            'status'     => 1, // Kích hoạt
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Tạo thêm 9 user ngẫu nhiên
        for ($i = 1; $i <= 9; $i++) {
            DB::table('users')->insert([
                'fullname'   => fake()->name(),
                'username'   => fake()->unique()->userName(),
                'email'      => fake()->unique()->safeEmail(),
                'password'   => Hash::make('123456'), // Dùng Hash::make() thay vì md5
                'phone'      => fake()->unique()->phoneNumber(),
                'address'    => fake()->address(),
                'gender'     => fake()->randomElement([0, 1, 2]),
                'birthday'   => fake()->date('Y-m-d', '2005-01-01'),
                'role'       => fake()->randomElement([1, 2]),
                'status'     => fake()->numberBetween(0, 1),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}