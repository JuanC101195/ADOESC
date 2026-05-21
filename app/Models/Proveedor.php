<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Proveedor que ofrece uno o varios servicios.
 */
class Proveedor extends Model
{
    protected $table = 'proveedor';
    protected $primaryKey = 'id_proveedor';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'telefono',
        'categoria',
    ];

    /**
     * Relación: un proveedor ofrece muchos servicios.
     */
    public function servicios(): HasMany
    {
        return $this->hasMany(Servicio::class, 'id_proveedor', 'id_proveedor');
    }
}
