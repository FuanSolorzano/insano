<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\Archivo;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'ruc',
        'nombre',
        'ciudad',
        'provincia',
        'direccion',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class); // Una empresa pertenece a un usuario
    }

    public function archivos(): Hasmany
    {
        return $this->hasMany(Archivo::class);
    }
}

