var host = "localhost";
//console.log("funciona!!!");
// agregar editar-> debe tener un filtro por fecha
// al Ingresar, se muestre sus datos iniciales, y con el filtro se complete todo los demas datos
// automaticamente
var registrosPorPagina = 100;
var paginaActual = 1;
var paginasMostradas = 7;
// TABLA: MUESTRA TODAS LAS PLANILLAS
function table() {
  var inicio = (paginaActual - 1) * registrosPorPagina;
  var fin = inicio + registrosPorPagina;
  $.ajax({
    type: "GET",
    url: `http://${host}/planilla/main/read`,
    success: function (response) {
      let datas = JSON.parse(response);
      var data = datas.slice(inicio, fin);
      let html = "";
      let html_viewer = "";
      data.forEach((element) => {
        html += `
                <tr id="${element.id}">
                    <td>${element.id}</td>
                    <td>${element.nombres}</td>
                    <td>${element.cargo}</td>
                    <td>${element.fecha_inicial}</td>
                    <td>${element.fecha_final}</td>
                    <td>
                    <a href="http://${host}/planilla/main/renderPlanilla/${element.id}" class="button">Ingresar Planilla</a>
                    <a href="http://${host}/planilla/planillaDetalle/renderDetalle/${element.id}" class="button alert">Editar</a>
                    </td>
                    <td>
                    <a href="http://${host}/planilla/impresion/pdf/${element.id}" class="button success" target="_blank">Planilla</a>

                    <a href="http://${host}/planilla/impresion/fonavi/${element.id}" class="button warning" target="_blank">FONAVI</a>
                    </td>
                </tr>`;
        html_viewer += `
                <tr id="${element.id}">
                    <td>${element.id}</td>
                    <td>${element.nombres}</td>
                    <td>${element.cargo}</td>
                    <td>${element.fecha_inicial}</td>
                    <td>${element.fecha_final}</td>
                    <td>
                    <a href="http://${host}/planilla/impresion/pdf/${element.id}" class="button success" target="_blank">Planilla</a>

                    <a href="http://${host}/planilla/impresion/fonavi/${element.id}" class="button warning" target="_blank">FONAVI</a>
                    </td>
                </tr>`;
      });
      if(tipo=="viewer"){
        $("#datos").html(html_viewer);
      }else{
        $("#datos").html(html);
      }

      // Crear controles de paginación
      crearControlesPaginacion(datas);
    },
    error: function (error) {
      console.error("Error en la solicitud", error);
    },
  });
}
// BUSCADOR: BUSCA COICIDENCIAS DE TEXTO, POR: nombres, y , apellido paterno
$("#mysearch, #mysearch1,#mysearch2,#mysearch3").keyup(function () {
  var nombres = $("#mysearch").val();
  var ap = $("#mysearch1").val();
  var am = $("#mysearch2").val();
  var cargo = $("#mysearch3").val();
  $.ajax({
    type: "POST",
    url: `http://${host}/planilla/main/search`,
    data: { nombres, ap, am, cargo },
    success: function (response) {
      //console.log(response);
      let data = JSON.parse(response);
      let html = "";
      let html_viewer = "";
      data.forEach((element) => {
        html += `
                    <tr>
                        <td>${element.id}</td>
                        <td>${element.nombres}</td>
                        <td>${element.cargo}</td>
                        <td>${element.fecha_inicial}</td>
                        <td>${element.fecha_final}</td>
                        <td>
                        <a href="http://${host}/planilla/main/renderPlanilla/${element.id}" class="button">Ingresar Planilla</a>
                        <a href="http://${host}/planilla/planillaDetalle/renderDetalle/${element.id}" class="button alert">Editar</a>
                        </td>
                        <td>
                        <a href="http://${host}/planilla/impresion/pdf/${element.id}" class="button success" target="_blank">Planilla</a>

                        <a href="http://${host}/planilla/impresion/fonavi/${element.id}" class="button warning" target="_blank">FONAVI</a>
                        </td>
                    </tr>`;
        html_viewer += `
                    <tr>
                        <td>${element.id}</td>
                        <td>${element.nombres}</td>
                        <td>${element.cargo}</td>
                        <td>${element.fecha_inicial}</td>
                        <td>${element.fecha_final}</td>
                        <td>
                        <a href="http://${host}/planilla/impresion/pdf/${element.id}" class="button success" target="_blank">Planilla</a>

                        <a href="http://${host}/planilla/impresion/fonavi/${element.id}" class="button warning" target="_blank">FONAVI</a>
                        </td>
                    </tr>`;
      });
      if(tipo=="viewer"){
        $("#datos").html(html_viewer);
      }else{
        $("#datos").html(html);
      }
    },
    error: function (error) {
      console.error("Error en la solicitud", error);
    },
  });
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
