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

    public function lista(Request $request)
    {
        try {
            $datos = Beca::where('estado',1)->get();
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

    public function eliminar(Request $request)
    {
        try {
            $datos = Beca::find($request->input('id'));
            $datos->delete();
            $this->codigo       = 200;
            $this->resultado    = true;
            $this->mensaje      = 'Beca eliminada correctamente';
            $this->datos        = $datos;
            \Session::flash('message','Beca eliminada correctamente');
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
            return redirect()->back();
            //return response()->json($respuesta, $this->codigo);
        }
    }

    public function selecionar(Request $request)
    {
        try {
            $solicitantes       = Solicitud::where('id_beca',$request->input('id_beca'))->get();
            $id_beca            = $request->input('id_beca');

            $datos = Beca::find($request->input('id_beca'));
            $datos->ganador = $request->input('id_solicitante');
            $datos->save();
            $this->codigo       = 200;
            $this->resultado    = true;
            $this->mensaje      = 'Beca selecionada correctamente';
            $this->datos        = $datos;
            \Session::flash('message','Beca selecionada correctamente');
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
            //return redirect()->back();
            return view('solicitantes',compact('solicitantes','id_beca'));
            //return response()->json($respuesta, $this->codigo);
        }
    }

    public function finalizar(Request $request)
    {
        try {
            $datos = Beca::find($request->input('id'));
            $datos->estado      = 2;
            $datos->save();
            $this->codigo       = 200;
            $this->resultado    = true;
            $this->mensaje      = 'Beca eliminada correctamente';
            $this->datos        = $datos;
            \Session::flash('message','Beca eliminada correctamente');
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
            return redirect()->back();
            //return response()->json($respuesta, $this->codigo);
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
            $this->mensaje      = 'Beca creada correctamente';
            $this->datos        = $datos;
            \Session::flash('message','Beca creada correctamente');
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
            return redirect()->back();
            //return response()->json($respuesta, $this->codigo);
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
            $beca = Beca::where('id',$datos->id_beca)->first();
            $beca->postulantes = $beca->postulantes + 1;
            $beca->save();
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

    public function listaSolicitantes(Request $request)
    {
        try {
            $solicitantes       = Solicitud::where('id_beca',$request->input('id'))->get();
            $id_beca            = $request->input('id');
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
            //return response()->json($respuesta, $this->codigo);
            return view('solicitantes',compact('solicitantes','id_beca'));
        }
    }

}
