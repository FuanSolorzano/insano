<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag',
        'color',
    ];
    
    public function archivos()
    {
        return $this->belongsToMany(Archivo::class, 'archivostags', 'tag_id', 'archivo_id');
    }

   
}
