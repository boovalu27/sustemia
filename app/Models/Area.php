<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo que representa una "Area" en la base de datos.
 *
 * Este modelo está relacionado con el modelo "Task", donde una
 * área puede tener muchas tareas asociadas.
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Task> $tasks
 * @property-read int|null $tasks_count
 * @method static \Illuminate\Database\Eloquent\Builder|Area newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Area newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Area query()
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Area extends Model
{
  use HasFactory;

  /**
   * Los atributos que se pueden asignar masivamente.
   *
   * @var array
   */
  protected $fillable = ['name'];

  /**
   * Obtiene las tareas asociadas a esta área.
   *
   * Relación uno a muchos: una área puede tener muchas tareas.
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function tasks()
  {
    return $this->hasMany(Task::class);
  }
}
