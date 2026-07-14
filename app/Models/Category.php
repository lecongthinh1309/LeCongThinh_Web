<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    // chỉ định tên bảng trong database
    // (có thể bỏ qua khai báo $table nếu đặt theo nguyên tắc số nhiều)
    protected $table = 'categories';

    // chỉ định khóa chính
    // (có thể bỏ qua khai báo $primaryKey nếu primary key là id)
    protected $primaryKey = 'cateid';

    // các cột cho phép thêm/sửa dữ liệu hàng loạt
    protected $fillable = [
        'catename',
        'slug',
        'description',
        'image',
        'status'
    ];
}