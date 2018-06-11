<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use App\Models\ResultadoGrupo;

class Equipo extends Eloquent {

    public $fillable = ['resultados_grupo'];

    public $collection = 'equipos';

    public function resultadoGrupo() {

        return $this->embedsOne(ResultadoGrupo::class);
    }
}
