var host = "localhost";
// SUMA Y RESTA DE LOS CAMPOS 
$("#totalRemu").on("input", function () {
  // OBTENEMOS LA FECHA SELECCIONADA CONVERTIDA A DATE
  var fechaSeleccionada = new Date($("#fechaI").val());
  // DECLARAMOS LA FECHA, ANTES DE ESTA FECHA SE HACE LA RESTA SI NO NO HACE NADA
  var fechaParaRestar = new Date("2020-07-29");
  if (fechaSeleccionada < fechaParaRestar) {
     var result = parseFloat($('#totalRemu').val()) - parseFloat($('#remBasica').val());
     var resultado = isNaN(result) ? 0 : result;
     $('#otros').val(resultado);
  }
}); 
$("#remBasica, #remReunificada, #desupremo, #otros").on("input", function () {
  // OBTENEMOS LA FECHA SELECCIONADA CONVERTIDA A DATE
  var fechaSeleccionada = new Date($("#fechaI").val());
  // DECLARAMOS LA FECHA, ANTES DE ESTA FECHA SE HACE LA RESTA SI NO NO HACE NADA
  var fechaParaRestar = new Date("2020-07-29");
  if (fechaSeleccionada > fechaParaRestar) {
    var remBasica = parseFloat($('#remBasica').val());
    var remReunificada = parseFloat($('#remReunificada').val());
    var deSupremo = parseFloat($('#desupremo').val());
    var otros = parseFloat($('#otros').val());
    var result = remBasica + remReunificada + deSupremo + otros;
     var resultado = isNaN(result) ? 0 : result;
     $('#totalRemu').val(resultado);
  }
});
// SUMA Y RESTA DE LOS CAMPOS END
// Reemplaza caracteres no numericos a flotantes
$("#muc,#vet,#remBasica, #remReunificada, #desupremo, #otros, #totalRemu,#ley19990, #ley20530, #afp, #ipss, #fonavi").on("input", function () {
  $(this).val($(this).val().replace(/[^0-9.]/g, ''));
});
// Reemplaza caracteres no numericos a flotantes END
// FOMRULARIO PLANILLA
$("#planillaForm").submit(function (event) {
  event.preventDefault(); // Evitar envío predeterminado
  var formData = $(this).serialize(); // Serializar datos del formulario
  $.ajax({
    type: "POST",
    url: `http://${host}/planilla/planilla/create`,
    data: formData,
    success: function (response) {
      // Respuesta del servidor
      console.log(response);
      if (response == "ERROR") {
        //Mensaje modal de ingreso exitoso
        $("#title-modal").text("Ingreso Fallido");
        $("#text-modal").text(
          "Revise los datos ingresados, uno o mas de los campos no tienen el dato requerido"
        );
        $("#img-modal").attr(
          "src",
          `http://${host}/planilla/public/img/falla.png`
        );
        //mensaje modal END
        $(".modal-overlay").fadeIn();
        console.log("algo salio mal");
      } else {
        //Mensaje modal de ingreso exitoso
        $("#title-modal").text("Ingreso exitoso");
        $("#text-modal").text("Planilla registrada con exito");
        $("#img-modal").attr(
          "src",
          `http://${host}/planilla/public/img/mujer-de-negocios.png`
        );
        // Seleccionar el enlace por su clase
        var pdfLink = document.querySelector(".pdf");

        // Cambiar el estilo para que sea visible
        pdfLink.style.display = "inline";
        //mensaje modal END

        $("#fechaF").val("");
        $("#fechaI").val("");
        $("#muc").val("");
        $("#vet").val("");
        $("#remBasica").val("");
        $("#remReunificada").val("");
        $("#deSupremo").val("");
        $("#otros").val("");
        $("#ley19990").val("");
        $("#ley20530").val("");
        $("#afp").val("");
        $("#ipss").val("");
        $("#fonavi").val("");
        $(".modal-overlay").fadeIn();
        console.log("todo salio bien");
      }
    },
    error: function (error) {
      console.error("Error en la solicitud", error);
    },
  });
});
// Cerrar modal al hacer clic en el botón de cerrar o en el fondo oscuro de superposición
$(".close-modal, .modal-overlay").click(function () {
  $(".modal-overlay").fadeOut();
});
