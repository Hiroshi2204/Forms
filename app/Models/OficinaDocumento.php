<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OficinaDocumento extends Model
{
    use HasFactory;
    protected $table = 'oficina_documento';
    protected $fillable = array(
                            'oficina_id',
                            'clase_documento_id'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function oficina(){
        return $this->belongsTo(Oficina::class,'oficina_id','id');
    }
    public function clase_documento(){
        return $this->belongsTo(ClaseDocumento::class,'clase_documento_id','id');
    }
}
