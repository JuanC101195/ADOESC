<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Reserva que asocia un evento con un servicio contratado.
 */
class Reserva extends Model
{
    protected $table = 'reserva';
    protected $primaryKey = 'id_reserva';
    public $timestamps = false;

    protected $fillable = [
        'id_evento',
        'id_servicio',
        'fecha_reserva',
        'estado',
    ];

    protected $casts = [
        'fecha_reserva' => 'date',
    ];

    /** Estados permitidos por el enum de la columna `estado`. */
    public const ESTADOS = ['Pendiente', 'Confirmado', 'Cancelado'];

    /**
     * Relación: la reserva pertenece a un evento.
     */
    public function evento(): BelongsTo
    {
        return $this->belongsTo(Evento::class, 'id_evento', 'id_evento');
    }

    /**
     * Relación: la reserva corresponde a un servicio.
     */
    public function servicio(): BelongsTo
    {
        return $this->belongsTo(Servicio::class, 'id_servicio', 'id_servicio');
    }

    /**
     * Relación: una reserva puede tener varios pagos.
     */
    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class, 'id_reserva', 'id_reserva');
    }
}
