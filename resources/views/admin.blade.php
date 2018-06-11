<!DOCTYPE html>
<html lang="en">

<html>
    <head>

        @include('partials.metatags')
        @include('partials.style')
        @include('partials.pageIcon')

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" id="token" content="{{ csrf_token() }}">

        <title>Ventana Administrador</title>


        <base href="{{ URL::asset('/') }}" target="_blank">
        <link rel="stylesheet" href="{{ url('stylesheets\bootstrap-darkly.css') }}">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    </head>

    <body id="body">

    @include('partials.userpage.navbarUser')

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
          @include('partials.userpage.menuLateral')
        </div>
        <div class="col-md-6">
          <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="grupos">
              @include('partials.userpage.grupos')
            </div>
            <div class="tab-pane fade show" id="octavos">
              @include('partials.userpage.octavos')
            </div>
            <div class="tab-pane fade show" id="cuartos">
              @include('partials.userpage.cuartos')
            </div>
            <div class="tab-pane fade show" id="semis">
              @include('partials.userpage.semis')
            </div>
            <div class="tab-pane fade show" id="final">
              @include('partials.userpage.final')
            </div>
          </div>
        </div>
      </div>
    </div>

    @include('partials.footer')
    @include('partials.scripts')
    <script src='https://code.jquery.com/jquery-3.1.1.min.js'></script>

  </body>
</html>
