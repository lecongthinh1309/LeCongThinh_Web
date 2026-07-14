<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Trang chi tiết sản phẩm
    public function show($slug)
    {
        $product = Product::with(['category', 'brand', 'images'])
            ->where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        $related = Product::with(['brand'])
            ->where('cateid', $product->cateid)
            ->where('id', '!=', $product->id)
            ->where('status', 1)
            ->take(4)
            ->get();

        return view('client.product.show', compact('product', 'related'));
    }

    // Lọc sản phẩm theo danh mục
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->where('status', 1)->firstOrFail();

        $products = Product::with(['brand'])
            ->where('cateid', $category->cateid)
            ->where('status', 1)
            ->paginate(12);

        $categories = Category::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();

        return view('client.product.list', compact('products', 'category', 'categories', 'brands'));
    }

    // Lọc sản phẩm theo thương hiệu
    public function brand($slug)
    {
        $brand = Brand::where('slug', $slug)->where('status', 1)->firstOrFail();

        $products = Product::with(['category'])
            ->where('brandid', $brand->brandid)
            ->where('status', 1)
            ->paginate(12);

        $categories = Category::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();

        return view('client.product.list', compact('products', 'brand', 'categories', 'brands'));
    }

    // Tìm kiếm sản phẩm
    public function search(Request $request)
    {
        $keyword = $request->get('keyword', '');

        $products = Product::with(['category', 'brand'])
            ->where('status', 1)
            ->where('productname', 'LIKE', "%{$keyword}%")
            ->paginate(12);

        $categories = Category::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();

        return view('client.product.list', compact('products', 'keyword', 'categories', 'brands'));
    }
}
