<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
     * @return array<string, 
     */
    public function rules(): array
    {
        $id = $this->route('user');

        return [
            'username' => [
                'required',
                'max:30',
                Rule::unique('users', 'username')->ignore($id),
            ],
            'fullname' => [
                'required',
                'max:100',
            ],
            'email' => [
                'required',
                'email',
                'max:50',
                Rule::unique('users', 'email')->ignore($id),
            ],
            'phone' => [
                'required',
                'max:20',
                Rule::unique('users', 'phone')->ignore($id),
            ],
            'password' => [
                $id ? 'nullable' : 'required',
                'min:6',
                'max:50'
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
            'max'      => ':attribute không vượt quá :max ký tự.',
            'unique'   => ':attribute đã tồn tại.',
            'email'    => ':attribute không hợp lệ.',
            'min'      => ':attribute phải từ :min ký tự trở lên.',
            'status.required' => 'Không được để trống trạng thái.',
            'status.in' => ':attribute không hợp lệ.'
        ];
    }

    public function attributes(): array
    {
        return [
            'username' => 'Tên tài khoản',
            'fullname' => 'Họ và tên',
            'email'    => 'Địa chỉ email',
            'password' => 'Mật khẩu',
            'phone'    => 'Số điện thoại',
            'status'   => 'Trạng thái'
        ];
    }
}
