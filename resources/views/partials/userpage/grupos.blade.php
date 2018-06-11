<div class="container pestañas">
  <div class="row">
    <div class="col-12">
        <ul class="nav nav-tabs nav-fill">
            @foreach($grupos as $grupo)
              <li class="nav-item">
                <a class="nav-link @if ($grupo->letra == 'A') active @endif " data-toggle="tab" href="#grupo{{$grupo->letra}}">Grupo {{$grupo->letra}}</a>
              </li>
            @endforeach
        </ul>
    </div>
  </div>
</div>
<div class="tab-content" id="myTabContent">
    @foreach($grupos as $grupo)
    <div class="tab-pane fade show @if ($grupo->letra == 'A') active @endif" id="grupo{{$grupo->letra}}" role="tabpanel" aria-labelledby="grupo-a-tab">
      <div class="row">
        <div class="col-12">
          <hr>
          <h1 class="text-center my-4">PARTIDOS GRUPO {{$grupo->letra}}</h1>
          <div id="accordion{{$grupo->letra}}">
            <ul class="list-group" id="partidos-grupo-{{$grupo->letra}}">
              @foreach($grupo['partidos'] as $partido)
              <li class="list-group-item">
                <div class="container-fluid">
                  <div class="row text-center">
                    <div class="col-4">
                      <img src="./images/banderas/{{$partido['equipo1']}}.png" class="border" />
                      <br>
                      <a class="equipo">{{$partido['equipo1']}}</a>
                      @if($partido['jugado'] == true)
                        <br>
                        <a>{{$partido['golesEquipo1']}}</a>
                      @endif
                    </div>
                    <div class="col-1 align-self-center">
                    </div>
                    <div class="col-2 align-self-center">
                      {{$partido['fecha']}}
                    </div>
                    <div class="col-1 align-self-center">
                    </div>
                    <div class="col-4">
                      <img src="./images/banderas/{{$partido['equipo2']}}.png" class="border" />
                      <br>
                      <a class="equipo">{{$partido['equipo2']}}</a>
                      @if($partido['jugado'] == true)
                        <br>
                        <a>{{$partido['golesEquipo2']}}</a>
                      @endif
                    </div>
                  </div>
                  <div class="row">
                    <div class="col text-center">
                      @if($partido['cerrado'] == false & $partido['jugado'] == false)
                        <button type="button" class="btn btn-primary my-3" onclick="cerrarPartidoGrupo('{{$grupo->_id}}', '{{$partido["_id"]}}', this)">Cerrar Partido</button>
                      @else
                        @if($partido['jugado'] == false)
                          <button type="button" class="btn btn-primary my-3" data-toggle="collapse" data-target="#resultado{{$grupo->letra}}{{ $loop->index }}">Ingresar Resultado</button>
                        @else
                          <label> Partido Jugado </label>
                        @endif
                      @endif
                    </div>
                  </div>
                </div>
                <div class="collapse" data-parent="#accordion" id="resultado{{$grupo->letra}}{{ $loop->index }}">
                    <div class="card card-body">
                      <form>
                        <div class="row">
                          <div class="col-3 offset-3 text-center">
                            <div class="form-group">
                              <label>{{$partido['equipo1']}}</label>
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
                              <label>{{$partido['equipo2']}}</label>
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
                            <button type="button" class="btn btn-primary"  onclick="cargarResultadoGrupo('{{$grupo->_id}}', '{{$partido["_id"]}}', this)">Cargar</button>
                          </div>
                        </div>
                      </form>
                    </div>
                </div>
              </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
  @endforeach
</div>
