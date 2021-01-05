<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'name' => 'required|min:4',
            'type_document' => 'required|string|min:1',
            'num_document' => 'required|numeric|unique:customers',
            'email' => 'required|email|max:255|unique:users',
            'email' => 'required|email|max:255|unique:customers',
            'num_phone' => 'required',
            'address' => 'required|min:6',
        ];
    }

    public function attributes(){
        return [
            'name' => 'Nombre del Usuario',
            'type_document' => 'Tipo de Nacionalidad',
            'num_document' => 'N° de Documento',
            'email' => 'Correo Electrónico',
            'num_phone' => 'Número de Telefono',
            'address' => 'Dirección',
        ];
    }
}
