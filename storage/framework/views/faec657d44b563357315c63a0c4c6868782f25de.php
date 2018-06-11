<li class="list-group-item">
  <div class="container-fluid">
    <div class="row text-center">
      <div class="col-4">
        <img src="./images/banderas/<?php echo e($partido); ?>.png" class="border" />
        <br>
      </div>
      <div class="col-1 align-self-center">
          <span class="score">
          </span>
      </div>
      <div class="col-2 align-self-center">
      </div>
      <div class="col-1 align-self-center">
          <span class="score">
          </span>
      </div>
      <div class="col-4">
        <img src="./images/banderas/banderaneutra.png" class="border" />
        <br>
      </div>
    </div>
    <div class="row">
      <div class="col text-center">
        <button type="button" class="btn btn-primary my-3" data-toggle="collapse" data-target="#pronostico" >Ingresar pronóstico</button>
      </div>
    </div>
  </div>
  <div class="collapse" data-parent="#accordion" id="pronostico">
      <div class="card card-body">
        <form>
          <div class="row">
            <div class="col-3 offset-3 text-center">
              <div class="form-group">
                <label>Goles</label>
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
                <label>Goles</label>
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
              <button type="button" class="btn btn-primary" onclick="agregarPronosticoFaseFinal(this)">Enviar</button>
            </div>
          </div>
        </form>
      </div>
  </div>
</li>
