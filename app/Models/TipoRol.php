<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoRol extends Model
{
    use HasFactory;
    protected $table = 'tipo_rol';
    protected $fillable = array(
                            'rol_id',
                            'descripcion',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function rol(){
        return $this->belongsTo(Rol::class,'rol_id','id');
    }
}
