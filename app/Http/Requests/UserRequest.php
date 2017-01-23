<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
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
            'name' => 'required|min:3|max:255',
            'email' => 'email|required|max:255|unique:users,email',
            'password' => 'required|max:70',
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
            'name.required' => 'Ingrese el nombre',
            'name.min' => 'El largo mínimo del nombre es de :min caracteres',
            'name.max' => 'El largo máximo del nombre es de :max caracteres',
            'email.email' => 'El formato del email no es válido',
            'email.max' => 'El largo máximo del email es de :max caracteres',
            'email.unique' => 'El email ya está siendo utilizado',
            'password.required' => 'Ingrese la clave',
        ];
    }
}
