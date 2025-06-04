<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDoc extends Model
{
    use HasFactory;
    protected $table = 'tipo_doc';
    protected $fillable = array(
                            'nombre',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
}
