function cerrarPartidoPlayoff(idPartido) {
    $.ajax({
      url: "/api/cerrarPartidoPlayoff",
      type: 'post',
      data: {
        idPartido
      },
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      dataType: 'json',
      success: function (data) {

      }
    });
}

function cerrarPartidoGrupo(idGrupo, idPartido, button) {
    $.ajax({
      url: "/api/cerrarPartidoGrupo",
      type: 'post',
      data: {
        idGrupo,
        idPartido
      },
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      dataType: 'json',
      success: function(button) {
        $(button).closest('li').addClass('bg-danger');
        var idCollapse = $(button).closest('li').find('.collapse').attr('id');
        $(button)
        .removeAttr('onclick')
        .attr('data-toggle', 'collapse')
        .attr('data-target', '#' + idCollapse)
        .text("Cargar resultado");
      }
    });
}

function cargarResultadoPlayoff(button) {
    var equipos = $(button).closest('li').find('.equipo');
    var equipo1 = equipos.eq(0).text();
    var equipo2 = equipos.eq(1).text();
    var inputs = $(button).closest('form').find('select');
    var golesEquipo1 = parseInt(inputs.eq(0).val());
    var golesEquipo2 = parseInt(inputs.eq(1).val());
    $.ajax({
      url: "/api/cargarResultadoPlayoff",
      type: 'post',
      data: {
        "equipo1": equipo1,
        "equipo2": equipo2,
        "golesEquipo1": golesEquipo1,
        "golesEquipo2": golesEquipo2
      },
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      dataType: 'json',
      success: function (data) {

      }
    });
}

function cargarResultadoGrupo(idGrupo, idPartido, button) {
    var inputs = $(button).closest('form').find('select');
    var golesEquipo1 = parseInt(inputs.eq(0).val());
    var golesEquipo2 = parseInt(inputs.eq(1).val());
    $.ajax({
      url: "/api/cargarResultadoGrupo",
      type: 'post',
      data: {
        idGrupo,
        idPartido,
        "golesEquipo1": golesEquipo1,
        "golesEquipo2": golesEquipo2
      },
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      dataType: 'json',
      success: function (data) {

      }
    });
}
