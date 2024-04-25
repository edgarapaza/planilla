// SE DEBE PRESIONAR ENTER PARA CAPTAR EL EVENTO CON JAVASCRIPT
$("#mes, #anio").change(function () {
  var mes = $("#mes").val();
  var anio = $("#anio").val();
  var nombres = $("#nombres").val();
  var ap = $("#apellidop").val();
  var am = $("#apellidom").val();
  $.ajax({
    type: "POST",
    url: "http://localhost/planilla/planillaDetalle/getPlanilla",
    data: { nombres, ap, am, mes, anio },
    success: function (response) {
      try {
        let data = JSON.parse(response);
        if (Object.keys(data).length > 0) {
          $("#cargo").val(data.cargo || "");
          $("#fechaI").val(data.spdat1 || "");
          $("#fechaF").val(data.spdat2 || "");
          $("#condicion").val(data.condiper || "");
          $("#moneda").val(data.moneda || "");
          $("#muc").val(data.muc || "");
          $("#vet").val(data.vet || "");
          $("#remBasica").val(data.rembasica || "");
          $("#remReunificada").val(data.remunifi || "");
          $("#deSupremo").val(data.ds276 || "");
          $("#otros").val(data.remotros || "");
          $("#ley19990").val(data.ley19990 || "");
          $("#ley20530").val(data.ley20530 || "");
          $("#afp").val(data.afp || "");
          $("#ipss").val(data.ipss || "");
          $("#fonavi").val(data.fonavi || "");
          $("#trabajador").val(data.trabajador || "");
          $("#id").val(data.id || "");
        } else {
          // Si no hay datos en la respuesta, vaciar los inputs
          $("#cargo, #fechaI, #fechaF, #condicion, #moneda, #muc, #vet, #remBasica, #remReunificada, #deSupremo, #otros, #ley19990, #ley20530, #afp, #ipss, #fonavi, #trabajador, #id").val("");
        }
      } catch (error) {
        $("#cargo, #fechaI, #fechaF, #condicion, #moneda, #muc, #vet, #remBasica, #remReunificada, #deSupremo, #otros, #ley19990, #ley20530, #afp, #ipss, #fonavi, #trabajador, #id").val("");
        //console.error("Error al analizar la respuesta JSON:", error);
      }
    },
    error: function (error) {
      console.error("Error en la solicitud", error);
    },
  });
});

function table() {
  var nombres = $("#nombres").val();
  var ap = $("#apellidop").val();
  var am = $("#apellidom").val();
  $.ajax({
    type: "POST",
    url: "http://localhost/planilla/planillaDetalle/getAllPlanilla",
    data: { nombres, ap, am },
    success: function (response) {
      console.log(response);
      let data = JSON.parse(response);
      let html = "";
      data.forEach((element) => {
        html += `
                <tr id="${element.id}">
                    <td>${element.id}</td>
                    <td>${element.nombres}</td>
                    <td>${element.cargo}</td>
                    <td>${element.fecha_inicial}</td>
                    <td>${element.fecha_final}</td>
                    <td>
                    <a href="http://localhost/planilla/main/renderPlanilla/${element.id}" class="button">Ingresar Planilla</a>
                    <a href="http://localhost/planilla/planillaDetalle/renderDetalle/${element.id}" class="button alert">Editar</a>
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
}
table();