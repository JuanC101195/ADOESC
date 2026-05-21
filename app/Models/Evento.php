<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo de evento social/corporativo. Pertenece a un usuario organizador.
 */
class Evento extends Model
{
    protected $table = 'evento';
    protected $primaryKey = 'id_evento';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'nombre_evento',
        'fecha',
        'lugar',
        'invitados',
    ];

    protected $casts = [
        'fecha' => 'date',
        'invitados' => 'integer',
    ];

    /**
     * Relación: el evento pertenece a un usuario (organizador).
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Relación: un evento tiene muchas reservas de servicios.
     */
    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class, 'id_evento', 'id_evento');
    }
}
