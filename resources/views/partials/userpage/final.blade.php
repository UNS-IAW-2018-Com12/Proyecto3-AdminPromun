<h1 class="text-center">Final</h1>
<div id="accordionCuartos">
  <ul class="list-group my-3">
    @foreach($partidosfasefinal as $partido)
      @if ($partido->fase == 'final')
        <li class="list-group-item">
          <div class="container-fluid">
            <div class="row text-center">
              <div class="col-4">
                @if($partido->cerrado == true)
                  <img src="./images/banderas/{{$partido->equipo1}}.png" class="border" />
                @else
                  <img src="./images/banderas/banderaneutra.png" class="border" />
                @endif
                <br>
              </div>
              <div class="col-1 align-self-center">
              </div>
              <div class="col-2 align-self-center">
                {{$partido->fecha}}
              </div>
              <div class="col-1 align-self-center">
              </div>
              <div class="col-4">
                @if($partido->cerrado == true)
                  <img src="./images/banderas/{{$partido->equipo2}}.png" class="border" />
                @else
                  <img src="./images/banderas/banderaneutra.png" class="border" />
                @endif
                <br>
              </div>
            </div>
            <div class="row">
              <div class="col text-center">
                @if($partido->cerrado == true)
                  <button type="button" class="btn btn-primary my-3" data-toggle="collapse" data-target="#pronostico{{ $loop->index }}">Ingresar Resultado</button>
                @else
                  <button type="button" class="btn btn-primary my-3" data-target="#pronostico{{ $loop->index }}" onclick="cerrarPartidoPlayoff(this)">Cerrar Partido</button>
                @endif
              </div>
            </div>
          </div>
          <div class="collapse" data-parent="#accordion" id="pronostico{{ $loop->index }}">
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
                      <button type="button" class="btn btn-primary" onclick="agregarPronosticoFaseFinal(this)">Cargar</button>
                    </div>
                  </div>
                </form>
              </div>
          </div>
        </li>
      @endif
    @endforeach
  </ul>
</div>
