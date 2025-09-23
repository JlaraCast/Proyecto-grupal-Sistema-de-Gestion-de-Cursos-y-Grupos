<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grupo extends Model
{
    use HasFactory;

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

    public function ObtenerDatosGrupo()
    {
        return [
            'id' => $this->id,
            'numero_grupo' => $this->numero_grupo,
            'cupo_maximo' => $this->cupo_maximo,
            'cupo_disponible' => $this->cupoDisponible(),
            'curso' => $this->curso ? $this->curso->ObtenerDatosCurso() : null,
            'profesor' => $this->profesor ? [
                'id' => $this->profesor->id,
                'name' => $this->profesor->name,
                'email' => $this->profesor->email,
            ] : null,
            'estudiantes' => $this->estudiantes->map(function ($estudiante) {
                return [
                    'id' => $estudiante->id,
                    'name' => $estudiante->name,
                    'email' => $estudiante->email,
                ];
            }),
        ];
    }
}
