<!DOCTYPE html>
<html lang="en">

<html>
    <head>

        <?php echo $__env->make('partials.metatags', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('partials.style', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('partials.pageIcon', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" id="token" content="<?php echo e(csrf_token()); ?>">

        <title>Ventana Administrador</title>


        <base href="<?php echo e(URL::asset('/')); ?>" target="_blank">
        <link rel="stylesheet" href="<?php echo e(url('stylesheets\bootstrap-darkly.css')); ?>">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    </head>

    <body id="body">

    <?php echo $__env->make('partials.userpage.navbarUser', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
          <?php echo $__env->make('partials.userpage.menuLateral', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
        <div class="col-md-6">
          <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="grupos">
              <?php echo $__env->make('partials.userpage.grupos', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            <div class="tab-pane fade show" id="octavos">
              <?php echo $__env->make('partials.userpage.octavos', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            <div class="tab-pane fade show" id="cuartos">
              <?php echo $__env->make('partials.userpage.cuartos', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            <div class="tab-pane fade show" id="semis">
              <?php echo $__env->make('partials.userpage.semis', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            <div class="tab-pane fade show" id="final">
              <?php echo $__env->make('partials.userpage.final', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php echo $__env->make('partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('partials.scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <script src='https://code.jquery.com/jquery-3.1.1.min.js'></script>

  </body>
</html>
