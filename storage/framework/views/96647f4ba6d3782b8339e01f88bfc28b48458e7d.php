<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title></title>

        <base href="<?php echo e(URL::asset('/')); ?>" target="_blank">
        <link rel="stylesheet" href="<?php echo e(url('css/bootstrap.min.css')); ?>">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    </head>

    <body id="body">
      <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <a class="navbar-brand" href="#">PROMUN</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
      </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#">Inicio <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="modal" data-target="#modalComoJugar">¿Cómo jugar?</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" data-toggle="dropdown">
                  Tema
              </a>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="#" onclick="cambiarEstilo('stylesheets/bootstrap-darkly.css')")>Tema 1</a>
                <a class="dropdown-item" href="#" onclick="cambiarEstilo('stylesheets/bootstrap-purple.css')")>Tema 2</a>
              </div>
            </li>
          </ul>
          <ul class=navbar-nav ml-auto>
            <li class="nav-item">
              <a class="nav-link" href="/logout">LIOMESSI</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/logout">Logout</a>
            </li>
          </ul>

        </div>
      </nav>


    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
          <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="perfil">
            </div>
            <div class="tab-pane fade show" id="grupos">
            </div>
            <div class="tab-pane fade show" id="octavos">
            </div>
            <div class="tab-pane fade show" id="cuartos">
            </div>
            <div class="tab-pane fade show" id="semis">
            </div>
            <div class="tab-pane fade show" id="final">
            </div>
            <div class="tab-pane fade show" id="ranking">
            </div>
          </div>

        </div>
        <div class="col-md-3">
        </div>
      </div>
    </div>

    <script src='https://code.jquery.com/jquery-3.1.1.min.js'></script>
    <script type="text/javascript" src="javascripts/logicaAdmin.js"></script>

  </body>
</html>
