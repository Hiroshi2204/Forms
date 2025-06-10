<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;
    protected $table = 'documento';
    protected $fillable = array(
                            'nombre',
                            'numero',
                            'anio',
                            'num_anio',
                            'resumen',
                            'detalle',
                            'fecha_doc',
                            'fecha_envio',
                            'oficina_remitente',
                            'oficina_id',
                            'clase_documento_id',
                            'oficio_id',
                            'pdf_path',
                            'nombre_original_pdf',
                            'estado_registro'
    );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at','updated_at','deleted_at'
    ];
    public function clase_documento()
    {
        return $this->belongsTo(ClaseDocumento::class, 'clase_documento_id', 'id');
    }
    public function oficina()
    {
        return $this->belongsTo(Oficina::class, 'oficina_id', 'id');
    }
    public function oficio()
    {
        return $this->belongsTo(Oficio::class, 'oficio_id', 'id');
    }
}
