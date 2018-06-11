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

Route::post('/cerrarPartidoGrupo', 'ApiController@cerrarPartidoGrupo')->middleware('auth');

Route::post('/cerrarPartidoPlayoff', 'ApiController@cerrarPartidoPlayoff')->middleware('auth');

Route::post('/cargarResultadoGrupo', 'ApiController@cargarResultadoGrupo')->middleware('auth');

Route::post('/cargarResultadoPlayoff', 'ApiController@cargarResultadoPlayoff')->middleware('auth');
