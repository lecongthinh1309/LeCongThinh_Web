<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
        // Lấy id từ URL (segment cuối) vì Brand dùng khóa chính tùy chỉnh 'brandid'
        $brand = $this->route('brand');
        // Nếu là Model object (Route Model Binding), lấy brandid; nếu là string thì dùng trực tiếp
        $id = ($brand instanceof \App\Models\Brand) ? $brand->brandid : $brand;

        return [
            'brandname' => [
                'required',
                'min:3',
                'max:150',
                \Illuminate\Validation\Rule::unique('brands', 'brandname')->ignore($id, 'brandid'),
            ],
            'slug' => [
                'required',
                'min:5',
                'max:150',
                'regex:/^[a-z0-9\-]+$/',
                \Illuminate\Validation\Rule::unique('brands', 'slug')->ignore($id, 'brandid'),
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
            'brandname' => 'Tên thương hiệu',
            'slug' => 'Đường dẫn (Slug)',
            'status' => 'Trạng thái'
        ];
    }
}
