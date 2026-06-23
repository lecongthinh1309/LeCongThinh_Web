<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\PostRequest;
use Illuminate\Support\Str;
use App\Models\Post; 

class PostController extends Controller
{
    public function index($limit = 10)
    {
        $list = DB::table('posts')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->select(
                'posts.id', 
                'posts.title',
                'posts.slug',
                'posts.image',
                'posts.status',
                'posts.created_at',
                'users.fullname as author_name' 
            )
            ->orderBy('posts.created_at', 'desc')
            ->paginate($limit); 

        return view('admin.posts.index', compact('list'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(PostRequest $request)
    {
        try {
            // Xử lý Upload Ảnh đại diện bài viết nếu có
            $imageName = null;
            if ($request->hasFile('image')) {
                $imageName = time() . '_' . $request->image->getClientOriginalName();
                $request->image->move(public_path('uploads/posts'), $imageName);
            }

            Post::create([
                'title'   => $request->title,
                'slug'    => $request->slug ? Str::slug($request->slug) : Str::slug($request->title),
                'content' => $request->content ?? '', // ĐỒNG BỘ: Sử dụng cột content thay vì detail
                'image'   => $imageName,             // ĐỒNG BỘ: Lưu tên file ảnh vào DB
                'status'  => $request->status ?? 1,
                'user_id' => auth()->id() ?? 1 
            ]);

            return redirect()
                ->route('admin.posts.index')
                ->with('success', 'Thêm bài viết thành công');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return redirect()
                ->route('admin.posts.index')
                ->with('error', 'Bài viết không tồn tại!');
        }

        return view('admin.posts.edit', compact('post'));
    }

    public function update(PostRequest $request, string $id)
    {
        try {
            $post = Post::find($id);

            if (!$post) {
                return redirect()
                    ->route('admin.posts.index')
                    ->with('error', 'Bài viết không tồn tại');
            }

            // Chuẩn bị mảng dữ liệu update cơ bản
            $data = [
                'title'   => $request->title,
                'slug'    => $request->slug ? Str::slug($request->slug) : Str::slug($request->title),
                'content' => $request->content ?? '', // ĐỒNG BỘ: Sử dụng cột content
                'status'  => $request->status ?? 1,
            ];

            // Nếu người dùng có chọn file ảnh mới thì xử lý upload và ghi đè ảnh cũ
            if ($request->hasFile('image')) {
                $imageName = time() . '_' . $request->image->getClientOriginalName();
                $request->image->move(public_path('uploads/posts'), $imageName);
                $data['image'] = $imageName;
            }

            $post->update($data);

            return redirect()
                ->route('admin.posts.index')
                ->with('success', 'Cập nhật bài viết thành công');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        DB::table('posts')->where('id', $id)->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Xóa bài viết thành công!');
    }
}