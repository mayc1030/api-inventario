<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Modelo User
 *
 * Representa un usuario del sistema que puede autenticarse.
 *
 * Importante:
 * - Extiende Authenticatable para manejar la autenticación nativa de Laravel.
 * - Importa los traits HasApiTokens (para autenticación API con Sanctum),
 * - Protege la asignación masiva con el atributo $fillable.
 * - Oculta campos sensibles al serializar con $hidden.
 * - Realiza casting automático de atributos (como fecha y password).
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Atributos que se pueden asignar masivamente.
     *
     * Evita asignación masiva no autorizada de campos sensibles.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Atributos ocultos al serializar el modelo (por ejemplo, en JSON).
     * Protege datos sensibles como la contraseña y el token de sesión.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting automático de atributos a tipos específicos.
     * Aquí:
     * - 'email_verified_at' es convertido a instancia de DateTime.
     * - 'password' es automáticamente hasheado al asignarlo.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
