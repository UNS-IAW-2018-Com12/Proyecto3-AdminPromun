<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use App\Models\Pronostico;

class Partido extends Eloquent {

    public $collection = 'partidos';

    public function pronosticos() {

      return $this->embedsMany(Pronostico::class);
    }

    public function id() {

        return $this->embedsOne('_id');
    }
}
