<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formulario extends Model
{
    use HasFactory;
    protected $table = 'transparencia';
    protected $fillable = array(
                            'num_documento',
                            'asunto',
                            'fecha_registro',
                            'fecha_publicacion',
                            'pdf_path',
                            'nombre_original',
                            'contenido_pdf'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
}
