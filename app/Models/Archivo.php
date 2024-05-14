<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Empresa;


class Archivo extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo',
        'txt',
        'contenido',
        'empresa_id',
    ];

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }
    
    public function etiquetas()
    {
        return $this->belongsToMany(Tag::class, 'archivostags', 'archivo_id', 'tag_id');
    }


}
