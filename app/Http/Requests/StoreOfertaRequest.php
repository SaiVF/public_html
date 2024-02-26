<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOfertaRequest extends FormRequest
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
            /*'title' => ['required|max:255'],*/
            'title' => ['required'],
            'category' => ['required'],
            'contacto_con' => ['required'],
            'nivel' => ['required'],
            'tema' => ['required'],
            'tiempo' => ['required'],
            'precio' => ['required'],
            'descripcion' => ['required'],
            'pais_id' => ['required'],
            'departamento' => ['required'],
            'ciudad' => ['required'],
            'vacancias_disponibles' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Debes completar el título de la oferta.',
            'category.required' => 'Debes elegir una categoría para la oferta',
            'contacto_con.required' => 'Debes indicar un contacto',
            'pais_id.required' => 'Debes indicar un País',
            'departamento.required' => 'Debes indicar un Departamento',
            'ciudad.required' => 'Debes indicar una Ciudad',
            'precio.required' => 'Debes un tipo de financiamiento'

        ];
    }
}
