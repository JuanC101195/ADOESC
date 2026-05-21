<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Reasigna una contraseña conocida y hasheada (bcrypt) a TODOS los usuarios
 * existentes, cuyas contraseñas originales eran de prueba (ej. "hash123").
 *
 * Ejecutar con:  php artisan db:seed --class=ResetPasswordsSeeder
 * Contraseña asignada a todos:  password123
 */
class ResetPasswordsSeeder extends Seeder
{
    public function run(): void
    {
        $claveHasheada = Hash::make('password123');

        // Recorremos cada usuario y actualizamos su columna `contraseña`.
        User::query()->each(function (User $usuario) use ($claveHasheada) {
            $usuario->setAttribute('contraseña', $claveHasheada);
            $usuario->save();
        });

        $this->command->info('Contraseñas reseteadas. Todos los usuarios usan ahora: password123');
    }
}
