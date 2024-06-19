<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $productId = $this->route('product');
        $rules = [
            'name' => 'required',
            'store_id' => 'required',
            'code' => 'required|unique:products,code,' . $productId . ',id,store_id,' . $this->input('store_id'),
            'price_origin' => 'required|numeric|min:' . $this->input('price_sale'), 
            'price_sale' => 'required|numeric',
        ];
        return $rules;
    }
    public function messages()
    {
        return [
            'required' => ': không được để trống',
            'unique' => ': đã tồn tại',
            'numeric' => ': phải là số nguyên',
            'min' => ': phải lớn hơn hoặc bằng :min'
        ];
    }
}
