<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CategoryRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // Cần thiết để dùng Str::slug
use Illuminate\Support\Facades\Storage; // Import Storage để xóa ảnh
use App\Models\Category;



class CategoryController extends Controller
{
    public function index($limit = 10)
    {
        // $list = DB::table('categories')
        //     ->select('cateid', 'catename', 'slug', 'image', 'status')
        //     ->orderBy('cateid', 'desc') // Đổi sang desc để cái mới lên đầu
        //     ->get();

        $list = Category::select('cateid', 'catename', 'slug', 'image', 'status')
            ->orderBy('catename')
            ->paginate($limit);

        return view('admin.categories.index', compact('list'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(CategoryRequest $request)
    {
        // Validation đã được xử lý trong CategoryRequest

        try {
            // upload hình ảnh (nếu có)
            $fileName = null;
            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $fileName = Str::slug($request->catename)
                    . '-' . time()
                    . '.' . $file->extension();
                $file->storeAs('categories', $fileName, 'public');
            }

            Category::create([
                'catename' => $request->catename,
                'slug'     => $request->slug ? Str::slug($request->slug) : Str::slug($request->catename),
                'status'   => $request->status ?? 1,
                'image'    => $fileName
            ]);

            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Thêm danh mục thành công');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    // --- CÁC CHỨC NĂNG BỔ SUNG ---

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
   {
        // Chú ý: dùng khoá chính của bảng category, có thể là id hoặc cateid tuỳ bạn cấu hình trong Model
        $category = Category::find($id);

        if (!$category) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'Danh mục không tồn tại!');
        }

        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
   {
        try {
            $category = Category::find($id);

            if (!$category) {
                return redirect()
                    ->route('admin.categories.index')
                    ->with('error', 'Danh mục không tồn tại');
            }

            // Có chọn hình ảnh mới
            $fileName = $category->image;
            if ($request->hasFile('img')) {
                // Xóa hình ảnh cũ
                if ($fileName) {
                    Storage::disk('public')->delete('categories/' . $category->image);
                }
                // Upload hình ảnh mới
                $file = $request->file('img');
                $fileName = Str::slug($request->catename)
                    . '-' . time()
                    . '.' . $file->extension();
                $file->storeAs('categories', $fileName, 'public');
            }

            $category->update([
                'catename' => $request->catename,
                'slug'     => $request->slug ? Str::slug($request->slug) : Str::slug($request->catename),
                'status'   => $request->status ?? 1,
                'image'    => $fileName,
            ]);

            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Cập nhật danh mục thành công');
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
        try {
            Category::findOrFail($id)->delete();
            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Xóa thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Thực hiện thất bại.');
        }
    }

    public function trash()
    {
        $list = Category::onlyTrashed()
            ->orderBy('catename')
            ->paginate(10);
        return view('admin.categories.trash', compact('list'));
    }

    public function restore($id)
    {
        try {
            Category::onlyTrashed()->findOrFail($id)->restore();
            return redirect()
                ->route('admin.categories.trash')
                ->with('success', 'Khôi phục thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Khôi phục thất bại.');
        }
    }

    public function forceDelete($id)
    {
        try {
            Category::onlyTrashed()->findOrFail($id)->forceDelete();
            return redirect()
                ->route('admin.categories.trash')
                ->with('success', 'Xóa vĩnh viễn thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Xóa thất bại.');
        }
    }
}