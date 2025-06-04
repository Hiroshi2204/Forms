<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoOficina extends Model
{
    use HasFactory;
    protected $table = 'cargo_oficina';
    protected $fillable = array(
                            'carg_nombre',
                            'responsable',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
}
