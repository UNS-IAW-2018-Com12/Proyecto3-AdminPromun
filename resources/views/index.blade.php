<!DOCTYPE html>
<html>
       <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Acceso Administrador</title>

      </head>
      <body>

          <form id="loginForm" srole="form" method="POST" action="{{ route('login') }}" >

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group row">
              <label for="username" class="col-sm-1 col-form-label">Username</label>
              <div class="col-sm-5">
                <input id="username" type="text" class="form-control" name="username" placeholder="Username" value="{{ old('usrName') }}" required autofocus>
              </div>
            </div>

            <div class="form-group row">
              <label for="password" class="col-sm-1 col-form-label">Password</label>
              <div class="col-sm-5">
                <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
              </div>
            </div>

            <div id="SignInButton" class="form-group row">
              <div class="col-sm-5">
                <button type="submit" class="btn btn-primary">Admin Login</button>
              </div>
            </div>

          </form>
      </body>

    @include('partials.footer')

    <link rel="stylesheet" href="{{ url('stylesheets\bootstrap-darkly.css') }}">
    <link rel="stylesheet" href="../stylesheets/styleIndex.css">

    <script src='https://code.jquery.com/jquery-3.1.1.min.js'></script>
</html>
