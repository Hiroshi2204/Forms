<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDocDetalle extends Model
{
    use HasFactory;
    protected $table = 'tipo_doc_detalle';
    protected $fillable = array(
                            'nombre',
                            'tipo_doc_id',
                            'estado_registro'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function tipo_doc(){
        return $this->belongsTo(TipoDoc::class,'tipo_doc_id','id');
    }
}
