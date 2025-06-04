<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaseDocumento extends Model
{
    use HasFactory;
    protected $table = 'clase_documento';
    protected $fillable = array(
                            'nombre',
                            'nomenclatura',
                            'tipo_transparencia_id',
                            'oficina_id'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function tipo_transparencia(){
        return $this->belongsTo(TipoTransparencia::class,'tipo_transparencia_id','id');
    }
    public function oficina(){
        return $this->belongsTo(Oficina::class,'oficina_id','id');
    }
}
