<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class MyModel extends Eloquent {

    protected $connection = 'mongodb';

}
