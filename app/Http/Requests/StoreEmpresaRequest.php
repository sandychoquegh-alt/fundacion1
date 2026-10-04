<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmpresaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check(); // ajustar si hace falta
    }

    public function rules()
    {
      return [
        'nombre' => 'required|string|max:150',
        'nit' => 'nullable|string|max:50',
        'representante' => 'required|string|max:100',
        'email' => 'required|email|unique:empresas,email',
        'telefono' => 'nullable|string|max:30',
        'direccion' => 'nullable|string',
        'rubro' => 'nullable|string|max:255',
        'estado' => 'required|in:pendiente,en_revision,aprobada,rechazada,inactivo',
        'tipo_empresa' => 'nullable|in:micro,pequeña,mediana,grande',
        'sector' => 'nullable|string|max:100',
        'fecha_registro' => 'nullable|date',
           ];
    }

}



