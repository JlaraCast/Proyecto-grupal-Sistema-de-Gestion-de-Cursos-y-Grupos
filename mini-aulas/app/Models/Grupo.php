<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $fillable = [
        'numero_grupo',
        'cupo_maximo',
        'curso_id',
        'profesor_id',
    ];
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function profesor()
    {
        return $this->belongsTo(User::class, 'profesor_id');
    }

    public function estudiantes()
    {
        return $this->belongsToMany(User::class, 'matriculas')
                    ->withTimestamps();
    }

    public function cupoDisponible()
    {
        return $this->cupo_maximo - $this->estudiantes()->count();
    }
}
