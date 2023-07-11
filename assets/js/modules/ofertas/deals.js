// $("#btnGuardaOferta").click(function(event){

//     if (confirm("¿seguro que quiere crear la oferta?") == true) {
//         var nombre = $( "#txtNombreOferta" ).val();
//         var clienteId = $( "#selCliente" ).val();
//         $.ajax({
//             url: 'saveDeal',
//             type: 'POST',
//             data: {nombre: nombre, clienteId: clienteId},
//             error: function() {
//                 alert("Ocurrio un error al tratar de crear la oferta.");
//             },
//             success: function(data) {
//                 res=JSON.parse(data);
//                 if (res.status == "success"){
//                     alert("Oferta Creada");
//                     $( "#txtNombreOferta" ).val('');
//                     $( "#selCliente" ).val('');
//                     $('#nuevaOferta').modal('hide');
//                     location.reload();
//                 }else{
//                     alert("Ocurrio un error al tratar de crear la oferta.");
//                 }
//                 /*if (data==0) {

//                 }else{

//                 }*/
//             }
//         }); 
//     }

// });

$("#btnGuardaOferta").click(function (event) {
    if (confirm("¿seguro que quiere crear la oferta?") == true) {
        var nombre = $("#selCliente").val();
        var clienteId = $("#selCliente").val();
        var f = $("#selTipoOferta").val() + "-"+ $("#selFormatoOferta").val();
        $.ajax({
            url: 'saveDeal',
            type: 'POST',
            data: { nombre: nombre, clienteId: clienteId , folio: f},
            error: function () {
                alert("Ocurrio un error al tratar de crear la oferta.");
            },
            success: function (data) {
                res = JSON.parse(data);
                if (res.status == "success") {
                    alert("Oferta Creada");
                    $("#selCliente").val('');
                    $("#selTipoOferta").val('');
                    $("#selFormatoOferta").val('');
                    $('#nuevaOferta').modal('hide');
                    location.reload();
                } else {
                    alert("Ocurrio un error al tratar de crear la oferta.");
                }
                /*if (data==0) {
                    
                }else{
                    
                }*/
            }
        });
    }
});




  
function removeDeal(ofertaId) {
    if (confirm("¿seguro que quiere borrar la oferta?") == true) {

        $.ajax({
            url: 'removeDeal',
            type: 'POST',
            data: { ofertaId: ofertaId },
            error: function () {
                alert("Ocurrio un error al tratar de borrar la oferta.");
            },
            success: function (data) {
                res = JSON.parse(data);
                if (res.status == "success") {
                    alert("Oferta Borrada");
                    location.reload();
                } else {
                    alert("Ocurrio un error al tratar de borrar la oferta.");
                }

            }
        });
    }
}

function viewDeal(ofertaId) {
    window.location.href = window.location.origin + "/e-manage/module/deal/viewDeal?ofertaId=" + ofertaId;
    /*$.ajax({
        url: 'viewDeal',
        type: 'POST',
        data: {ofertaId: ofertaId},
        error: function() {
            alert("Ocurrio un error al tratar de visualizar la oferta.");
        },
        success: function(data) {
            res=JSON.parse(data);
            if (res.status == "success"){
                
            }else{
                alert("Ocurrio un error al tratar de visualizar la oferta.");
            }
            
        }
    });*/
}

$("#subir").click(function (event) {
    var tarifasFile = $("#btarifas")[0].files[0];
  
    if (!tarifasFile) {
        alert("Debe seleccionar los archivos.");
        return;
    }

    var confirmar = confirm("¿Está seguro de subir el archivo?");

    if (confirmar) {
        $('#loader').show();

        var formData = new FormData();
        formData.append('tarifasFile', tarifasFile);
  
        $.ajax({
            url: 'subirtarifa',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                
            },
            success: function (data) { 
              $('#loader').hide();
              location.reload();
            },
            error: function () {
              $('#loader').hide();
              alert("Ocurrió un error al guardar el archivo. Por favor, inténtelo de nuevo más tarde.");
            },
            complete: function () {
              $('#loader').hide();
            }
          });
      
    }
});

