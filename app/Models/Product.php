<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Chỉ định chính xác tên bảng trong database
    protected $table = 'products';

    // Đổi sang 'id' để đồng bộ khớp hoàn toàn với câu lệnh SQL ở Controller và Database của bạn
    protected $primaryKey = 'id';

    // Các cột cho phép thêm/sửa dữ liệu hàng loạt (Mass Assignment)
    protected $fillable = [
        'productname',
        'slug',
        'cateid',
        'brandid',
        'image',
        'price',
        'pricediscount', 
        'detail',        // Giữ lại 'detail' nếu DB của bạn dùng trường này
        'description',   // BỔ SUNG THÊM: trường 'description' để đi theo đúng chuẩn file Lab 08 mẫu
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'cateid', 'cateid');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brandid', 'brandid');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}