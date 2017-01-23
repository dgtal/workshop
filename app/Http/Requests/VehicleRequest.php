<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class VehicleRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
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
            'customer_id' => 'required|exists:customers,id',
            'model_id' => 'required|exists:models,id',
            'plate' => 'required|min:5|max:10'
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
            'customer_id.required' => 'Seleccione el cliente',
            'customer_id.exists' => 'La cliente seleccionado no existe',
            'model_id.required' => 'Seleccione el modelo',
            'model_id.exists' => 'El modelo seleccionado no existe',
            'plate.required' => 'Ingrese la matrícula',
            'plate.min' => 'El largo mínimo de la matrícula es de :min caracteres',
            'plate.max' => 'El largo máximo de la matrícula es de :max caracteres',
        ];
    }
}
