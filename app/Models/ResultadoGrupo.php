<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use App\Models\Equipo;

class ResultadoGrupo extends Eloquent {

    public $fillable = ['puntos','pj','pg', 'pe','pp', 'gf', 'gc', 'dif'];

    public function equipo() {

        return $this->belongsTo(Equipo::class);
    }
}
