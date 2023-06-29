var resultdata;
var resultdataid;
var editando = 0;
  construirtabla();
  if ($( "#inputCentral" ).val() == 0) {
    $("#tablaexcelo").hide();
  }else {
    validacaptura();
  }

 


$("#guardaform").click(function(event){
  
  
  event.preventDefault();
  hot.validateCells(function(valid) {
    if (valid) {
      var dataConfirm="";
      if(getSourceDataExcel[0][25] == undefined){
          getSourceDataExcel[0][25] = 0;
      }
      for (var hora = 1; hora < 26 ; hora++) {
        sep="";
        if (hora==5 || hora==10 || hora==15 || hora==20){
          sep="\n\n";
          
        }else{
          sep=" | ";
          
        }
        dataConfirm+=""+hora+"h="+ getSourceDataExcel[0][hora]+sep;
        
      }
      var mensaje = dataConfirm;//.substring(0, dataConfirm.length - 2);
      if (confirm("¿seguro que quiere gardar esos valores?\n\n"+ mensaje) == true) {
        
        if ($("#inputCentral" ).val() != 0) 
        {
          inicispinner("Guardando");
        }
        //spinnersaveconfirm(getSourceDataExcel[0]);
        
        
        var fechainicio = $( "#fechainicio" ).val();
        var inputCentral = $( "#inputCentral" ).val();
        var inputOrden = $( "#inputOrden" ).val();
        $.ajax({
          url: 'saveFormasTank',
          type: 'POST',
          data: {datExcel: getSourceDataExcel, totDatExcel: totgetSourceData,fechainicio:fechainicio,inputCentral:inputCentral,inputOrden:inputOrden,arrayrelunit:arrayrelunit,editando:editando},
          error: function() {
            cerrarerrorspinner("Ocurrio un error al tratar de Guardar los niveles de agua.");
          },
          success: function(data) {
            
            if (data==0) {
              cerrarnormalspinner("Solo se puede guardar los niveles de agua una vez al dia.");
            }else{
              cerrarnormalspinner ("Niveles de Tanque guardados correctamente");
              hot.clear();
              //limpiartotales();
              if (editando == 1) {
                $("#tablaexcel").hide();
                $("#tablaexcelo").hide();
                $("#guardaform").hide();
              }else{
                $("#tablaexcel").show();
                $("#tablaexcelo").show();
                $("#guardaform").show();
              }

            }

                    
          }
        }); 

      }
    }else{
      hot.render();
      cerrarerrorspinner("Ocurrio un error en la captura de información");
    }
  });
       
       

});



$("#actualizaform").click(function(event){


  if ($("#inputCentral" ).val() != 0) 
  {
    inicispinner("Actualizando");
  }
  event.preventDefault();
  hot.validateCells(function(valid) {
    if (valid) {
       
       var fechainicio = $( "#fechainicio" ).val();
       var inputCentral = $( "#inputCentral" ).val();
       var inputOrden = $( "#inputOrden" ).val();

       



        $.ajax({
           url: 'actualizaFormas',
           type: 'POST',
           data: {datExcel: getSourceDataExcel, totDatExcel: totgetSourceData,fechainicio:fechainicio,inputCentral:inputCentral,inputOrden:inputOrden,arrayrelunit:arrayrelunit,resultdataid:resultdataid},
           error: function(data) {
           
            
            cerrarerrorspinner("Ocurrio un error al tratar de Actualizar la Energía Producida");
           },
           success: function(data) {
                
            cerrarnormalspinner("Energía Producida actualizada correctamente");
                
            
           }
        }); 


            }
            else{

              
              hot.render();
              cerrarerrorspinner("Ocurrio un error en la captura de información");
            }
           
            });
       
       

});




$("#cancelarform").click(function(){
  if (typeof hot === "undefined"){}else{
    try {
      hot.destroy();
    }
    catch(err) {
    }
  }
  

  if (editando == 1) {
    if ($("#inputCentral" ).val() != 0) 
    {
      inicispinner("Buscando");
    }


    resultdata = [];
    resultdataid = [];
    $("#tablaexcelo").show();
  

    $("#guardaform").hide();
    event.preventDefault();
    var fechainicio = $( "#fechainicio" ).val();
    var inputCentral = $( "#inputCentral" ).val();
    var inputOrden = $( "#inputOrden" ).val();
    $.ajax({
      url: 'FormasConsultasTank',
      type: 'POST',
      data: {fechainicio:fechainicio,inputCentral:inputCentral,inputOrden:inputOrden},
      error: function() {
        cerrarerrorspinner("Ocurrio un error en la busqueda de información");
      },
      success: function(data) {
        resultdata = JSON.parse(data);
        if (resultdata.length == 0) {
          cerrarnormalspinner("Obteniendo información nuevamente");
          $("#actualizaform").hide();
          construirtabla();
          $("#tablaexcel").show();
          $("#guardaform").show();
        }else{
          resultdata.forEach(function(object) {
            resultdataid.push(object.id_Ener_ep_offer_sale);
          });
          $("#actualizaform").show();
          $("#tablaexcel").show();
          $("#tablaexcelo").show();
          cerrarnormalspinner("Obteniendo información nuevamente");
          
        }
                
        construirtabla();
        cosntruirtablaactualiza(); 
      }
    }); 
  }else{
    construirtabla();
    $("#tablaexcel").show();
    $("#tablaexcelo").show();
  }
});


$("#inputCentral").change(function(){
  if (typeof hot === "undefined"){}else{
    try {
      hot.destroy();
    }
    catch(err) {
    }
  }


  if (editando == 1) {
    $("#tablaexcel").hide();
    $("#tablaexcelo").hide();
    $("#guardaform").hide();
    $("#actualizaform").hide();
  }else{
    construirtabla();
    $("#tablaexcel").show();
    $("#tablaexcelo").show();
    
    if ($( "#inputCentral" ).val() > 0) {
      
      validacaptura();
    } 
  }

});

$("#verinicio").click(function(){
  $("#bhistoricos").hide();
  $("#actualizaform").hide();
  editando = 0;
  $("#tablaexcel").show();
  $("#tablaexcelo").show();
  $("#guardaform").show();
  $("#feinicio").show();
  $("#febusqueda").hide();
        
  

  $("#fechainicio").removeAttr("name");
  $("#fechainicio").attr("name", "fechas");
  ejefecha();

  construirtabla();
  

        
  if ($( "#inputCentral" ).val() > 0) {
    validacaptura();
  }


});

$("#verhistorico").click(function(){
  $("#bhistoricos").show();
  $("#tablaexcel").hide();
  $("#guardaform").hide();
  $("#feinicio").hide();
  $("#febusqueda").show();
  $("#tablaexcelo").hide();
  editando = 1;
  
  limpiartotales();
  $("#fechainicio").removeAttr("name");
  $("#fechainicio").attr("name", "fechasini");
  ejefechasini();
         
        
});



$("#buscarexcel").click(function(){
  if ($("#inputCentral" ).val() != 0) 
  {
    inicispinner("Buscando");
  }
  resultdata = [];
  resultdataid = [];
  $("#tablaexcelo").show();
  

  $("#guardaform").hide();
  event.preventDefault();
  var fechainicio = $( "#fechainicio" ).val();
  var inputCentral = $( "#inputCentral" ).val();
  var inputOrden = $( "#inputOrden" ).val();
  $.ajax({
    url: 'FormasConsultasTank',
    type: 'POST',
    data: {fechainicio:fechainicio,inputCentral:inputCentral,inputOrden:inputOrden},
    error: function() {
    cerrarerrorspinner("Ocurrio un error en la busqueda de información");
    },
    success: function(data) {
      esultdata = JSON.parse(data);
      if (resultdata.length == 0) {
        cerrarnormalspinner("No se encontro información");
        $("#actualizaform").hide();
        //if (typeof hot === "undefined"){}else{hot.destroy();}
        construirtabla();
        $("#tablaexcel").show();
        $("#guardaform").show();
      }else{
        resultdata.forEach(function(object) {
          resultdataid.push(object.id_Ener_ep_offer_sale);
        });
        $("#actualizaform").show();
        $("#tablaexcel").show();
        $("#tablaexcelo").show();
        cerrarnormalspinner("Obteniendo información");       
      }
               
      construirtabla();
      cosntruirtablaactualiza();
                
    }
  }); 
});


function construirtabla(){
  $('#rangemsg').html("");
  var val = $('#inputCentral').val();
  if (val !=0) {
    var val = $('#inputCentral > option').length;
    if (val == 1) {
      val=0;
    }else{
      val = ($("#inputCentral option:selected").index())-1;
    }
    
    $("#inputOrden option:selected").val(centralescodigos[val]["id_weather_dam"]);
    $('#inputOrden option:selected').text(centralescodigos[val]["weather_dam_name"]);
    
    rowcabeceras = "rowHeaders: [";
    
    rowcabeceras+="'Nivel'";
    rowcabeceras = rowcabeceras +"],";
    
  
    var tamaoH = 84;
    
    logicaExcel = "hot = new Handsontable(container, {data: data,maxRows:"+1+",colWidths: 34,colHeaders: true,rowHeaders: true,height: "+tamaoH+","+rowcabeceras+"rowHeaderWidth: 74,colHeaders: ['01h', '02h', '03h', '04h', '05h', '06h', '07h', '08h', '09h', '10h', '11h', '12h', '13h', '14h', '15h', '16h', '17h', '18h', '19h', '20h', '21h', '22h', '23h', '24h','25h'],columns: [{data: '1',type: 'numeric',allowEmpty: false},{data: '2',type: 'numeric',allowEmpty: false},{data: '3',type: 'numeric',allowEmpty: false},{data: '4',type: 'numeric',allowEmpty: false},{data: '5',type: 'numeric',allowEmpty:false},{data: '6',type: 'numeric',allowEmpty: false},{data: '7',type: 'numeric',allowEmpty: false},{data: '8',type: 'numeric',allowEmpty: false},{data: '9',type: 'numeric',allowEmpty: false},{data: '10',type: 'numeric',allowEmpty: false},{data: '11',type: 'numeric',allowEmpty: false},{data: '12',type: 'numeric',allowEmpty: false},{data: '13',type: 'numeric',allowEmpty: false},{data: '14',type: 'numeric',allowEmpty: false},{data: '15',type: 'numeric',allowEmpty: false},{data: '16',type: 'numeric',allowEmpty: false},{data: '17',type: 'numeric',allowEmpty: false},{data: '18',type: 'numeric',allowEmpty: false},{data: '19',type: 'numeric',allowEmpty: false},{data: '20',type: 'numeric',allowEmpty: false},{data: '21',type: 'numeric',allowEmpty: false},{data: '22',type: 'numeric',allowEmpty: false},{data: '23',type: 'numeric',allowEmpty: false},{data: '24',type: 'numeric',allowEmpty: false},{data: '25',type: 'numeric',allowEmpty: true}],afterChange: function(src, changes){if(changes !== 'loadData'){var data = this.getDataAtRow(src[0][0]);getSourceDataExcel = hot.getSourceData();totgetSourceData=getSourceDataExcel.length -1;}}});";
    construirExcel();
    
    hot.addHook('beforeChange', function(changes, src) {
      var ret = true;
      
      if (centralescodigos[val]["id_weather_dam"] == 9 || centralescodigos[val]["id_weather_dam"] == 10){//alameda 1 y 2
        if (changes[0][3] >=0 && changes[0][3] <=21){
          ret = true;
          $('#rangemsg').html("");
        }else{
          ret= false;
          $('#rangemsg').html('<p style="color:#258064; font-size: 16px;">El valor debe ser entre 0 y 21</p>');
        }
      }
      if (centralescodigos[val]["id_weather_dam"] == 11){//temascaltepec
        if (changes[0][3] >=0 && changes[0][3] <=4){
          ret = true;
          $('#rangemsg').html("");
        }else{
          ret= false;
          $('#rangemsg').html('<p style="color:#258064; font-size: 16px;">El valor debe ser entre 0 y 4</p>');
        }
      }
      return ret;
    });
    hot.addHook('afterPaste', function(data, coords) {
      //console.log(data);
    });
  }
} 





function cosntruirtablaactualiza(){
var iniciaHoras = 0;
                var filaHoras = -1;
               for (var cuentahoras = 0; cuentahoras < resultdata.length ; cuentahoras++) {

                
                if (resultdata[cuentahoras]["Ener_ep_offer_sale_hour"]==1) {

                 iniciaHoras = 0;
                  filaHoras ++;
                }

                hot.setDataAtCell(filaHoras, iniciaHoras, resultdata[cuentahoras]["Ener_ep_offer_sale_value"]);
                
                iniciaHoras++;

                



               }

}



function inicispinner(aviso){
    $("#modal-win-alert .modal-header h2").html("Procesando");
    $("#modal-win-alert .close").html("<i class='fa fa-info-circle'></i>");
    $("#modal-win-alert .modal-body").html( aviso + "<img src='" + __urlRootImg + "/assets/images/load.gif' />");
     
    $("#modal-win-alert").css({
             "display" : "block",
             "z-index" : 10001
   
    });

}

function inicispinnerVacio(){
    $("#modal-win-alert .modal-header h2").html("Procesando");
    $("#modal-win-alert .close").html("<i class='fa fa-info-circle'></i>");
     
    $("#modal-win-alert").css({
             "display" : "block",
             "z-index" : 10001
   
    });

}





function cerrarnormalspinner(aviso){

$("#modal-win-alert .modal-header h2").html("Aviso");
                $("#modal-win-alert .close").html("<i class='fa fa-info-circle'></i>");
                $("#modal-win-alert .modal-body").html("<p>"+aviso+"</p>");
                setTimeout(function(){
                    $("#modal-win-alert").css("display", "none");
                    $("#modal-win-alert .modal-header").removeClass("modal-header-alert");
                    $("#modal-win-alert .modal-header").removeClass("modal-header-warning");
                }, 3000);

}

function cerrarnormalspinnervacio(){
                    $("#modal-win-alert").css("display", "none");
                    $("#modal-win-alert .modal-header").removeClass("modal-header-alert");
                    $("#modal-win-alert .modal-header").removeClass("modal-header-warning");

}

function cerrarerrorspinner(aviso){

  $("#modal-win-alert .modal-header").addClass("modal-header-alert");
                $("#modal-win-alert .modal-header h2").html("Error");
                $("#modal-win-alert .close").html("<i class='fa fa-exclamation-circle'></i>");
                $("#modal-win-alert .modal-body").html("<p>"+aviso+"</p>");
                $("#modal-win-alert").css("display", "block");
                setTimeout(function(){
                    $("#modal-win-alert").css("display", "none");
                    $("#modal-win-alert .modal-header").removeClass("modal-header-alert");
                    $("#modal-win-alert .modal-header").removeClass("modal-header-warning");
                }, 3000);
}
 
function validacaptura(user){

    inicispinnerVacio();
        
      


       var fechainicio = $.datepicker.formatDate("d/m/yy", new Date(today));
       var inputCentral = $( "#inputCentral" ).val();
       var inputOrden = $( "#inputOrden" ).val();
       
        




        $.ajax({
           url: 'validaFormaCapturadaDam',
           type: 'POST',
           data: {fechainicio:fechainicio,inputCentral:inputCentral,inputOrden:inputOrden},
           error: function() {
            
           
            cerrarerrorspinner("Ocurrio un error al tratar de consultar los niveles.");

           },
           success: function(data) {
               
               
               
            
                if (Number(data)>0) {
                  
                  cerrarnormalspinner("Ya se capturaron los niveles de este día");
                  if($("#empid").val()==14 || $("#empid").val()==9){
                    $("#guardaform").show();
                    $("#cancelarform").show();
                  }else{
                    $("#guardaform").hide();
                    $("#cancelarform").hide();
                  }
                  
                  
                }
                else{
                  
                  cerrarnormalspinnervacio ();

                }

                
           }
        }); 

}






