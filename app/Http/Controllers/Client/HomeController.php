<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // Sản phẩm nổi bật (giảm giá cao nhất)
        $featuredProducts = Product::with(['category', 'brand'])
            ->where('status', 1)
            ->orderByRaw('(price - pricediscount) DESC')
            ->take(8)
            ->get();

        // Sản phẩm mới nhất
        $newProducts = Product::with(['category', 'brand'])
            ->where('status', 1)
            ->latest()
            ->take(8)
            ->get();

        // Tất cả danh mục
        $categories = Category::where('status', 1)->get();

        // Tất cả thương hiệu
        $brands = Brand::where('status', 1)->get();

        return view('client.home.index', compact(
            'featuredProducts', 'newProducts', 'categories', 'brands'
        ));
    }
}
