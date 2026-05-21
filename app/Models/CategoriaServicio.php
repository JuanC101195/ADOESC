<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Categoría a la que pertenece un servicio (ej. Catering, Música, Decoración).
 */
class CategoriaServicio extends Model
{
    protected $table = 'categoria_servicio';
    protected $primaryKey = 'id_categoria';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
    ];

    /**
     * Relación: una categoría agrupa muchos servicios.
     */
    public function servicios(): HasMany
    {
        return $this->hasMany(Servicio::class, 'id_categoria', 'id_categoria');
    }
}
