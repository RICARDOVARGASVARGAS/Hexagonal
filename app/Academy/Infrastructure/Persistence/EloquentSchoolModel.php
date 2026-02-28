<?php

declare(strict_types=1);

namespace App\Academy\Infrastructure\Persistence;

use Database\Factories\SchoolFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Modelo Eloquent: SOLO representa la tabla schools en DB
// No tiene reglas de negocio, eso vive en la Entity
class EloquentSchoolModel extends Model
{
    use HasFactory;

    // Conexión al schema academy (definido en database.php)
    protected $connection = 'academy';

    // Nombre de la tabla
    protected $table = 'schools';

    // UUID generado por la aplicación, no por Eloquent ni PostgreSQL
    protected $keyType   = 'string';
    public $incrementing = false;

    // Columnas permitidas para llenado masivo
    protected $fillable = [
        'id',
        'name',
        'status',
    ];

    protected static function newFactory(): SchoolFactory
    {
        return SchoolFactory::new();
    }
}
