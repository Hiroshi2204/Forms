<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoTransparenciaDetalle extends Model
{
    use HasFactory;
    protected $table = 'tipo_transparencia_detalle';
    protected $fillable = array(
                            'nombre',
                            'tipo_transparencia_id',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function tipo_transparencia(){
        return $this->belongsTo(TipoTransparenciaDetalle::class,'tipo_transparencia_id','id');
    }
}
