<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CustomerRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstname' => 'required|min:3|max:50',
            'lastname' => 'required|min:3|max:50',
            'email' => 'email|max:200',
            'address' => 'max:70',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'firstname.required' => 'Ingrese el nombre',
            'firstname.min' => 'El largo mínimo del nombre es de :min caracteres',
            'firstname.max' => 'El largo máximo del nombre es de :max caracteres',
            'lastname.required' => 'Ingrese el apellido',
            'lastname.min' => 'El largo mínimo del apellido es de :min caracteres',
            'lastname.max' => 'El largo máximo del apellido es de :max caracteres',
            'email.email' => 'El formato del email no es válido',
            'email.max' => 'El largo máximo del email es de :max caracteres',
            'address.max' => 'El largo máximo de la dirección es de :max caracteres',
        ];
    }
}
