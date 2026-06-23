<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\BrandRequest;
use App\Models\Brand; // BẮT BUỘC: Import Model Brand để không bị lỗi không tìm thấy Class
use Illuminate\Support\Str; // Import để xử lý tạo tự động chuỗi slug từ tên thương hiệu

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($limit = 10) // Bổ sung tham số mặc định $limit để không bị lỗi Undefined variable
    {
        $list = Brand::select('brandid', 'brandname', 'slug', 'image', 'status')
            ->orderBy('brandid', 'desc') // Đưa thương hiệu mới tạo lên trên đầu danh sách
            ->paginate($limit);

        return view('admin.brands.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request)
    {
        // Validation đã được xử lý trong BrandRequest

        try {
            Brand::create([
                'brandname' => $request->brandname,
                'slug'      => $request->slug ? Str::slug($request->slug) : Str::slug($request->brandname),
                'status'    => $request->status,
            ]);

            return redirect()
                ->route('admin.brands.index')
                ->with('success', 'Thêm thương hiệu thành công');
        } catch (\Exception $e) {
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
        // Thường không dùng trong trang quản trị nội bộ, để trống
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // THAY ĐỔI: Sử dụng where() tìm theo brandid thay vì find() tìm theo id mặc định
        $brand = Brand::where('brandid', $id)->first();

        if (!$brand) {
            return redirect()
                ->route('admin.brands.index')
                ->with('error', 'Thương hiệu không tồn tại!');
        }

        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, string $id)
    {
       
        try {
            // THAY ĐỔI: Sử dụng where() tìm theo brandid thay vì find() tìm theo id mặc định
            $brand = Brand::where('brandid', $id)->first();

            if (!$brand) {
                return redirect()
                    ->route('admin.brands.index')
                    ->with('error', 'Cập nhật thương hiệu thất bại');
            }

            $brand->update([
                'brandname' => $request->brandname,
                'slug'      => $request->slug ? Str::slug($request->slug) : Str::slug($request->brandname),
                'status'    => $request->status ?? 1,
            ]);

            return redirect()
                ->route('admin.brands.index')
                ->with('success', 'Cập nhật thương hiệu thành công');
        } catch (\Exception $e) {
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
        // THAY ĐỔI: Sử dụng cấu trúc tìm và xóa chính xác theo khóa chính brandid
        $brand = Brand::where('brandid', $id)->firstOrFail();
        $brand->delete();

        return redirect()->route('admin.brands.index')->with('success', 'Xóa thương hiệu thành công!');
    }
}