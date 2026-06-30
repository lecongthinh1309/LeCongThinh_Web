<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\BrandRequest;
use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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

        try {
            // upload hình ảnh (nếu có)
            $fileName = null;
            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $fileName = Str::slug($request->brandname)
                    . '-' . time()
                    . '.' . $file->extension();
                // hình ảnh được lưu vào thư mục storage/app/public/brands
                $file->storeAs('brands', $fileName, 'public');
            }

            // thực hiện thêm dữ liệu
            Brand::create([
                'brandname' => $request->brandname,
                'slug'      => $request->slug ? Str::slug($request->slug) : Str::slug($request->brandname),
                'status'    => $request->status,
                'description' => $request->description,
                'image'     => $fileName
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
            // Tìm brand theo id
            $brand = Brand::findOrFail($id);
            // Có chọn hình ảnh mới
            // Giữ tên hình ảnh cũ
            $fileName = $brand->image;
            if ($request->hasFile('img')) {
                // Xóa hình ảnh cũ
                if ($fileName) {
                    Storage::disk('public')->delete('brands/' . $brand->image);
                }
                // Upload hình ảnh mới
                $file = $request->file('img');
                $fileName = Str::slug($request->brandname)

                    . '-' . time()
                    . '.' . $file->extension();
                $file->storeAs('brands', $fileName, 'public');
            }
            $brand->update([
                'brandname' => $request->brandname,
                'slug' => $request->slug,
                'status' => $request->status,
                'description' => $request->description,
                'image' => $fileName,
            ]);
            return redirect()
                ->route('admin.brands.index')
                ->with('success', 'Cập nhật thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Cập nhật thất bại.');
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
