$('#planillaForm').submit(function(event) {
    event.preventDefault(); // Evitar envío predeterminado
    var formData = $(this).serialize();// Serializar datos del formulario
    $.ajax({
        type: 'POST',
        url: 'http://localhost/planilla/planilla/create',
        data: formData,
        success: function(response) {
            // Respuesta del servidor
            console.log(response);
            if(response == 'ERROR'){
                //Mensaje modal de ingreso exitoso
                $("#title-modal").text("Ingreso Fallido");
                $("#text-modal").text("Revise los datos ingresados, uno o mas de los campos no tienen el dato requerido");
                $("#img-modal").attr('src',"http://localhost/planilla/public/img/falla.png")
                //mensaje modal END
                $('.modal-overlay').fadeIn();
                console.log("algo salio mal")
            }else{
                //Mensaje modal de ingreso exitoso
                $("#title-modal").text("Ingreso exitoso");
                $("#text-modal").text("Planilla registrada con exito");
                $("#img-modal").attr('src',"http://localhost/planilla/public/img/mujer-de-negocios.png")
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
                $('.modal-overlay').fadeIn();
                console.log("todo salio bien")

            }
        },
        error: function (error) {
            console.error("Error en la solicitud", error);
          },
        
    });
});

// Cerrar modal al hacer clic en el botón de cerrar o en el fondo oscuro de superposición
$('.close-modal, .modal-overlay').click(function() {
    $('.modal-overlay').fadeOut();
});