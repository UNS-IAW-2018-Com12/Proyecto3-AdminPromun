<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use App\Models\Equipo;
use App\Models\Partido;

class Grupo extends Eloquent {

    public $fillable = ['equipos'];

    protected function equipos() {

      return $this->embedsMany(Equipo::class);
    }

    protected function partidos() {

      return $this->embedsMany(Partido::class);
    }
}
