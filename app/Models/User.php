<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

/**
 * Modelo de Usuario.
 *
 * Este modelo representa un usuario del sistema. Un usuario tiene un nombre,
 * apellido, correo electrónico y contraseña. Además, los usuarios pueden tener
 * permisos y roles, que están gestionados a través del paquete Spatie/Permission.
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property string $password
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
  use HasFactory, Notifiable, HasRoles;

  /**
   * Los atributos que se pueden asignar masivamente.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'surname',
    'email',
    'password',
  ];

  /**
   * Los atributos que deben ser ocultados para la serialización.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * Los atributos que deben ser convertidos a tipos nativos.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',  // Convierte a una instancia de Carbon
    'password' => 'hashed',  // Encripta la contraseña
  ];

  /**
   * Obtiene los permisos asociados a este usuario.
   *
   * Relación de muchos a muchos: un usuario puede tener varios permisos.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function permissions()
  {
    return $this->belongsToMany(Permission::class, 'model_has_permissions', 'model_id', 'permission_id');
  }
}
