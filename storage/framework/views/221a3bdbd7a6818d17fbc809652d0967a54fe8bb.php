<div class="container pestañas">
  <div class="row">
    <div class="col-12">
        <ul class="nav nav-tabs nav-fill">
            <?php $__currentLoopData = $grupos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li class="nav-item">
                <a class="nav-link <?php if($grupo->letra == 'A'): ?> active <?php endif; ?> " data-toggle="tab" href="#grupo<?php echo e($grupo->letra); ?>">Grupo <?php echo e($grupo->letra); ?></a>
              </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
  </div>
</div>
<div class="tab-content" id="myTabContent">
    <?php $__currentLoopData = $grupos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="tab-pane fade show <?php if($grupo->letra == 'A'): ?> active <?php endif; ?>" id="grupo<?php echo e($grupo->letra); ?>" role="tabpanel" aria-labelledby="grupo-a-tab">
      <div class="row">
        <div class="col-12">
          <hr>
          <h1 class="text-center my-4">PARTIDOS GRUPO <?php echo e($grupo->letra); ?></h1>
          <div id="accordion<?php echo e($grupo->letra); ?>">
            <ul class="list-group" id="partidos-grupo-<?php echo e($grupo->letra); ?>">
              <?php $__currentLoopData = $grupo['partidos']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partido): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li class="list-group-item">
                <div class="container-fluid">
                  <div class="row text-center">
                    <div class="col-4">
                      <img src="./images/banderas/<?php echo e($partido['equipo1']); ?>.png" class="border" />
                      <br>
                      <a class="equipo"><?php echo e($partido['equipo1']); ?></a>
                      <?php if($partido['jugado'] == true): ?>
                        <br>
                        <a><?php echo e($partido['golesEquipo1']); ?></a>
                      <?php endif; ?>
                    </div>
                    <div class="col-1 align-self-center">
                    </div>
                    <div class="col-2 align-self-center">
                      <?php echo e($partido['fecha']); ?>

                    </div>
                    <div class="col-1 align-self-center">
                    </div>
                    <div class="col-4">
                      <img src="./images/banderas/<?php echo e($partido['equipo2']); ?>.png" class="border" />
                      <br>
                      <a class="equipo"><?php echo e($partido['equipo2']); ?></a>
                      <?php if($partido['jugado'] == true): ?>
                        <br>
                        <a><?php echo e($partido['golesEquipo2']); ?></a>
                      <?php endif; ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col text-center">
                      <?php if($partido['cerrado'] == false & $partido['jugado'] == false): ?>
                        <button type="button" class="btn btn-primary my-3" onclick="cerrarPartidoGrupo('<?php echo e($grupo->_id); ?>', '<?php echo e($partido["_id"]); ?>', this)">Cerrar Partido</button>
                      <?php else: ?>
                        <?php if($partido['jugado'] == false): ?>
                          <button type="button" class="btn btn-primary my-3" data-toggle="collapse" data-target="#resultado<?php echo e($grupo->letra); ?><?php echo e($loop->index); ?>">Ingresar Resultado</button>
                        <?php else: ?>
                          <label> Partido Jugado </label>
                        <?php endif; ?>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
                <div class="collapse" data-parent="#accordion" id="resultado<?php echo e($grupo->letra); ?><?php echo e($loop->index); ?>">
                    <div class="card card-body">
                      <form>
                        <div class="row">
                          <div class="col-3 offset-3 text-center">
                            <div class="form-group">
                              <label><?php echo e($partido['equipo1']); ?></label>
                              <select class="form-control">
                                <option>0</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                                <option>7</option>
                                <option>8</option>
                                <option>9</option>
                                <option>10</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-3 text-center">
                            <div class="form-group">
                              <label><?php echo e($partido['equipo2']); ?></label>
                              <select class="form-control">
                                <option>0</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                                <option>7</option>
                                <option>8</option>
                                <option>9</option>
                                <option>10</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col text-center">
                            <button type="button" class="btn btn-primary"  onclick="cargarResultadoGrupo('<?php echo e($grupo->_id); ?>', '<?php echo e($partido["_id"]); ?>', this)">Cargar</button>
                          </div>
                        </div>
                      </form>
                    </div>
                </div>
              </li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
