<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oficio extends Model
{
    use HasFactory;
    protected $table = 'oficio';
    protected $fillable = array(
                            'numero',
                            'oficina_remitente',
                            'codigo',
                            //'fecha_ofi',
                            'fecha_envio',
                            'pdf_path',
                            'nombre_original_pdf',
                            'estado_publicacion',
                            'fecha_publicacion',
                            'estado_registro'
    );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];

    public function documentos()
    {
        return $this->hasMany(Documento::class, 'oficio_id');
    }
}
