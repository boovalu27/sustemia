<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Spatie\Permission\Models\Permission;

/**
 * Modelo que representa un "Role" en la base de datos.
 *
 * Este modelo está relacionado con los usuarios y con los permisos
 * asociados a cada rol. Un rol puede tener múltiples permisos y
 * usuarios asociados.
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Role extends Model
{
  use HasFactory;

  /**
   * Los atributos que se pueden asignar masivamente.
   *
   * @var array
   */
  protected $fillable = ['name'];

  /**
   * Obtiene los permisos asociados a este rol.
   *
   * Relación muchos a muchos: un rol puede tener muchos permisos.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function permissions()
  {
    return $this->belongsToMany(Permission::class, 'role_has_permissions');
  }
}
