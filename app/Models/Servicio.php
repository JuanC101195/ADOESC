<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Servicio ofrecido por un proveedor y clasificado en una categoría.
 */
class Servicio extends Model
{
    protected $table = 'servicio';
    protected $primaryKey = 'id_servicio';
    public $timestamps = false;

    protected $fillable = [
        'id_proveedor',
        'id_categoria',
        'nombre',
        'precio',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
    ];

    /**
     * Relación: el servicio lo ofrece un proveedor.
     */
    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor', 'id_proveedor');
    }

    /**
     * Relación: el servicio pertenece a una categoría.
     */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(CategoriaServicio::class, 'id_categoria', 'id_categoria');
    }

    /**
     * Relación: un servicio puede estar en muchas reservas.
     */
    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class, 'id_servicio', 'id_servicio');
    }
}
