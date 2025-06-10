<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oficina extends Model
{
    use HasFactory;
    protected $table = 'oficina';
    protected $fillable = array(
                            'nombre',
                            'cargo_oficina_id'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function cargo_oficina(){
        return $this->belongsTo(CargoOficina::class,'cargo_oficina_id','id');
    }
}
