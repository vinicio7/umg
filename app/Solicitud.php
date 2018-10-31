<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $table = 'solicitudes';
    protected $fillable = [
    					'id_beca',
						'nombre',
						'identificacion',
						'telefono',
						'email',
						'nombre_padre',
						'nombre_madre',
						'comentario',
						'fecha_nacimiento'
							]; 
}
