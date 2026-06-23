<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CategoryRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // Cần thiết để dùng Str::slug
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
            Category::create([
                'catename' => $request->catename,
                'slug'     => $request->slug ? Str::slug($request->slug) : Str::slug($request->catename),
                'status'   => $request->status ?? 1,
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

            $category->update([
                'catename' => $request->catename,
                'slug'     => $request->slug ? Str::slug($request->slug) : Str::slug($request->catename),
                'status'   => $request->status ?? 1,
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
        DB::table('categories')->where('cateid', $id)->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Xóa danh mục thành công!');
    }
}