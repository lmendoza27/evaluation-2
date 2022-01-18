<?php
  
namespace App;
  
use Illuminate\Database\Eloquent\Model;
   
class Employee extends Model
{
    protected $fillable = [
        'nombre', 'apellidos', 'dni', 'email', 'fecha_nacimiento', 'cargo', 'area', 'fecha_inicio','fecha_fin','tipo_contacto','estado', 'created_at', 'updated_at'
    ];
}