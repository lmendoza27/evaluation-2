<?php
  
namespace App;
  
use Illuminate\Database\Eloquent\Model;
   
class Empleado extends Model
{
    protected $fillable = [
        'nombre', 'apellidos', 'dni', 'email', 'fecha_nacimiento','estado','foto', 'created_at', 'updated_at'
    ];
}