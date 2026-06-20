<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
 
    public function rules(): array
    {
        return [
            'razon_social'      => 'required|max:80',
            'direccion'         => 'required|max:80',
            'tipo_persona'      => 'required|string',
            'documento_id'      => 'required|integer|exists:documentos,id',
            'numero_documento'  => 'required|max:20|unique:personas,numero_documento',
        ];
    }

     
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
     
            $documento = $this->documento_id;
            $value = $this->numero_documento;
    
            if (!$documento || !$value) {
                return;
            }
    
            // DNI (8 dígitos numéricos)
            if ($documento == 1) {
                if (strlen($value) != 8) {
                    $validator->errors()->add('numero_documento', 'El DNI debe tener 8 dígitos.');
                }
                if (!ctype_digit($value)) {
                    $validator->errors()->add('numero_documento', 'El DNI solo debe contener números.');
                }
            }
     
            // Pasaporte (7 caracteres alfanuméricos)
            if ($documento == 2) {
                if (strlen($value) != 7) {
                    $validator->errors()->add('numero_documento', 'El pasaporte debe tener 7 caracteres.');
                }
                if (!ctype_alnum($value)) {
                    $validator->errors()->add('numero_documento', 'El pasaporte solo puede contener letras y números.');
                }
            }
    
            // RUC (11 dígitos numéricos)
            if ($documento == 3) {
                if (strlen($value) != 11) {
                    $validator->errors()->add('numero_documento', 'El RUC debe tener 11 dígitos.');
                }
                if (!ctype_digit($value)) {
                    $validator->errors()->add('numero_documento', 'El RUC solo debe contener números.');
                }
            }
    
            // Carnet de extranjería (12 dígitos numéricos)
            if ($documento == 4) {
                if (strlen($value) != 12) {
                    $validator->errors()->add('numero_documento', 'El carnet de extranjería debe tener 12 dígitos.');
                }
                if (!ctype_digit($value)) {
                    $validator->errors()->add('numero_documento', 'El carnet de extranjería solo debe contener números.');
                }
            }
        });
    }
    
}
