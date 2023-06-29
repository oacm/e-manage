    var resultdata;
    var resultdataid;
    var editando = 0;


    

    construirtabla();


   if ($( "#inputCentral" ).val() == 0) {



    $("#tablaexcelo").hide();
   } 

   else {

    validacaptura();
   }

    

    var totValHora = [
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
];

limpiartotales();



    $("#guardaform").click(function(event){

      if ($("#inputCentral" ).val() != 0) 
      {
        inicispinner("Guardando");
      }




      
   event.preventDefault();

    hot.validateCells(function(valid) {
                
    if (valid) {
       
       var fechainicio = $( "#fechainicio" ).val();
       var inputCentral = $( "#inputCentral" ).val();
       var inputOrden = $( "#inputOrden" ).val();




        $.ajax({
           url: 'saveFormas',
           type: 'POST',
           data: {datExcel: getSourceDataExcel, totDatExcel: totgetSourceData,fechainicio:fechainicio,inputCentral:inputCentral,inputOrden:inputOrden,arrayrelunit:arrayrelunit,editando:editando},
           error: function() {
              
           
            cerrarerrorspinner("Ocurrio un error al tratar de Guardar la Energía Producida");

           },
           success: function(data) {
               
               
                if (data==0) {
                  

                  cerrarnormalspinner("Solo se puede guardar Energía producida una vez al día");

                }
                else{

                 
                  cerrarnormalspinner ("Energía Producida guardada correctamente");

               //$("#fechainicio").val("/ /");
                hot.clear();
                limpiartotales();

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
            else{

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
                
                

                

    
                /////
               //$("#fechainicio").val("/ /");
                //hot.clear();
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





totValHora = [
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
];

limpiartotales();

  if (editando == 1) {
if ($("#inputCentral" ).val() != 0) 
      {
        inicispinner("Buscando");
      }


resultdata = [];
resultdataid = [];
$("#tablaexcelo").show();
totValHora = [
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
];
limpiartotales();
//hot.clear();

//hot.render();

$("#guardaform").hide();
  event.preventDefault();





       
       var fechainicio = $( "#fechainicio" ).val();
       var inputCentral = $( "#inputCentral" ).val();
       var inputOrden = $( "#inputOrden" ).val();



        $.ajax({
           url: 'FormasConsultas',
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

        
        //if (typeof hot === "undefined"){}else{hot.destroy();}
        construirtabla();



        $("#tablaexcel").show();
        $("#guardaform").show();

      }
      else{


        
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
                
              


               //$("#fechainicio").val("/ /");
                //hot.setDataAtCell(0, 1, 2224552);
                
           }
        }); 
  }
  else{



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





totValHora = [
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
];

limpiartotales();

  if (editando == 1) {
$("#tablaexcel").hide();
$("#tablaexcelo").hide();
$("#guardaform").hide();
$("#actualizaform").hide();
  }
  else{



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
        
        totValHora = [
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
];

        $("#fechainicio").removeAttr("name");
        $("#fechainicio").attr("name", "fechas");
        ejefecha();

        construirtabla();
        limpiartotales();

        
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
        totValHora = [
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
];
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
totValHora = [
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
  [0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0,0, 0, 0, 0, 0],
];
limpiartotales();
//hot.clear();

//hot.render();

$("#guardaform").hide();
  event.preventDefault();





       
       var fechainicio = $( "#fechainicio" ).val();
       var inputCentral = $( "#inputCentral" ).val();
       var inputOrden = $( "#inputOrden" ).val();



        $.ajax({
           url: 'FormasConsultas',
           type: 'POST',
           data: {fechainicio:fechainicio,inputCentral:inputCentral,inputOrden:inputOrden},
           error: function() {
              
            
            cerrarerrorspinner("Ocurrio un error en la busqueda de información");
           },
           success: function(data) {
               
           

               resultdata = JSON.parse(data);
                
                if (resultdata.length == 0) {

                  cerrarnormalspinner("No se encontro información");

        $("#actualizaform").hide();

        
        //if (typeof hot === "undefined"){}else{hot.destroy();}
        construirtabla();



        $("#tablaexcel").show();
        $("#guardaform").show();

      }
      else{


        
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
                
              


               //$("#fechainicio").val("/ /");
                //hot.setDataAtCell(0, 1, 2224552);
                
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
  }
  else{

    //val = ($("#inputCentral").val())-1;

   val = ($("#inputCentral option:selected").index())-1;
 
  
    

  }



$("#inputOrden option:selected").val(centralescodigos[val]["id_Ener_account_order"]);

$('#inputOrden option:selected').text(centralescodigos[val]["Ener_account_order"]);








estacionetotales2 = estacionetotales.reduce(function (sushiPeople, person) {
  

  if (person.cat_corp_subsidiary == centralescodigos[val]["cat_corp_subsidiary"]) {
    return sushiPeople.concat(person);
  } else {
    return sushiPeople
  }
}, []);
//alert(estacionetotales2[0]["cat_corp_subsidiary"]);
//alert(estacionetotales2[0]["cat_corp_subsidiary"]);
//alert("totales"+estacionetotales2.length);
//alert(estacionetotales2[0]["id_Ener_rel_stationunit"]);
//alert(estacionetotales2[0]["Ener_rel_acronym"]);


rowcabeceras = "rowHeaders: [";
cargararray = "var data = [";
for (var totcells = 0; totcells < estacionetotales2.length; totcells++) {
  cargararray = cargararray+"{},"; 
 rowcabeceras = rowcabeceras+"'"+estacionetotales2[totcells]["Ener_rel_acronym"]+estacionetotales2[totcells]["Ener_unit"]+"'";
 if (totcells < estacionetotales2.length - 1) {
        rowcabeceras = rowcabeceras+",";
    }
}

rowcabeceras = rowcabeceras +"],";
cargararray = cargararray+"];";
  
  var tamaoH = 0;
    if (estacionetotales2.length <=3) {
        tamaoH = estacionetotales2.length*38;
    }else{
        tamaoH = estacionetotales2.length*28;
    }



logicaExcel = "hot = new Handsontable(container, {data: data,maxRows:"+estacionetotales2.length+",colWidths: 34,colHeaders: true,rowHeaders: true,height: "+tamaoH+","+rowcabeceras+"rowHeaderWidth: 74,colHeaders: ['01h', '02h', '03h', '04h', '05h', '06h', '07h', '08h', '09h', '10h', '11h', '12h', '13h', '14h', '15h', '16h', '17h', '18h', '19h', '20h', '21h', '22h', '23h', '24h', '25h'],columns: [{data: '1',type: 'numeric',allowEmpty: false},{data: '2',type: 'numeric',allowEmpty: false},{data: '3',type: 'numeric',allowEmpty: false},{data: '4',type: 'numeric',allowEmpty: false},{data: '5',type: 'numeric',allowEmpty:false},{data: '6',type: 'numeric',allowEmpty: false},{data: '7',type: 'numeric',allowEmpty: false},{data: '8',type: 'numeric',allowEmpty: false},{data: '9',type: 'numeric',allowEmpty: false},{data: '10',type: 'numeric',allowEmpty: false},{data: '11',type: 'numeric',allowEmpty: false},{data: '12',type: 'numeric',allowEmpty: false},{data: '13',type: 'numeric',allowEmpty: false},{data: '14',type: 'numeric',allowEmpty: false},{data: '15',type: 'numeric',allowEmpty: false},{data: '16',type: 'numeric',allowEmpty: false},{data: '17',type: 'numeric',allowEmpty: false},{data: '18',type: 'numeric',allowEmpty: false},{data: '19',type: 'numeric',allowEmpty: false},{data: '20',type: 'numeric',allowEmpty: false},{data: '21',type: 'numeric',allowEmpty: false},{data: '22',type: 'numeric',allowEmpty: false},{data: '23',type: 'numeric',allowEmpty: false},{data: '24',type: 'numeric',allowEmpty: false},{data: '25',type: 'numeric',allowEmpty: true}],afterChange: function(src, changes){if(changes !== 'loadData'){var data = this.getDataAtRow(src[0][0]);getSourceDataExcel = hot.getSourceData();totgetSourceData=getSourceDataExcel.length -1;}}});";


construirExcel();

hot.addHook('beforeChange', function(changes, src) {
 
  var ret = true;
  
      if (centralescodigos[val]["id_Ener_station"] == 1){//alameda
        
        if ((changes[0][0]>= 0 || changes[0][0] <= 2) && (changes[0][3] >=0 && changes[0][3] <=3)){
         
          ret = true;
          $('#rangemsg').html("");
        }else{
          
          ret= false;
          $('#rangemsg').html('<p style="color:#258064; font-size: 16px;">El valor debe ser entre 0 y 3</p>');
        }
        
      }
      if (centralescodigos[val]["id_Ener_station"] == 2){//lerma
        if (changes[0][0]>= 0){
          if (changes[0][3] >=0 && changes[0][3] <=25) {
            ret = true;
            $('#rangemsg').html("");
          }else{
            ret= false;
            $('#rangemsg').html('<p style="color:#258064; font-size: 16px;">El valor debe ser entre 0 y 25</p>');
          }
        }
        if (changes[0][0]>= 1){
          if (changes[0][3] >=0 && changes[0][3] <=25) {
            ret = true;
            $('#rangemsg').html("");
          }else{
            ret= false;
            $('#rangemsg').html('<p style="color:#258064; font-size: 16px;">El valor debe ser entre 0 y 25</p>');
          }
        }
        if (changes[0][0]>= 2){
          if (changes[0][3] >=0 && changes[0][3] <=23) {
            ret = true;
            $('#rangemsg').html("");
          }else{
            ret= false;
            $('#rangemsg').html('<p style="color:#258064; font-size: 16px;">El valor debe ser entre 0 y 23</p>');
          }
        }
      }
      if (centralescodigos[val]["id_Ener_station"] == 3){//necaxa
        if (changes[0][0]>= 0){
          if (changes[0][3] >=0 && changes[0][3] <=17) {
            ret = true;
            $('#rangemsg').html("");
          }else{
            ret= false;
            $('#rangemsg').html('<p style="color:#258064; font-size: 16px;">El valor debe ser entre 0 y 17</p>');
          }
        }
        if (changes[0][0]>= 1){
          if (changes[0][3] >=0 && changes[0][3] <=17) {
            ret = true;
            $('#rangemsg').html("");
          }else{
            ret= false;
            $('#rangemsg').html('<p style="color:#258064; font-size: 16px;">El valor debe ser entre 0 y 17</p>');
          }
        }
        if (changes[0][0]>= 2){
          if (changes[0][3] >=0 && changes[0][3] <=9) {
            ret = true;
            $('#rangemsg').html("");
          }else{
            ret= false;
            $('#rangemsg').html('<p style="color:#258064; font-size: 16px;">El valor debe ser entre 0 y 9</p>');
          }
        }
        if (changes[0][0]>= 3){
          if (changes[0][3] >=0 && changes[0][3] <=9) {
            ret = true;
            $('#rangemsg').html("");
          }else{
            ret= false;
            $('#rangemsg').html('<p style="color:#258064; font-size: 16px;">El valor debe ser entre 0 y 9</p>');
          }
        }
        if (changes[0][0]>= 4){
          if (changes[0][3] >=0 && changes[0][3] <=9) {
            ret = true;
            $('#rangemsg').html("");
          }else{
            ret= false;
            $('#rangemsg').html('<p style="color:#258064; font-size: 16px;">El valor debe ser entre 0 y 9</p>');
          }
        }
        if (changes[0][0]>= 5){
          if (changes[0][3] >=0 && changes[0][3] <=8) {
            ret = true;
            $('#rangemsg').html("");
          }else{
            ret= false;
            $('#rangemsg').html('<p style="color:#258064; font-size: 16px;">El valor debe ser entre 0 y 8</p>');
          }
        }
        if (changes[0][0]>= 6){
          if (changes[0][3] >=0 && changes[0][3] <=8) {
            ret = true;
            $('#rangemsg').html("");
          }else{
            ret= false;
            $('#rangemsg').html('<p style="color:#258064; font-size: 16px;">El valor debe ser entre 0 y 8</p>');
          }
        }
        if (changes[0][0]>= 7){
          if (changes[0][3] >=0 && changes[0][3] <=8) {
            ret = true;
            $('#rangemsg').html("");
          }else{
            ret= false;
            $('#rangemsg').html('<p style="color:#258064; font-size: 16px;">El valor debe ser entre 0 y 8</p>');
          }
        }
        if (changes[0][0]>= 8){
          if (changes[0][3] >=0 && changes[0][3] <=17) {
            ret = true;
            $('#rangemsg').html("");
          }else{
            ret= false;
            $('#rangemsg').html('<p style="color:#258064; font-size: 16px;">El valor debe ser entre 0 y 17</p>');
          }
        }
        if (changes[0][0]>= 9){

        }
        
      }
      if (centralescodigos[val]["id_Ener_station"] == 4){//patla
        if (changes[0][0]>= 0){
          if (changes[0][3] >=0 && changes[0][3] <=16) {
            ret = true;
            $('#rangemsg').html("");
          }else{
            ret= false;
            $('#rangemsg').html('<p style="color:#258064; font-size: 16px;">El valor debe ser entre 0 y 16</p>');
          }
        }
        if (changes[0][0]>= 1){
          if (changes[0][3] >=0 && changes[0][3] <=16) {
            ret = true;
            $('#rangemsg').html("");
          }else{
            ret= false;
            $('#rangemsg').html('<p style="color:#258064; font-size: 16px;">El valor debe ser entre 0 y 16</p>');
          }
        }
        if (changes[0][0]>= 2){
          if (changes[0][3] >=0 && changes[0][3] <=16) {
            ret = true;
            $('#rangemsg').html("");
          }else{
            ret= false;
            $('#rangemsg').html('<p style="color:#258064; font-size: 16px;">El valor debe ser entre 0 y 16</p>');
          }
        }
        
      }
      if (centralescodigos[val]["id_Ener_station"] == 5){//tepexic
        if (changes[0][0]>= 0){
          if (changes[0][3] >=0 && changes[0][3] <=16) {
            ret = true;
            $('#rangemsg').html("");
          }else{
            ret= false;
            $('#rangemsg').html('<p style="color:#258064; font-size: 16px;">El valor debe ser entre 0 y 16</p>');
          }
        }
        if (changes[0][0]>= 1){
          if (changes[0][3] >=0 && changes[0][3] <=16) {
            ret = true;
            $('#rangemsg').html("");
          }else{
            ret= false;
            $('#rangemsg').html('<p style="color:#258064; font-size: 16px;">El valor debe ser entre 0 y 16</p>');
          }
        }
        if (changes[0][0]>= 2){
          if (changes[0][3] >=0 && changes[0][3] <=16) {
            ret = true;
            $('#rangemsg').html("");
          }else{
            ret= false;
            $('#rangemsg').html('<p style="color:#258064; font-size: 16px;">El valor debe ser entre 0 y 16</p>');
          }
        }
        
      }
      if (centralescodigos[val]["id_Ener_station"] == 6){//temascaltepec
        
        if (changes[0][0]>= 0){
          if (changes[0][3] >=0 && changes[0][3] <= .4) {
            ret = true;
            $('#rangemsg').html("");
          }else{
            ret= false;
            $('#rangemsg').html('<p style="color:#258064; font-size: 16px;">El valor debe ser entre 0 y .4</p>');
          }
        }
        if (changes[0][0]>= 1){
          if (changes[0][3] >=0 && changes[0][3] <= .4) {
            ret = true;
            $('#rangemsg').html("");
          }else{
            ret= false;
            $('#rangemsg').html('<p style="color:#258064; font-size: 16px;">El valor debe ser entre 0 y .4</p>');
          }
        }
        if (changes[0][0]>= 2){
          if (changes[0][3] >=0 && changes[0][3] <= .4) {
            ret = true;
            $('#rangemsg').html("");
          }else{
            ret= false;
            $('#rangemsg').html('<p style="color:#258064; font-size: 16px;">El valor debe ser entre 0 y .4</p>');
          }
        }
        if (changes[0][0]>= 3){
          if (changes[0][3] >=0 && changes[0][3] <= 1.1) {
            ret = true;
            $('#rangemsg').html("");
          }else{
            ret= false;
            $('#rangemsg').html('<p style="color:#258064; font-size: 16px;">El valor debe ser entre 0 y 1.1</p>');
          }
        }
      }
      return ret;
});

hot.addHook('afterChange', function(changes, src) {
    sumatorias(changes);
  });


hot.addHook('afterPaste', function(data, coords) {
    sumatoriasconcopia(data,coords);
  });




}



} 

function sumatoriasconcopia(data,coords){


var sumandoposrow = 0;
var sumadoposcol = 0;



  
for (var unid = parseInt(coords[0]["startRow"]); unid <= parseInt(coords[0]["endRow"]); unid ++) {
  sumandoposrow = 0;
  
for (var unidhor = parseInt(coords[0]["startCol"]) ; unidhor <= parseInt(coords[0]["endCol"]); unidhor ++) {
  

if (isNaN(parseInt(data[sumadoposcol][sumandoposrow]))) {

totValHora[unid][unidhor]= 0;
}
else{
totValHora[unid][unidhor]= parseFloat(data[sumadoposcol][sumandoposrow]);
}

sumandoposrow++;


  
}
sumadoposcol++;
}



var tamanounidad = totgetSourceData;
var sumavalida = 0;

var centralselec = $( "#inputCentral" ).val();

if (typeof tamanounidad === "undefined" || centralselec == 3 ){
tamanounidad = 9;
}

for (var unidhor = 0 ; unidhor < 25; unidhor ++) {
  sumando = 0;
for (var unid = 0 ; unid <= tamanounidad; unid ++) {

  
  if (isNaN(parseInt(totValHora[unid][unidhor]))) {
    sumavalida = 0;
  }

    else{
      sumavalida = parseFloat(totValHora[unid][unidhor]);
    }
  
sumando = sumando + sumavalida;


}

var totextval = unidhor+1;

 $("#toth"+totextval.toString()).text(parseFloat(sumando).toFixed(2)); 



}


  
}

function sumatorias(data,coords){

  

  var sumando = 0;
  var posa = 0;
  var posb = 0;

  



for (var cuentasuma = 0; cuentasuma < data.length; cuentasuma++) {
  
posa = parseInt(data[cuentasuma][0]);
posb = parseInt(data[cuentasuma][1]) - 1 ;

totValHora[posa][posb]= parseFloat(data[cuentasuma][3]);

}



var sumavalida = 0;
var tamanounidadchg = totgetSourceData;

var centralselechg = $( "#inputCentral" ).val();

if (typeof tamanounidadchg === "undefined" || centralselechg == 3 ){
tamanounidadchg = 9;
}

for (var unidhor = 0 ; unidhor < 25; unidhor ++) {
  sumando = 0;
for (var unid = 0 ; unid <= tamanounidadchg; unid ++) {


  if (isNaN(parseInt(totValHora[unid][unidhor]))) {
    sumavalida = 0;
  }

  else{

    sumavalida = parseFloat(totValHora[unid][unidhor])
  }
  
sumando = sumando + sumavalida;
  
}

var totextvalch = unidhor+1;

 $("#toth"+totextvalch.toString()).text(parseFloat(sumando).toFixed(2)); 

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

function limpiartotales(){

for (var limpiar = 1; limpiar <= 25 ; limpiar++) {
  $("#toth"+limpiar.toString()).text("0");
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
 
function validacaptura(){

    inicispinnerVacio();
        
      


       var fechainicio = $.datepicker.formatDate("d/m/yy", new Date(today));
       var inputCentral = $( "#inputCentral" ).val();
       var inputOrden = $( "#inputOrden" ).val();

        




        $.ajax({
           url: 'validaFormaCapturada',
           type: 'POST',
           data: {fechainicio:fechainicio,inputCentral:inputCentral,inputOrden:inputOrden},
           error: function() {
              
           
            cerrarerrorspinner("Ocurrio un error al tratar de consultar la Energía Producida");

           },
           success: function(data) {
               
               
               

                if (Number(data)==1) {
                  
                  cerrarnormalspinner("Ya se capturo la Energía producida de este día");
                }
                else{
                 
                  cerrarnormalspinnervacio ();

                }

                
           }
        }); 

}




