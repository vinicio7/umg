<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Beca;
use App\Solicitud;
use Exception;
use DB;

class BecaController extends Controller
{
    protected $resultado        = false;
    protected $mensaje      	= 'Ocurrió un problema al procesar su solicitud';
    protected $datos      		= Array();
    protected $codigo  			= 200;

    public function lista(Request $Request)
    {
        try {
            $datos = Beca::where('estado',0)->get();
            $this->codigo  = 200;
            $this->resultado       = true;
            $this->mensaje      = 'Datos consultados correctamente';
            $this->datos        = $datos;
        } catch (Exception $e) {
            $this->codigo  = 200;
            $this->resultado       = false;
            $this->mensaje      = env('APP_DEBUG') ? $e->getmensaje() : $this->mensaje;
        } finally {
            $respuesta = [
                'resultado'    =>  $this->resultado,
                'mensaje'   =>  $this->mensaje,
                'datos'   =>  $this->datos
            ];
            return response()->json($respuesta, $this->codigo);
        }
    }

    public function crear(Request $request)
    {
        try {
            $datos = new Beca;
            $datos->estado			= 1;
			$datos->nombre			= $request->input('nombre');
			$datos->descripcion		= $request->input('descripcion');
			$datos->ubicacion		= $request->input('ubicacion'); 
			$datos->fecha_inicio	= $request->input('fecha_inicio');
			$datos->fecha_fin		= $request->input('fecha_fin');
			$datos->postulantes		= 0;
            $datos->ganador         = 0;
			$datos->save();
            $this->codigo  		= 200;
            $this->resultado    = true;
            $this->mensaje      = 'Datos consultados correctamente';
            $this->datos        = $datos;
        } catch (Exception $e) {
            $this->codigo  = 200;
            $this->resultado       = false;
            $this->mensaje      = env('APP_DEBUG') ? $e->getmensaje() : $this->mensaje;
        } finally {
            $respuesta = [
                'resultado'    =>  $this->resultado,
                'mensaje'   =>  $this->mensaje,
                'datos'   =>  $this->datos
            ];
            return response()->json($respuesta, $this->codigo);
        }
    }

    public function solicitar(Request $request)
    {
        try {
            $datos = new Solicitud;
			$datos->id_beca		     = $request->input('id_beca');
			$datos->nombre		     = $request->input('nombre');
			$datos->identificacion	 = $request->input('identificacion'); 
			$datos->telefono	     = $request->input('telefono');
			$datos->email		     = $request->input('email');
            $datos->nombre_padre     = $request->input('nombre_padre');
            $datos->nombre_madre     = $request->input('nombre_madre');
            $datos->comentario       = $request->input('comentario');
            $datos->fecha_nacimiento = $request->input('fecha_nacimiento');
            $datos->save();
            $this->codigo  		= 200;
            $this->resultado    = true;
            $this->mensaje      = 'Datos consultados correctamente';
            $this->datos        = $datos;
        } catch (Exception $e) {
            $this->codigo  = 200;
            $this->resultado       = false;
            $this->mensaje      = env('APP_DEBUG') ? $e->getmensaje() : $this->mensaje;
        } finally {
            $respuesta = [
                'resultado'    =>  $this->resultado,
                'mensaje'   =>  $this->mensaje,
                'datos'   =>  $this->datos
            ];
            return response()->json($respuesta, $this->codigo);
        }
    }

    public function listaSolicitantes(Request $Request)
    {
        try {
            $datos = Solicitud::where('id_beca',$request->input('id_beca'))->get();
            $this->codigo       = 200;
            $this->resultado    = true;
            $this->mensaje      = 'Datos consultados correctamente';
            $this->datos        = $datos;
        } catch (Exception $e) {
            $this->codigo  = 200;
            $this->resultado       = false;
            $this->mensaje      = env('APP_DEBUG') ? $e->getmensaje() : $this->mensaje;
        } finally {
            $respuesta = [
                'resultado'    =>  $this->resultado,
                'mensaje'   =>  $this->mensaje,
                'datos'   =>  $this->datos
            ];
            return response()->json($respuesta, $this->codigo);
        }
    }

}
