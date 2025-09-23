<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasRoles;

    protected $guard_name = 'api'; // especifica el guard para Spatie, sirve para evitar errores de permisos con JWT en el middleware y en los requests

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    
    //indica que el campo email_verified_at es un campo de tipo fecha y hora
    //y que el campo password debe ser hasheado automaticamente
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    //aqui van los metodos de JWTSubject
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    //aqui van las relaciones Eloquent
    //Un usuario puede impartir muchos grupos (si es profesor)
    public function gruposImpartidos()
    {
        return $this->hasMany(Grupo::class, 'profesor_id');
    }

    // Un usuario puede estar en muchos grupos, y un grupo puede tener muchos usuarios.
    //Esa relación se guarda en la tabla intermedia matriculas.
    public function matriculas()
    {
        return $this->belongsToMany(Grupo::class, 'matriculas')
                    ->withTimestamps();
    }


    //un usuario solo puede tener una imagen de perfil
    

}
