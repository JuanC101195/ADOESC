<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Modelo de usuario mapeado a la tabla existente `usuario`.
 *
 * La tabla usa columnas no estándar (id_usuario, email, contraseña),
 * por eso se sobrescriben primaryKey y el método getAuthPassword().
 */
class User extends Authenticatable
{
    use Notifiable;

    /** Tabla real en la BD adoesce_bd. */
    protected $table = 'usuario';

    /** Clave primaria personalizada. */
    protected $primaryKey = 'id_usuario';

    /** La tabla no tiene columnas created_at / updated_at. */
    public $timestamps = false;

    /** Atributos asignables masivamente. */
    protected $fillable = [
        'id_rol',
        'nombre',
        'email',
        'telefono',
        'contraseña',
    ];

    /** Atributos ocultos al serializar (nunca exponer la contraseña). */
    protected $hidden = [
        'contraseña',
    ];

    /**
     * Indica a Laravel cuál columna contiene la contraseña hasheada.
     * Sin esto, Auth::attempt buscaría una columna `password` inexistente.
     */
    public function getAuthPassword(): string
    {
        return $this->attributes['contraseña'] ?? '';
    }

    /**
     * Relación: un usuario pertenece a un rol.
     */
    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class, 'id_rol', 'id_rol');
    }

    /**
     * Relación: un usuario (organizador) tiene muchos eventos.
     */
    public function eventos(): HasMany
    {
        return $this->hasMany(Evento::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Verifica si el usuario tiene un rol por nombre (sin distinguir mayúsculas).
     */
    public function tieneRol(string $nombreRol): bool
    {
        return $this->rol && strcasecmp($this->rol->nombre, $nombreRol) === 0;
    }

    /** Atajo: ¿es Administrador? */
    public function esAdministrador(): bool
    {
        return $this->tieneRol('Administrador');
    }

    /** Atajo: ¿es Organizador? */
    public function esOrganizador(): bool
    {
        return $this->tieneRol('Organizador');
    }

    /** Atajo: ¿es Invitado? */
    public function esInvitado(): bool
    {
        return $this->tieneRol('Invitado');
    }
}
