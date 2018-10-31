<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beca extends Model
{
    protected $table = 'becas';
    protected $fillable = [
    					'estado',
						'nombre',
						'descripcion',
						'ubicacion',
						'fecha_inicio',
						'fecha_fin',
						'postulantes',
						'ganador'
							]; 
}
