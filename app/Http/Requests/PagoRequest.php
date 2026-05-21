<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validación para registrar y actualizar pagos.
 */
class PagoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_reserva' => ['required', 'exists:reserva,id_reserva'],
            'monto' => ['required', 'numeric', 'gt:0'],
            'fecha_pago' => ['required', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'id_reserva.required' => 'Debes seleccionar la reserva.',
            'id_reserva.exists' => 'La reserva seleccionada no existe.',
            'monto.required' => 'El monto del pago es obligatorio.',
            'monto.gt' => 'El monto debe ser mayor que 0.',
            'fecha_pago.required' => 'La fecha del pago es obligatoria.',
        ];
    }
}
