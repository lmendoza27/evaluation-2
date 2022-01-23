<?php
  
namespace App;
  
use Illuminate\Database\Eloquent\Model;
   
class Marcacione extends Model
{
    protected $fillable = [
        'fecha', 'asignacion_id', 'entrada', 'salida','created_at', 'updated_at'
    ];
}