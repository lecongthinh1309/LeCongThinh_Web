<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Cho phép thực thi request
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // route param trong Resource Controller mặc định là số ít của tên controller, ở đây là 'product'
        $id = $this->route('product');

        return [
            'productname' => [
                'required',
                'min:5',
                'max:150',
                \Illuminate\Validation\Rule::unique('products', 'productname')->ignore($id),
            ],
            'slug' => [
                'required',
                'min:5',
                'max:200',
                'regex:/^[a-zA-Z0-9_\-]+$/',
                \Illuminate\Validation\Rule::unique('products', 'slug')->ignore($id),
            ],
            'price' => [
                'required',
                'numeric',
                'min:0',
                'max:9999999',
            ],
            'pricediscount' => [
                'nullable',
                'numeric',
                'min:0',
                'lte:price', // Không được lớn hơn price
            ],
            'status' => [
                'required',
                'in:0,1',
            ],
            'cateid' => [
                'required',
                'exists:categories,cateid',
            ],
            'brandid' => [
                'nullable',
                'exists:brands,brandid',
            ],
            'description' => [
                'nullable',
                'not_regex:/[@!\$\^]/', // Không chứa các ký tự @, !, $, ^
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
            'numeric' => ':attribute phải là số.',
            'lte' => ':attribute không được lớn hơn Giá gốc.',
            'slug.regex' => ':attribute chỉ được chứa chữ cái, số, dấu gạch dưới (_) và gạch ngang (-).',
            'description.not_regex' => ':attribute không được chứa các ký tự đặc biệt (@, !, $, ^).',
            'status.required' => 'Không được để trống trạng thái.',
            'status.in' => ':attribute không hợp lệ.',
            'cateid.exists' => 'Loại sản phẩm không tồn tại.',
            'brandid.exists' => 'Thương hiệu không tồn tại.',
        ];
    }

    public function attributes(): array
    {
        return [
            'productname' => 'Tên sản phẩm',
            'slug' => 'Đường dẫn (Slug)',
            'price' => 'Giá sản phẩm',
            'pricediscount' => 'Giá khuyến mãi',
            'status' => 'Trạng thái',
            'cateid' => 'Loại sản phẩm',
            'brandid' => 'Thương hiệu',
            'description' => 'Mô tả chi tiết',
        ];
    }
}
