<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

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
                \Illuminate\Validation\Rule::unique('categories', 'catename')->ignore($id, 'cateid'),
            ],
            'slug' => [
                'required',
                'min:5',
                'max:150',
                'regex:/^[a-z0-9\-]+$/',
                \Illuminate\Validation\Rule::unique('categories', 'slug')->ignore($id, 'cateid'),
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
            'status.required' => 'Không được để trống trạng thái.',
            'status.in' => ':attribute không hợp lệ.'
        ];
    }

    public function attributes(): array
    {
        return [
            'catename' => 'Tên loại',
            'slug' => 'Đường dẫn (Slug)',
            'status' => 'Trạng thái'
        ];
    }
}
