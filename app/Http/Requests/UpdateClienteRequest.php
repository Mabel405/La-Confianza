<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    } 

    
    
    public function rules(): array
    {
    $model = $this->route('cliente') ?? $this->route('proveedor');
    $id = $model?->id;

    return [
        'razon_social' => 'required|max:80',
        'direccion'    => 'required|max:80',
        'documento_id' => 'required|integer|exists:documentos,id',
        'numero_documento' => 'required|max:20|unique:personas,numero_documento,' . $id . ',id',
    ];
}
}