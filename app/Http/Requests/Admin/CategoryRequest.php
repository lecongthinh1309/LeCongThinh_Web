<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
        $id = $this->route('category');

        return [
            'catename' => [
                'required',
                'min:3',
                'max:100',
                Rule::unique('categories', 'catename')->ignore($id, 'cateid'),
            ],
            'slug' => [
                'required',
                'min:5',
                'max:150',
                'regex:/^[a-z0-9\-]+$/',
                Rule::unique('categories', 'slug')->ignore($id, 'cateid'),
            ],
            'img' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:200',
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
            
            'img.image' => ':attribute phải là hình ảnh.',
            'img.mimes' => ':attribute chỉ chấp nhận các định dạng: jpg, jpeg, png, webp.',
            'img.max' => ':attribute không được vượt quá 200 KB.',
            
            'status.required' => 'Không được để trống trạng thái.',
            'status.in' => ':attribute không hợp lệ.',
        ];
    }

    public function attributes(): array
    {
        return [
            'catename' => 'Tên loại',
            'slug' => 'Đường dẫn (Slug)',
            'img' => 'Hình ảnh',
            'status' => 'Trạng thái',
        ];
    }
}
