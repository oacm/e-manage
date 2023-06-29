$("#btnGuardaCliente").click(function(event){
  
    if (confirm("¿seguro que quiere guardar este cliente?") == true) {
        var nombre = $( "#txtNombreCliente" ).val();
        var razonsocial = $( "#txtRazonSocial" ).val();
        $.ajax({
            url: 'saveClient',
            type: 'POST',
            data: {nombre: nombre, razonsocial: razonsocial},
            error: function() {
                alert("Ocurrio un error al tratar de Guardar el cliente.");
            },
            success: function(data) {
                res=JSON.parse(data);
                if (res.status == "success"){
                    alert("Cliente Guardado");
                    $( "#txtNombreCliente" ).val('');
                    $( "#txtRazonSocial" ).val('');
                    $('#nuevoCliente').modal('hide');
                    location.reload();
                }else{
                    alert("Ocurrio un error al tratar de Guardar el cliente.");
                }
                /*if (data==0) {
                    
                }else{
                    
                }*/
            }
        }); 
    }
           
         
  
});

$("#btnGuardaRPU").click(function(event){
  
    if (confirm("¿seguro que quiere guardar este RPU?") == true) {
        var selCliente = $( "#selCliente" ).val();
        var txtRPU = $( "#txtRPU" ).val();
        var txtdireccion = $( "#txtdireccion" ).val();
        var txtRZ = $( "#txtRZ" ).val();
        var txtPlanta = $( "#txtPlanta" ).val();
        var txtNR = $( "#txtNR" ).val();
        var txtdivisiom = $( "#txtdivisiom" ).val();
        var txtDC = $( "#txtDC" ).val();
        var txtDM = $( "#txtDM" ).val();
        var txtCR = $( "#txtCR" ).val();
        var txtCA = $( "#txtCA" ).val();
        var txtDR = $( "#txtDR" ).val();
        $.ajax({
            url: 'saveRPU',
            type: 'POST',
            data: {selCliente: selCliente, txtRPU: txtRPU,txtdireccion:txtdireccion,txtRZ:txtRZ,txtPlanta:txtPlanta,txtNR:txtNR,txtdivisiom:txtdivisiom,txtDC:txtDC,txtDM:txtDM,txtCR:txtCR,txtCA:txtCA,txtDR:txtDR},
            error: function() {
                alert("Ocurrio un error al tratar de Guardar el RPU.");
            },
            success: function(data) {
                res=JSON.parse(data);
                if (res.status == "success"){
                    alert("RPU Guardado");
                    $( "#selCliente" ).val();
                    $( "#txtRPU" ).val('');
                    $( "#txtdireccion" ).val('');
                    $( "#txtRZ" ).val('');
                    $( "#txtPlanta" ).val('');
                    $( "#txtNR" ).val('');
                    $( "#txtdivisiom" ).val('');
                    $( "#txtDC" ).val('');
                    $( "#txtDM" ).val('');
                    $( "#txtCD" ).val('');
                    $( "#txtCA" ).val('');
                    $( "#txtDR" ).val('');
                    $('#nuevoRPU').modal('hide');
                }else{
                    alert("Ocurrio un error al tratar de Guardar el RPU.");
                }
                /*if (data==0) {
                    
                }else{
                    
                }*/
            }
        }); 
    }
           
         
  
});