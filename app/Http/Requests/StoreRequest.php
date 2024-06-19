<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'description' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'tax_code' => 'required|unique:stores,tax_code,'.$this->store,
        ];
    
        return $rules;
    }
    public function attributes()
    {
        return [
            'name' => 'Tên nhà bán hàng',
            'description' => 'Mô tả Shop',
            'tax_code' => 'Mã số thuế',
            'phone' => 'Số điện thoại',
            'address' => 'Địa chỉ',

            
        ];
    }
    public function messages()
    {
        return [
            'required' => ': không được để trống',
            'unique' => ': đã tồn tại',
        ];
    }
}
