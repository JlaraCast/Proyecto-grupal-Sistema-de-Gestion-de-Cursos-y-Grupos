<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    protected $fillable = ['user_id', 'grupo_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }
}
