<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Participante;
use App\Models\Playoff;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller {

  public function admin() {

      $grupos = Grupo::all();
      $partidosfasefinal = Playoff::all();

      //return $grupos;

      return view('admin')->with('title', "Ventana de administrador")
                          ->with('grupos', $grupos)
                          ->with('partidosfasefinal', $partidosfasefinal);

  }
}
