//console.log("funciona!!!");
var registrosPorPagina = 100;
var paginaActual = 1;
var paginasMostradas = 7;
// TABLA: MUESTRA TODAS LAS PLANILLAS
function table() {
    var inicio = (paginaActual - 1) * registrosPorPagina;
  var fin = inicio + registrosPorPagina;
  $.ajax({
    type: "GET",
    url: "http://localhost/planilla/main/read",
    success: function (response) {
      //console.log(response);
      let datas = JSON.parse(response);
      var data = datas.slice(inicio, fin);
      let html = "";
      data.forEach((element) => {
        html += `
                <tr>
                    <td>${element.id}</td>
                    <td>${element.nombres}</td>
                    <td>${element.cargo}</td>
                    <td>${element.fecha_inicial}</td>
                    <td>${element.fecha_final}</td>
                    <td>
                    <a href="#" class="button">Ingresar Planilla</a> |
                    <a href="#" class="button">Editar</a>
                    </td>
                    <td>
                    <a href="#" class="button success">Planilla</a>
                    <a href="#" class="button success">FONAVI</a>
                    <a href="#" class="button success">Liquidacion</a>
                    </td>
                </tr>`;
      });
      $("#datos").html(html);
      // Crear controles de paginación
      crearControlesPaginacion(datas);
    },
    error: function (error) {
      console.error("Error en la solicitud", error);
    },
  });
}
// BUSCADOR: BUSCA COICIDENCIAS DE TEXTO, POR: nombres, y , apellido paterno
$("#search").keyup(function () {
  if ($("#search").val()) {
    let search = $("#search").val();
    //console.log(search);
    $.ajax({
      type: "POST",
      url: "http://localhost/planilla/main/search",
      data: { search },
      success: function (response) {
        //console.log(response);
        let data = JSON.parse(response);
        let html = "";
        data.forEach((element) => {
            html += `
                    <tr>
                        <td>${element.id}</td>
                        <td>${element.nombres}</td>
                        <td>${element.cargo}</td>
                        <td>${element.fecha_inicial}</td>
                        <td>${element.fecha_final}</td>
                        <td>
                        <a href="#" class="button">Ingresar Planilla</a> |
                        <a href="#" class="button">Editar</a>
                        </td>
                        <td>
                        <a href="#" class="button success">Planilla</a>
                        <a href="#" class="button success">FONAVI</a>
                        <a href="#" class="button success">Liquidacion</a>
                        </td>
                    </tr>`;
        });
        
        $("#datos").html(html);
      },
      error: function (error) {
        console.error("Error en la solicitud", error);
      },
    });
  } else {
    table();
  }
});

// Paginacion Tables
function crearControlesPaginacion(datos) {
    var totalPaginas = Math.ceil(datos.length / registrosPorPagina);
  
    $("#paginacion").empty();
    var inicio = Math.max(1, paginaActual - Math.floor(paginasMostradas / 2));
    var fin = Math.min(totalPaginas, inicio + paginasMostradas - 1);
  
    // Botón de página anterior
    if (paginaActual > 1) {
      $("#paginacion").append(
        '<button class="button pagina" data-pagina="' +
          (paginaActual - 1) +
          '">Anterior</button>'
      );
    }
  
    // Botones de páginas
    for (var i = inicio; i <= fin; i++) {
      $("#paginacion").append(
        '<button class="button pagina ' +
          (i === paginaActual ? "activo" : "") +
          '" data-pagina="' +
          i +
          '">' +
          i +
          "</button>"
      );
    }
  
    // Botón de página siguiente
    if (paginaActual < totalPaginas) {
      $("#paginacion").append(
        '<button class="button pagina" data-pagina="' +
          (paginaActual + 1) +
          '">Siguiente</button>'
      );
    }
  }
  
  // Mostrar datos iniciales y controles de paginación
  // mostrarDatos();
  table();
  //crearControlesPaginacion();
  
  // Cambiar de página al hacer clic en un botón de paginación
  $(document).on("click", ".pagina", function () {
    paginaActual = parseInt($(this).data("pagina"));
    table();
    // mostrarDatos();
    //crearControlesPaginacion();
  });