<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\ProductRequest;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($limit = 10)
    {
        // Sử dụng Eloquent Eager Loading (with) để code sạch hơn và tối ưu truy vấn tốt hơn join thuần
        $list = Product::with(['category', 'brand'])
            ->select('id', 'productname', 'price', 'pricediscount', 'image', 'status', 'cateid', 'brandid')
            ->latest('id')
            ->paginate($limit);

        return view('admin.products.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Chuyển sang dùng Model đồng bộ với toàn dự án
        $categories = Category::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        // Validation đã được xử lý trong ProductRequest

        try {
            // Upload hình ảnh chính
            $fileName = null;
            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $fileName = Str::slug($request->productname)
                    . '-' . time()
                    . '.' . $file->extension();
                $file->storeAs('products', $fileName, 'public');
            }

            // Lưu sản phẩm
            $product = Product::create([
                'productname'   => $request->productname,
                'slug'          => $request->slug ? Str::slug($request->slug) : Str::slug($request->productname),
                'cateid'        => $request->cateid,
                'brandid'       => $request->brandid,
                'price'         => $request->price,
                'pricediscount' => $request->pricediscount ?? 0,
                'description'   => $request->description,
                'status'        => $request->status,
                'image'         => $fileName,
            ]);

            // Upload hình ảnh phụ
            if ($request->hasFile('imgs')) {
                $i = 1;
                $time = time(); // cùng timestamp
                foreach ($request->file('imgs') as $file) {
                    $fileNameImg = $product->id
                        . '_' . $time . '_' . $i . '.' . $file->extension();
                    $file->storeAs('products', $fileNameImg, 'public');
                    // Lưu vào bảng product_images
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $fileNameImg,
                    ]);
                    $i++;
                }
            }

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Thêm sản phẩm thành công');

        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::with('images')->findOrFail($id);
        $categories = Category::select('cateid', 'catename')->get();
        $brands = Brand::select('brandid', 'brandname')->get();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        // Validation đã được xử lý trong ProductRequest

        try {
            $product = Product::findOrFail($id);

            // Upload hình ảnh chính
            $fileName = $product->image;
            if ($request->hasFile('img')) {
                // Xóa ảnh cũ
                if ($fileName) {
                    Storage::disk('public')->delete('products/' . $product->image);
                }
                $file = $request->file('img');
                $fileName = Str::slug($request->productname)
                    . '-' . time()
                    . '.' . $file->extension();
                $file->storeAs('products', $fileName, 'public');
            }

            $product->update([
                'productname'   => $request->productname,
                'slug'          => $request->slug ? Str::slug($request->slug) : Str::slug($request->productname),
                'cateid'        => $request->cateid,
                'brandid'       => $request->brandid,
                'price'         => $request->price,
                'pricediscount' => $request->pricediscount ?? 0,
                'status'        => $request->status,
                'description'   => $request->description ?? '',
                'image'         => $fileName,
            ]);

            // Upload ảnh phụ
            if ($request->hasFile('imgs')) {
                $i = 1;
                $time = time();
                foreach ($request->file('imgs') as $file) {
                    $fileNameImg = $product->id
                        . '_' . $time . '_' . $i . '.' . $file->extension();
                    $file->storeAs('products', $fileNameImg, 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $fileNameImg,
                    ]);
                    $i++;
                }
            }

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Cập nhật sản phẩm thành công');

        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Xóa sản phẩm thành công!');
    }

    public function destroyImage(string $id)
    {
        try {
            $image = ProductImage::findOrFail($id);
            if ($image->image) {
                Storage::disk('public')->delete('products/' . $image->image);
            }
            $image->delete();
            return response()->json(['success' => true, 'message' => 'Xóa ảnh thành công!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lỗi xóa ảnh: ' . $e->getMessage()], 500);
        }
    }

    public function test1()
    {
        return redirect()->route('admin.home');
    }

    public function test2()
    {
        return redirect('/admin/dashboard');
    }
}