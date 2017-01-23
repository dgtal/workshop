<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ModelRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
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
            'make_id' => 'required|exists:makes,id',
            'name' => 'required|min:2|max:100'
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
            'make_id.required' => 'Seleccione la marca',
            'make_id.exists' => 'La marca seleccionada no existe',
            'name.required' => 'Ingrese el nombre',
            'name.min' => 'El largo mínimo del nombre es de :min caracteres',
            'name.max' => 'El largo máximo del nombre es de :max caracteres',
        ];
    }
}
