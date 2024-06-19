<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required',
            'phone' => 'required',
        ];
        if ($this->isMethod('post')) {
            $rules += [
                'password' => 'required|min:8',
                'username' => 'required|unique:users,username,'.$this->user,
                'email' => 'required|unique:users,email,'.$this->user,
            ];
        }
        return $rules;
    }
    public function attributes()
    {
        return [
            'username' => 'Tên đăng nhập',
            'password' => 'Mật khẩu',
            'name' => 'Họ tên',
            'phone' => 'Số điện thoại',
        ];
    }
    public function messages()
    {
        return [
            'required' => ': không được để trống',
            'unique' => ': đã tồn tại',
            'min' => ': phải chứa ít nhất 8 ký tự.',
        ];
    }
}
