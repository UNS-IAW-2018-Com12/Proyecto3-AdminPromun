<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Mongodb\Model as Eloquent;
use App\Models\Equipo;
use App\Models\Partido;
use App\Models\Grupo;
use App\Models\Participante;
use App\Models\Playoff;
use App\Models\ResultadoGrupo;

class ApiController extends Controller {

  public static function cerrarPartidoGrupo(Request $request) {

      $idGrupo = $request->idGrupo;
      $idPartido = $request->idPartido;

      $partidoSeleccionado = Grupo::find($idGrupo)->partidos->where('_id', '=', $idPartido)->first();
      $partidoSeleccionado->cerrado = true;
      $partidoSeleccionado->save();
  }

  public function cerrarPartidoPlayoff(Request $idPartido) {

      $partidoSeleccionado = Playoff::find($idPartido)->first();
      $partidoSeleccionado->cerrado = true;
      $partidoSeleccionado->save();
  }

  public function cargarResultadoGrupo(Request $request) {

      //Actualiza el partido jugado
      self::actualizarPartidoGrupo($request);

      //Actualiza las tablas de posiciones de los equipos
      self::actualizarTablas($request);

      //Actualia los goles a favor, en contra y diferencia de goles de cada equipo
      self::actualizarGoles($request);

      //Actualiza el torneo, esto es, verifica si algun equipo paso a octavos de final
      self::actualizarOctavos($request);

      //Actualiza el puntaje (estrellas) de los usuarios que hayan pronosticado acerca del partido
      self::actualizarPuntajesDeUsuariosPartidoGrupos($request);
  }

  public function cargarResultadoPlayoff(Request $request) {

      //Actualiza el partido jugados
      //self::actualizarPartidoPlayoff($request);

      //Asigna el equipo ganador a la fase correspondiente
      //self::actualizarFasePlayoff($request);

      //Actualiza el puntaje (estrellas) de los usuarios que hayan pronosticado acerca del partido
      self::actualizarPuntajesDeUsuariosPartidoPlayoff($request);
  }

  protected function actualizarPuntajesDeUsuariosPartidoPlayoff($request) {

    $equipo1 = $request->equipo1;
    $equipo2 = $request->equipo2;
    (int) $golesEquipo1 = $request->golesEquipo1;
    (int) $golesEquipo2 = $request->golesEquipo2;
    $partidoSeleccionado = Playoff::where("equipo1", '=', $equipo1)->where("equipo2", '=', $equipo2)->first();

    //Obtiene los pronosticos del partido
    $pronosticos = $partidoSeleccionado->pronosticos;

    //Asigna los puntos correspondientes a cada participante
    foreach($pronosticos as $pronostico) {

        //$userPronostico = $pronostico->user;
        $userPronostico = $pronostico['user'];
        $user = Participante::where("username", '=', $userPronostico)->first();
        $golesPronosticoEquipo1 = $pronostico['golesEquipo1'];
        $golesPronosticoEquipo2 = $pronostico['golesEquipo2'];

        if(($golesEquipo1 == $golesPronosticoEquipo1) and ($golesEquipo2 == $golesPronosticoEquipo2)) {

            //Acerto el pronostico en su totalidad
            $puntajeActual = $user->puntaje;
            $puntajeActual += 5;
            $user->puntaje = $puntajeActual;
            $user->save();

        }
        else {

            if((($golesEquipo1 == $golesEquipo2) and ($golesPronosticoEquipo1 == $golesPronosticoEquipo2)) and (($golesEquipo1 !=  $golesPronosticoEquipo1))) {

              //Acerto en que fue un empate pero no acerto los goles
              $puntajeActual = $user->puntaje;
              $puntajeActual += 4;
              $user->puntaje = $puntajeActual;
              $user->save();

            }
            else {

              if((($golesEquipo1 > $golesEquipo2) and ($golesPronosticoEquipo1 > $golesPronosticoEquipo2)) or (($golesEquipo1 < $golesEquipo2) and ($golesPronosticoEquipo1 < $golesPronosticoEquipo2))) {

                  //Acerto sobre el resultado global
                  if((($golesEquipo1 == $golesPronosticoEquipo1) and ($golesEquipo2 != $golesPronosticoEquipo2)) or (($golesEquipo1 != $golesPronosticoEquipo1) and ($golesEquipo2 == $golesPronosticoEquipo2))) {

                      //Acerto sobre el resultado global, pero no acerto sobre los goles de uno de los equipos
                      $puntajeActual = $user->puntaje;
                      $puntajeActual += 4;
                      $user->puntaje = $puntajeActual;
                      $user->save();

                  }
                  else {

                      //Acerto sobre el resultado global, aunque no acerto en los goles de ninguno de los dos equipos
                      $puntajeActual = $user->puntaje;
                      $puntajeActual += 3;
                      $user->puntaje = $puntajeActual;
                      $user->save();

                }
              }
              else {

                  if((($golesEquipo1 == $golesPronosticoEquipo1) and ($golesEquipo2 != $golesPronosticoEquipo2)) or (($golesEquipo1 != $golesPronosticoEquipo1) and ($golesEquipo2 == $golesPronosticoEquipo2))) {

                      //Acerto solo en los goles de uno de los dos equipos
                      $puntajeActual = $user->puntaje;
                      $puntajeActual += 2;
                      $user->puntaje = $puntajeActual;
                      $user->save();
                  }
                  else {

                      //No acerto en nada de lo pronosticado
                      $puntajeActual = $user->puntaje;
                      $puntajeActual += 1;
                      $user->puntaje = $puntajeActual;
                      $user->save();

                  }
              }
            }
        }
    }
  }

  protected function actualizarPuntajesDeUsuariosPartidoGrupos(Request $request) {

    $idGrupo = $request->idGrupo;
    $idPartido = $request->idPartido;
    (int) $golesEquipo1 = $request->golesEquipo1;
    (int) $golesEquipo2 = $request->golesEquipo2;
    $partidoSeleccionado = Grupo::find($idGrupo)->partidos->where('_id', '=', $idPartido)->first();

    //Obtiene los pronosticos del partido
    $pronosticos = $partidoSeleccionado->pronosticos;

    //Asigna los puntos correspondientes a cada participante
    foreach($pronosticos as $pronostico) {

        //$userPronostico = $pronostico->user;
        $userPronostico = $pronostico->user;
        $user = Participante::where("username", '=', $userPronostico)->first();
        $golesPronosticoEquipo1 = $pronostico->golesEquipo1;
        $golesPronosticoEquipo2 = $pronostico->golesEquipo2;

        if(($golesEquipo1 == $golesPronosticoEquipo1) and ($golesEquipo2 == $golesPronosticoEquipo2)) {

            //Acerto el pronostico en su totalidad
            $puntajeActual = $user->puntaje;
            $puntajeActual += 5;
            $user->puntaje = $puntajeActual;
            $user->save();

        }
        else {

            if((($golesEquipo1 == $golesEquipo2) and ($golesPronosticoEquipo1 == $golesPronosticoEquipo2)) and (($golesEquipo1 !=  $golesPronosticoEquipo1))) {

                //Acerto en que fue un empate pero no acerto los goles
                $puntajeActual = $user->puntaje;
                $puntajeActual += 4;
                $user->puntaje = $puntajeActual;
                $user->save();

            }
            else {

                if((($golesEquipo1 > $golesEquipo2) and ($golesPronosticoEquipo1 > $golesPronosticoEquipo2)) or (($golesEquipo1 < $golesEquipo2) and ($golesPronosticoEquipo1 < $golesPronosticoEquipo2))) {

                    //Acerto sobre el resultado global
                    if((($golesEquipo1 == $golesPronosticoEquipo1) and ($golesEquipo2 != $golesPronosticoEquipo2)) or (($golesEquipo1 != $golesPronosticoEquipo1) and ($golesEquipo2 == $golesPronosticoEquipo2))) {

                        //Acerto sobre el resultado global, pero no acerto sobre los goles de uno de los equipos
                        $puntajeActual = $user->puntaje;
                        $puntajeActual += 4;
                        $user->puntaje = $puntajeActual;
                        $user->save();

                    }
                    else {

                        //Acerto sobre el resultado global, aunque no acerto en los goles de ninguno de los dos equipos
                        $puntajeActual = $user->puntaje;
                        $puntajeActual += 3;
                        $user->puntaje = $puntajeActual;
                        $user->save();

                    }
                }
                else {

                    if((($golesEquipo1 == $golesPronosticoEquipo1) and ($golesEquipo2 != $golesPronosticoEquipo2)) or (($golesEquipo1 != $golesPronosticoEquipo1) and ($golesEquipo2 == $golesPronosticoEquipo2))) {

                        //Acerto solo en los goles de uno de los dos equipos
                        $puntajeActual = $user->puntaje;
                        $puntajeActual += 2;
                        $user->puntaje = $puntajeActual;
                        $user->save();
                    }
                    else {

                        //No acerto en nada de lo pronosticado
                        $puntajeActual = $user->puntaje;
                        $puntajeActual += 1;
                        $user->puntaje = $puntajeActual;
                        $user->save();

                    }
                }
          }
      }
    }
  }

  protected function actualizarPartidoPlayoff(Request $request) {

      $equipo1 = $request->equipo1;
      $equipo2 = $request->equipo2;
      (int) $golesEquipo1 = $request->golesEquipo1;
      (int) $golesEquipo2 = $request->golesEquipo2;

      //Setea los goles del partido que se jugo
      $partidoSeleccionado = Playoff::where("equipo1", '=', $equipo1)->where("equipo2", '=', $equipo2)->first();
      $partidoSeleccionado->golesEquipo1 = (int) $golesEquipo1;
      $partidoSeleccionado->golesEquipo2 = (int) $golesEquipo2;
      $partidoSeleccionado->jugado = true;
      $partidoSeleccionado->save();

      return $partidoSeleccionado;
  }

  protected function actualizarFasePlayoff(Request $request) {

    //Obtiene el equipo ganador
    $equipo1 = $request->equipo1;
    $equipo2 = $request->equipo2;
    (int) $golesEquipo1 = $request->golesEquipo1;
    (int) $golesEquipo2 = $request->golesEquipo2;
    $partidoIngresado = Playoff::where("equipo1", '=', $equipo1)->where("equipo2", '=', $equipo2)->first();
    $equipoGanador = "";
    if($golesEquipo1 > $golesEquipo2){
        $equipoGanador = $partidoIngresado->equipo1;
    }
    else {
        $equipoGanador = $partidoIngresado->equipo2;
    }

    //Obtiene la fase actual del equipo ganador y lo asigna a la etapa correspondiente
    $faseEquipoGanador = $partidoIngresado->fase;
    $nroEquipoIngresado = $partidoIngresado->nro_partido;

    //Lo asigna a la fase correspondiente
    switch ($faseEquipoGanador) {
        case "octavos": {
          self::actualizarCuartos($nroEquipoIngresado, $equipoGanador);
          break;
        }
        case "cuartos": {
          self::actualizarSemis($nroEquipoIngresado, $equipoGanador);
          break;
        }
        case "semis": {
          self::actualizarFinal($nroEquipoIngresado, $equipoGanador);
          break;
        }
        case "final": {

          break;
      }
    }
  }

  protected function actualizarCuartos($nroEquipoIngresado, $equipoGanador) {

    switch ($nroEquipoIngresado) {
        case 49 : {
            $cuartosNro57 = Playoff::where("nro_partido", '=', 57)->first();
            $cuartosNro57->equipo1 = $equipoGanador;
            if($cuartosNro57->equipo2 != 'G50')
                $cuartosNro57->creado = true;
            $cuartosNro57->save();

            break;
        }
        case 50 : {
            $cuartosNro57 = Playoff::where("nro_partido", '=', 57)->first();
            $cuartosNro57->equipo2 = $equipoGanador;
            if($cuartosNro57->equipo1 != 'G49')
                $cuartosNro57->creado = true;
            $cuartosNro57->save();

            break;
        }
        case 51 : {
            $cuartosNro59 = Playoff::where("nro_partido", '=', 59)->first();
            $cuartosNro59->equipo1 = $equipoGanador;
            if($cuartosNro59->equipo2 != 'G52')
                $cuartosNro59->creado = true;
            $cuartosNro59->save();

            break;
        }
        case 52 : {
            $cuartosNro59 = Playoff::where("nro_partido", '=', 59)->first();
            $cuartosNro59->equipo2 = $equipoGanador;
            if($cuartosNro59->equipo1 != 'G51')
                $cuartosNro59->creado = true;
            $cuartosNro59->save();

            break;
        }
        case 53 : {
            $cuartosNro58 = Playoff::where("nro_partido", '=', 58)->first();
            $cuartosNro58->equipo1 = $equipoGanador;
            if($cuartosNro58->equipo2 != 'G54')
                $cuartosNro58->creado = true;
            $cuartosNro58->save();

            break;
        }
        case 54 : {
            $cuartosNro58 = Playoff::where("nro_partido", '=', 58)->first();
            $cuartosNro58->equipo2 = $equipoGanador;
            if($cuartosNro58->equipo1 != 'G53')
                $cuartosNro58->creado = true;
            $cuartosNro58->save();

            break;
        }
        case 55 : {
            $cuartosNro60 = Playoff::where("nro_partido", '=', 60)->first();
            $cuartosNro60->equipo1 = $equipoGanador;
            if($cuartosNro60->equipo2 != 'G56')
                $cuartosNro60->creado = true;
            $cuartosNro60->save();

            break;
        }
        case 56 : {
            $cuartosNro60 = Playoff::where("nro_partido", '=', 60)->first();
            $cuartosNro60->equipo2 = $equipoGanador;
            if($cuartosNro60->equipo1 != 'G55')
                $cuartosNro60->creado = true;
            $cuartosNro60->save();

            break;
        }
    }
  }

  protected function actualizarSemis($nroEquipoIngresado, $equipoGanador) {

    switch ($nroEquipoIngresado) {
        case 57 : {
            $semisNro61 = Playoff::where("nro_partido", '=', 61)->first();
            $semisNro61->equipo1 = $equipoGanador;
            if($semisNro61->equipo2 != 'G58')
                $semisNro61->creado = true;
            $semisNro61->save();

            break;
        }
        case 58 : {
            $semisNro61 = Playoff::where("nro_partido", '=', 61)->first();
            $semisNro61->equipo2 = $equipoGanador;
            if($semisNro61->equipo1 != 'G57')
                $semisNro61->creado = true;
            $semisNro61->save();

            break;
        }
        case 59 : {
            $semisNro62 = Playoff::where("nro_partido", '=', 62)->first();
            $semisNro62->equipo1 = $equipoGanador;
            if($semisNro62->equipo2 != 'G60')
                $semisNro62->creado = true;
            $semisNro62->save();

            break;
        }
        case 60 : {
            $semisNro62 = Playoff::where("nro_partido", '=', 62)->first();
            $semisNro62->equipo2 = $equipoGanador;
            if($semisNro62->equipo1 != 'G59')
                $semisNro62->creado = true;
            $semisNro62->save();

            break;
        }
    }
  }

  protected function actualizarFinal($nroEquipoIngresado, $equipoGanador) {

      switch ($nroEquipoIngresado) {
          case 61 : {
              $final = Playoff::where("nro_partido", '=', 63)->first();
              $final->equipo1 = $equipoGanador;
              if($final->equipo2 != 'G62')
                  $final->creado = true;
              $final->save();

              break;
          }
          case 62 : {
              $final = Playoff::where("nro_partido", '=', 63)->first();
              $final->equipo2 = $equipoGanador;
              if($final->equipo1 != 'G61')
                  $final->creado = true;
              $final->save();

              break;
          }
     }
  }

  protected function actualizarPartidoGrupo(Request $request) {

      $idGrupo = $request->idGrupo;
      $idPartido = $request->idPartido;

      (int) $golesEquipo1 = $request->golesEquipo1;
      (int) $golesEquipo2 = $request->golesEquipo2;

      //Setea los goles del partido que se jugo
      $partidoSeleccionado = Grupo::find($idGrupo)->partidos->where('_id', '=', $idPartido)->first();
      $partidoSeleccionado->golesEquipo1 = (int) $golesEquipo1;
      $partidoSeleccionado->golesEquipo2 = (int) $golesEquipo2;
      $partidoSeleccionado->jugado = true;
      $partidoSeleccionado->save();
  }

  protected function actualizarTablas(Request $request) {

      $idGrupo = $request->idGrupo;
      $idPartido = $request->idPartido;

      //Obtiene los equipos
      $partidoSeleccionado = Grupo::find($idGrupo)->partidos->where('_id', '=', $idPartido)->first();

      $nombreEquipo1 = $partidoSeleccionado->equipo1;
      $equipo1 = Grupo::find($idGrupo)->equipos->where('nombre', '=', $nombreEquipo1)->first();

      $nombreEquipo2 = $partidoSeleccionado->equipo2;
      $equipo2 = Grupo::find($idGrupo)->equipos->where('nombre', '=', $nombreEquipo2)->first();

      //Actualiza los partidos jugados, ganados, perdidos y empatados y puntajes de cada uno
      (int) $golesEquipo1 = $request->golesEquipo1;
      (int) $golesEquipo2 = $request->golesEquipo2;

      $resultados_grupoEquipo1 = $equipo1->resultados_grupo;
      $resultados_grupoEquipo2 = $equipo2->resultados_grupo;

      if( $golesEquipo1 > $golesEquipo2 ) { //Gano el equipo1

          //Actualiza el equipo1
          $puntosEquipo1 = $resultados_grupoEquipo1['puntos'] += 3;
          $pjEquipo1 = $resultados_grupoEquipo1['pj'] += 1;
          $pgEquipo1 = $resultados_grupoEquipo1['pg'] += 1;
          $resultados_equipo1 = ['puntos' => $puntosEquipo1, 'pj' => $pjEquipo1, 'pg' => $pgEquipo1];
          $equipo1->resultados_grupo = array_merge($equipo1->resultados_grupo, $resultados_equipo1);

          //Actualiza el equipo2
          $pjEquipo2 = $resultados_grupoEquipo2['pj'] += 1;
          $ppEquipo2 = $resultados_grupoEquipo2['pp'] += 1;
          $resultados_equipo2 = ['pj' => $pjEquipo2, 'pp' => $ppEquipo2];
          $equipo2->resultados_grupo = array_merge($equipo2->resultados_grupo, $resultados_equipo2);

          //Actualiza la base de datos
          $equipo1->save();
          $equipo2->save();
      }
      else {
        if( $golesEquipo1 < $golesEquipo2 )  { //Gano el equipo2

            //Actualiza el equipo1
            $pjEquipo1 = $resultados_grupoEquipo1['pj'] += 1;
            $ppEquipo1 = $resultados_grupoEquipo1['pp'] += 1;
            $resultados_equipo1 = ['pj' => $pjEquipo1, 'pp' => $ppEquipo1];
            $equipo1->resultados_grupo = array_merge($equipo1->resultados_grupo, $resultados_equipo1);

            //Actualiza el equipo2
            $puntosEquipo2 = $resultados_grupoEquipo2['puntos'] += 3;
            $pjEquipo2 = $resultados_grupoEquipo2['pj'] += 1;
            $pgEquipo2 = $resultados_grupoEquipo2['pg'] += 1;
            $resultados_equipo2 = ['puntos' => $puntosEquipo2, 'pj' => $pjEquipo2, 'pg' => $pgEquipo2];
            $equipo2->resultados_grupo = array_merge($equipo2->resultados_grupo, $resultados_equipo2);

            //Actualiza la base de datos
            $equipo1->save();
            $equipo2->save();
        }
        else { //Hubo un empate

              //Actualiza el equipo1
              $puntosEquipo1 = $resultados_grupoEquipo1['puntos'] += 1;
              $pjEquipo1 = $resultados_grupoEquipo1['pj'] += 1;
              $peEquipo1 = $resultados_grupoEquipo1['pe'] += 1;
              $resultados_equipo1 = ['puntos' => $puntosEquipo1, 'pj' => $pjEquipo1, 'pe' => $peEquipo1];
              $equipo1->resultados_grupo = array_merge($equipo1->resultados_grupo, $resultados_equipo1);

              //Actualiza el equipo2
              $puntosEquipo2 = $resultados_grupoEquipo2['puntos'] += 1;
              $pjEquipo2 = $resultados_grupoEquipo2['pj'] += 1;
              $peEquipo2 = $resultados_grupoEquipo2['pe'] += 1;
              $resultados_equipo2 = ['puntos' => $puntosEquipo2, 'pj' => $pjEquipo2, 'pe' => $peEquipo2];
              $equipo2->resultados_grupo = array_merge($equipo2->resultados_grupo, $resultados_equipo2);

              //Actualiza la base de datos
              $equipo1->save();
              $equipo2->save();
        }
      }
    }

    protected function actualizarGoles(Request $request) {

        $idGrupo = $request->idGrupo;
        $idPartido = $request->idPartido;

        //Obtiene los equipos
        $partidoSeleccionado = Grupo::find($idGrupo)->partidos->where('_id', '=', $idPartido)->first();
        $nombreEquipo1 = $partidoSeleccionado->equipo1;
        $equipo1 = Grupo::find($idGrupo)->equipos->where('nombre', '=', $nombreEquipo1)->first();

        $nombreEquipo2 = $partidoSeleccionado->equipo2;
        $equipo2 = Grupo::find($idGrupo)->equipos->where('nombre', '=', $nombreEquipo2)->first();

        $resultados_grupoEquipo1 = $equipo1->resultados_grupo;
        $resultados_grupoEquipo2 = $equipo2->resultados_grupo;

        //Obtiene los goles
        (int) $golesEquipo1 = $request->golesEquipo1;
        (int) $golesEquipo2 = $request->golesEquipo2;

        //Actualiza el equipo1
        $gfEquipo1 = $resultados_grupoEquipo1['gf'] += $golesEquipo1;
        $gcEquipo1 = $resultados_grupoEquipo1['gc'] += $golesEquipo2;
        $difEquipo1 = $resultados_grupoEquipo1['dif'] += ($golesEquipo1 - $golesEquipo2);
        $balanceGolesEquipo1 = ['gf' => $gfEquipo1, 'gc' => $gcEquipo1, 'dif' => $difEquipo1];
        $equipo1->resultados_grupo = array_merge($equipo1->resultados_grupo, $balanceGolesEquipo1);

        //Actualiza el equipo2
        $gfEquipo2 = $resultados_grupoEquipo2['gf'] += $golesEquipo2;
        $gcEquipo2 = $resultados_grupoEquipo2['gc'] += $golesEquipo1;
        $difEquipo2 = $resultados_grupoEquipo2['dif'] += ($golesEquipo2 - $golesEquipo1);
        $balanceGolesEquipo2 = ['gf' => $gfEquipo2, 'gc' => $gcEquipo2, 'dif' => $difEquipo2];
        $equipo2->resultados_grupo = array_merge($equipo2->resultados_grupo, $balanceGolesEquipo2);

        //Actualiza la base de datos
        $equipo1->save();
        $equipo2->save();
  }

  protected function actualizarOctavos(Request $request) {

      $idGrupo = $request->idGrupo;

      //Busca si quedan partidos sin jugar
      $cantPartidosSinJugar = Grupo::find($idGrupo)->partidos->where('jugado', '=', false)->count();

      if($cantPartidosSinJugar == 0) {
        $equipos = Grupo::find($idGrupo)->equipos;

        $nombrePrimerEquipo;
        $nombreSegundoEquipo;

        //Busca el primero en puntos
        $primerPuntaje = -1;
        foreach($equipos as $equipo) {
          $puntajeEquipoActual = $equipo->resultados_grupo['puntos'];
          if($puntajeEquipoActual > $primerPuntaje) {
              $primerPuntaje = $puntajeEquipoActual;
              $nombrePrimerEquipo = $equipo->nombre;
          }
        }

        //Busca el segundo en puntos
        $segundoPuntaje = -1;
        foreach($equipos as $equipo) {
          $puntajeEquipoActual = $equipo->resultados_grupo['puntos'];
          if( ($puntajeEquipoActual > $segundoPuntaje) & ($nombrePrimerEquipo != $equipo->nombre) ) {
              $segundoPuntaje = $puntajeEquipoActual;
              $nombreSegundoEquipo = $equipo->nombre;
          }
        }

        //Si hay un tercero con los mismos puntos que el segundo
        $segundoEquipo = $equipos->where('nombre', '=', $nombreSegundoEquipo)->first();
        $difGolesSegundoEquipo = $segundoEquipo->resultados_grupo['dif'];
        $tercerPuntaje = -1;
        foreach($equipos as $equipo) {
          $puntajeEquipoActual = $equipo->resultados_grupo['puntos'];
          if( ($puntajeEquipoActual == $segundoPuntaje) & ($nombreSegundoEquipo != $equipo->nombre) ) {
              $difGolesTercerEquipo = $equipo->resultados_grupo['dif'];
              //se define por diferencia de goles
              if( $difGolesTercerEquipo > $difGolesSegundoEquipo ) {
                  $nombreSegundoEquipo = $equipo->nombre;
              }
          }
        }

        //Asigna los equipos ganadores del grupo a los partidos de octavos que le corresponden a cada uno
        $letraGrupo = Grupo::find($idGrupo)->letra;
        switch ($letraGrupo) {
            case "A": {
                $octavosNro49 = Playoff::where("nro_partido", '=', 49)->first();
                $octavosNro49->equipo1 = $nombrePrimerEquipo;
                if($octavosNro49->equipo2 != '2B')
                    $octavosNro49->creado = true;
                $octavosNro49->save();


                $octavosNro51 = Playoff::where("nro_partido", '=', 51)->first();
                $octavosNro51->equipo1 = $nombreSegundoEquipo;
                if($octavosNro51->equipo2 != '1B')
                    $octavosNro51->creado = true;
                $octavosNro51->save();

                break;
            }
            case "B": {
                $octavosNro51 = Playoff::where("nro_partido", '=', 51)->first();
                $octavosNro51->equipo2 = $nombrePrimerEquipo;
                if($octavosNro51->equipo1 != '2A')
                    $octavosNro51->creado = true;
                $octavosNro51->save();

                $octavosNro49 = Playoff::where("nro_partido", '=', 49)->first();
                $octavosNro49->equipo2 = $nombreSegundoEquipo;
                if($octavosNro49->equipo1 != '2A')
                    $octavosNro49->creado = true;
                $octavosNro49->save();

                break;
            }
            case "C": {
                $octavosNro50 = Playoff::where("nro_partido", '=', 50)->first();
                $octavosNro50->equipo1 = $nombrePrimerEquipo;
                if($octavosNro50->equipo2 != '2D')
                    $octavosNro50->creado = true;
                $octavosNro50->save();

                $octavosNro52 = Playoff::where("nro_partido", '=', 52)->first();
                $octavosNro52->equipo1 = $nombreSegundoEquipo;
                if($octavosNro52->equipo2 != '1D')
                    $octavosNro52->creado = true;
                $octavosNro52->save();

                break;
            }
            case "D": {
                $octavosNro52 = Playoff::where("nro_partido", '=', 52)->first();
                $octavosNro52->equipo2 = $nombrePrimerEquipo;
                if($octavosNro52->equipo1 != '2C')
                    $octavosNro52->creado = true;
                $octavosNro52->save();

                $octavosNro50 = Playoff::where("nro_partido", '=', 50)->first();
                $octavosNro50->equipo2 = $nombreSegundoEquipo;
                if($octavosNro50->equipo1 != '1C')
                    $octavosNro50->creado = true;
                $octavosNro50->save();

                break;
            }
            case "E": {
                $octavosNro53 = Playoff::where("nro_partido", '=', 53)->first();
                $octavosNro53->equipo1 = $nombrePrimerEquipo;
                if($octavosNro53->equipo2 != '2F')
                    $octavosNro53->creado = true;
                $octavosNro53->save();

                $octavosNro55 = Playoff::where("nro_partido", '=', 55)->first();
                $octavosNro55->equipo1 = $nombreSegundoEquipo;
                if($octavosNro55->equipo2 != '1F')
                    $octavosNro55->creado = true;
                $octavosNro55->save();

                break;
            }
            case "F": {
                $octavosNro55 = Playoff::where("nro_partido", '=', 55)->first();
                $octavosNro55->equipo2 = $nombrePrimerEquipo;
                if($octavosNro55->equipo1 != '2E')
                    $octavosNro55->creado = true;
                $octavosNro55->save();

                $octavosNro53 = Playoff::where("nro_partido", '=', 53)->first();
                $octavosNro53->equipo2 = $nombreSegundoEquipo;
                if($octavosNro53->equipo1 != '1E')
                    $octavosNro53->creado = true;
                $octavosNro53->save();

                break;
            }
            case "G": {
                $octavosNro54 = Playoff::where("nro_partido", '=', 54)->first();
                $octavosNro54->equipo1 = $nombrePrimerEquipo;
                if($octavosNro54->equipo2 != '2H')
                    $octavosNro54->creado = true;
                $octavosNro54->save();

                $octavosNro56 = Playoff::where("nro_partido", '=', 56)->first();
                $octavosNro56->equipo1 = $nombreSegundoEquipo;
                if($octavosNro56->equipo2 != '1H')
                    $octavosNro56->creado = true;
                $octavosNro56->save();

                break;
            }
            case "H": {
                $octavosNro56 = Playoff::where("nro_partido", '=', 56)->first();
                $octavosNro56->equipo2 = $nombrePrimerEquipo;
                if($octavosNro56->equipo1 != '2G')
                    $octavosNro56->creado = true;
                $octavosNro56->save();

                $octavosNro54 = Playoff::where("nro_partido", '=', 54)->first();
                $octavosNro54->equipo2 = $nombreSegundoEquipo;
                if($octavosNro54->equipo1 != '1G')
                    $octavosNro54->creado = true;
                $octavosNro54->save();

                break;
            }
        }
      }
  }
}
