<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
                Rule::unique('products', 'productname')->ignore($id),
            ],
            'slug' => [
                'required',
                'min:5',
                'max:200',
                'regex:/^[a-zA-Z0-9_\-]+$/',
                Rule::unique('products', 'slug')->ignore($id),
            ],
            'cateid' => [
                'required',
                'exists:categories,cateid',
            ],
            'brandid' => [
                'nullable',
                'exists:brands,brandid',
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
            'description' => [
                'nullable',
                'not_regex:/[@!\$\^]/', 
            ],
            'img' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:200',
            ],
            'imgs' => [
                'nullable',
                'array',
            ],
            'imgs.*' => [
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
            'numeric' => ':attribute phải là số.',
            'lte' => ':attribute không được lớn hơn Giá gốc.',
            'slug.regex' => ':attribute chỉ được chứa chữ cái, số, dấu gạch dưới (_) và gạch ngang (-).',
            'description.not_regex' => ':attribute không được chứa các ký tự đặc biệt (@, !, $, ^).',
            'status.required' => 'Không được để trống trạng thái.',
            'status.in' => ':attribute không hợp lệ.',
            'cateid.exists' => 'Loại sản phẩm không tồn tại.',
            'brandid.exists' => 'Thương hiệu không tồn tại.',
            'img.image' => ':attribute phải là hình ảnh.',
            'img.mimes' => ':attribute chỉ chấp nhận các định dạng: jpg, jpeg, png, webp.',
            'img.max' => ':attribute không được vượt quá 200 KB.',
            'imgs.*.image' => 'Ảnh phụ phải là hình ảnh.',
            'imgs.*.mimes' => 'Ảnh phụ chỉ chấp nhận các định dạng: jpg, jpeg, png, webp.',
            'imgs.*.max' => 'Ảnh phụ không được vượt quá 200 KB.',
        ];
    }

    public function attributes(): array
    {
        return [
            'productname' => 'Tên sản phẩm',
            'slug' => 'Đường dẫn (Slug)',
            'cateid' => 'Loại sản phẩm',
            'brandid' => 'Thương hiệu',
            'price' => 'Giá sản phẩm',
            'pricediscount' => 'Giá khuyến mãi',
            'description' => 'Mô tả chi tiết',
            'img' => 'Hình ảnh chính',
            'imgs' => 'Hình ảnh phụ',
            'status' => 'Trạng thái',
        ];
    }
}
