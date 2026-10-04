<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmpresaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $empresaId = $this->route('empresa')?->id ?? $this->route('id');
        

        return [
            'nombre' => 'required|string|max:150',
            'nit' => ['nullable','string','max:50', Rule::unique('empresas','nit')->ignore($empresaId)],
            'representante' => 'required|string|max:100',
            'email' => ['required','email','max:100', Rule::unique('empresas','email')->ignore($empresaId)],
            'telefono' => 'nullable|string|max:30',
            'direccion' => 'nullable|string',
            'rubro' => 'nullable|string|max:100',
             'estado' => 'required|in:pendiente,en_revision,aprobada,rechazada,inactivo',
            'tipo_empresa' => 'nullable|in:micro,pequeña,mediana,grande',
            'sector' => 'nullable|string|max:100',
             'fecha_registro' => 'nullable|date',
        ];
    }
}



