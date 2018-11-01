<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('lista/becas',						'BecaController@lista');
Route::post('solicitar/beca',					'BecaController@solicitar');
Route::post('crear/beca',						'BecaController@crear');
Route::post('eliminar/beca',					'BecaController@eliminar');
Route::post('finalizar/beca',					'BecaController@finalizar');
Route::post('selecionar/beneficiario',			'BecaController@selecionar');
Route::post('lista/solicitantes',				'BecaController@listaSolicitantes');