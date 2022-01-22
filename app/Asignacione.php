<?php
  
namespace App;
  
use Illuminate\Database\Eloquent\Model;
   
class Asignacione extends Model
{
    protected $fillable = [
        'horario_id', 'empleado_id', 'created_at', 'updated_at'
    ];
}