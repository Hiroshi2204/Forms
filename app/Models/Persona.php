<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Persona extends Model
{
    protected $table = 'persona';
    protected $fillable = array(
                            'numero_documento',
                            'tipo_documento_id',
                            'nombres',
                            'apellido_paterno',
                            'apellido_materno',
                            'celular',
                            'correo',
                            'direccion'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
}
