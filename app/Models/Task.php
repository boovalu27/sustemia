<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Modelo que representa una "Tarea" en el sistema.
 *
 * Una tarea está asociada a un usuario y a un área, tiene un título,
 * una descripción, una fecha de vencimiento, un estado, y una fecha
 * de completado. Una tarea puede ser completada o estar pendiente.
 *
 * @property int $id
 * @property int $user_id
 * @property int $area_id
 * @property string $title
 * @property string $description
 * @property \Illuminate\Support\Carbon $due_date
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Area $area
 * @property-read \App\Models\User $user
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @method static \Illuminate\Database\Eloquent\Builder|Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Task query()
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereCompletedAt($value)
 * @mixin \Eloquent
 */
class Task extends Model
{
  use HasFactory;

  /**
   * Los atributos que se pueden asignar masivamente.
   *
   * @var array
   */
  protected $fillable = ['user_id', 'area_id', 'title', 'description', 'due_date', 'completed_at', 'status'];

  /**
   * Los atributos que se deben convertir a instancias de Carbon.
   *
   * @var array
   */
  protected $casts = [
    'due_date' => 'datetime', // Convierte el campo due_date a una instancia Carbon
    'completed_at' => 'datetime', // Convierte el campo completed_at a una instancia Carbon
  ];

  /**
   * Obtiene el usuario asociado a esta tarea.
   *
   * Relación inversa de uno a muchos: una tarea pertenece a un usuario.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * Obtiene el área asociada a esta tarea.
   *
   * Relación inversa de uno a muchos: una tarea pertenece a un área.
   *
   * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function area()
  {
    return $this->belongsTo(Area::class);
  }
}
