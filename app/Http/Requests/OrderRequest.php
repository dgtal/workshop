<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class OrderRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
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
            'vehicle_id' => 'required|exists:vehicles,id',
            'odometer' => 'numeric',
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
            'vehicle_id.required' => 'Seleccione el vehículo',
            'vehicle_id.exists' => 'El vehículo seleccionado no existe',
            'odometer.numeric' => 'El kilometraje debe ser un valor numérico',
        ];
    }
}
