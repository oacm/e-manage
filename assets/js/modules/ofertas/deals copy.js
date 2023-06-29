$("#btnGuardaOferta").click(function(event){
  
    if (confirm("¿seguro que quiere crear la oferta?") == true) {
        var nombre = $( "#txtNombreOferta" ).val();
        var clienteId = $( "#selCliente" ).val();
        $.ajax({
            url: 'saveDeal',
            type: 'POST',
            data: {nombre: nombre, clienteId: clienteId},
            error: function() {
                alert("Ocurrio un error al tratar de crear la oferta.");
            },
            success: function(data) {
                res=JSON.parse(data);
                if (res.status == "success"){
                    alert("Oferta Creada");
                    $( "#txtNombreOferta" ).val('');
                    $( "#selCliente" ).val('');
                    $('#nuevaOferta').modal('hide');
                    location.reload();
                }else{
                    alert("Ocurrio un error al tratar de crear la oferta.");
                }
                /*if (data==0) {
                    
                }else{
                    
                }*/
            }
        }); 
    }
           
         
  
});

function removeDeal(ofertaId){
    if (confirm("¿seguro que quiere borrar la oferta?") == true) {
        
        
        $.ajax({
            url: 'removeDeal',
            type: 'POST',
            data: {ofertaId: ofertaId},
            error: function() {
                alert("Ocurrio un error al tratar de borrar la oferta.");
            },
            success: function(data) {
                res=JSON.parse(data);
                if (res.status == "success"){
                    alert("Oferta Borrada");
                    location.reload();
                }else{
                    alert("Ocurrio un error al tratar de borrar la oferta.");
                }
                
            }
        }); 
    }
}

function viewDeal(ofertaId){
    window.location.href = window.location.origin+"/e-manage/module/deal/viewDeal?ofertaId="+ofertaId;
    
}