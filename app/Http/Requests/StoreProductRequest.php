<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|unique:products',
            'category_id' => 'required|numeric|min:1',
            'price' => 'required|numeric|not_in:0',
            'description' => 'required',
            'stock' => 'required|numeric|not_in:0',
            'wholesale_quantity' => 'required|numeric|not_in:0',
            'code' => 'required'
        ];
    }
}
