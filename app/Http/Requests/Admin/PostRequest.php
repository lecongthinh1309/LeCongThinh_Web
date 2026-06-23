<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('post');

        return [
            'title' => [
                'required',
                'min:3',
                'max:200',
                \Illuminate\Validation\Rule::unique('posts', 'title')->ignore($id),
            ],
            'slug' => [
                'nullable',
                'min:5',
                'max:255',
                'regex:/^[a-z0-9\-]+$/',
                \Illuminate\Validation\Rule::unique('posts', 'slug')->ignore($id),
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048'
            ],
            'content' => [
                'required',
            ],
            'status' => [
                'required',
                'in:0,1',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống.',
            'min' => ':attribute phải từ :min ký tự trở lên.',
            'max' => ':attribute không vượt quá :max ký tự.',
            'unique' => ':attribute đã tồn tại.',
            'slug.regex' => ':attribute chỉ được chứa chữ thường, số và dấu gạch ngang (-).',
            'image' => ':attribute phải là hình ảnh hợp lệ.',
            'mimes' => ':attribute phải có định dạng jpeg, png, jpg, gif.',
            'status.required' => 'Không được để trống trạng thái.',
            'status.in' => ':attribute không hợp lệ.'
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Tiêu đề bài viết',
            'slug' => 'Đường dẫn (Slug)',
            'image' => 'Hình ảnh đại diện',
            'content' => 'Nội dung chi tiết',
            'status' => 'Trạng thái'
        ];
    }
}
