var resultdata;
var cambiafecha;
var iniciohistorico = 0;

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
buscarango();

$("#guardaform").click(function(event){
    if ($("#inputCentral" ).val() != 0){inicispinner("Guardando");}
    hot.validateCells(function(valid) {
    if (valid) {

        var fechainicio  = $( "#fechainicio" ).val();
        var fechafin     = $( "#fechafin" ).val();
        var inputCentral = $( "#inputCentral" ).val();
        var inputOrden   = $( "#inputOrden" ).val();
        var actualizar   = 0;
        
        $.ajax({
            url: 'saveFormasSorder',
            type: 'POST',
            dataType: 'json',
            data: {datExcel: getSourceDataExcel, totDatExcel: totgetSourceData,headerExcel:getHeadersDataExcel,fechainicio:fechainicio,fechafin:fechafin,inputCentral:inputCentral,inputOrden:inputOrden,arrayrelunit:arrayrelunit,actualizar:actualizar},
            error: function() {
                cerrarerrorspinner("Ocurrio un error Comunicate con el Administrador");
            },
            success: function(data) {

                if(data.error){
                    cerrarerrorspinner("Ocurrio un Error en el Sistema <br> Comuniquese con el Admin");
                    return;
                }

                switch(data.response){
                    case 0:
                        cerrarerrorspinner("La Oferta de Venta Guardada<br><ul><li>No se envio OV al CENACE</li><li>No se crearón archivos de OV</li></ul>");
                        break;
                    case 1:
                        cerrarnormalspinner("Oferta de Venta Generada Correctamente");
                        limpiartotales();
                        break;
                    case 2:
                        cerrarerrorspinner("La Oferta de Venta Guardada<br>No se envio OV al CENACE");
                        limpiartotales();
                        setTimeout(function(){
                            window.location = "downloadZipFile/?f=" + data.zip;
                        }, 3000);                        
                        break;
                    default:
                        cerrarerrorspinner("");
                }
                
                buscarango();
            }
        });
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
   var fechafin = $( "#fechainicio" ).val();
   var inputCentral = $( "#inputCentral" ).val();
   var inputOrden = $( "#inputOrden" ).val();
   var actualizar = 1;



    $.ajax({
        url: 'saveFormasSorder',
       type: 'POST',
       data: {datExcel: getSourceDataExcel, totDatExcel: totgetSourceData,headerExcel:getHeadersDataExcel,fechainicio:fechainicio,fechafin:fechafin,inputCentral:inputCentral,inputOrden:inputOrden,arrayrelunit:arrayrelunit,actualizar:actualizar},
       error: function() {


        cerrarerrorspinner("Ocurrio un error al tratar de Actualizar la Orden ");
       },
       success: function(data) {


            cerrarnormalspinner("Orden procesada correctamente"); 
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

      if (iniciohistorico == 0) {
if (typeof hot === "undefined"){}else{hot.destroy();}
buscarango();


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

}
  else{
    
    if (typeof hot === "undefined"){}else{hot.destroy();}
    construirtabla();
    
$("#tablaexcelo").show();
if ($("#inputCentral" ).val() != 0) 
      {
        inicispinner("Buscando");
      }

resultdata = [];
resultdataid = "";
$("#tablaexcelo").show();

$("#guardaform").hide();
  event.preventDefault();






       var fechainicio = $( "#fechainicio" ).val();
       var inputCentral = $( "#inputCentral" ).val();
       var inputOrden = $( "#inputOrden" ).val();



        $.ajax({
           url: 'FormasConsultasSorder',
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
      }
      else{
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

 

      });

$("#inputCentral").change(function(){


if (iniciohistorico == 0) {
if (typeof hot === "undefined"){}else{hot.destroy();}
buscarango();

}
	else{
    
    if (typeof hot === "undefined"){}else{hot.destroy();}
    construirtabla();
    
$("#tablaexcelo").show();
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

  });


$("#verinicio").click(function(){
        $("#bhistoricos").hide();
        $("#actualizaform").hide();
        $("#tablaexcel").show();
        $("#tablaexcelo").show();
        
        $("#guardaform").show();
        $("#feinicio").show();
        $("#febusqueda").hide();
        $("#bloquefecha").show();
        $("#fechainicio").prop( "disabled",true);
        iniciohistorico = 0;
        buscarango();
        limpiartotales();
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

        

    });

$("#verhistorico").click(function(){
        $("#bhistoricos").show();
        $("#tablaexcel").hide();
        $("#guardaform").hide();
        $("#feinicio").hide();
        $("#febusqueda").show();
        $("#bloquefecha").hide();
        $("#fechainicio").prop( "disabled",false);
        $("#tablaexcelo").hide();
         limpiartotales();
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
        iniciohistorico = 1;
        var nowDate = new Date();
        cambiafecha = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
        reiniciacalendario();
    });

$("#buscarexcel").click(function(){

if ($("#inputCentral" ).val() != 0) 
      {
        inicispinner("Buscando");
      }

resultdata = [];
resultdataid = "";
$("#tablaexcelo").show();

$("#guardaform").hide();
  event.preventDefault();






       var fechainicio = $( "#fechainicio" ).val();
       var inputCentral = $( "#inputCentral" ).val();
       var inputOrden = $( "#inputOrden" ).val();



        $.ajax({
           url: 'FormasConsultasSorder',
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
      }
      else{
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


var val = $('#inputCentral').val();


if (val !=0) {

var val = $('#inputCentral > option').length;
  if (val == 1) {

    val=0;
  }
  else{

    //val = ($("#inputCentral").val())-1;
    val = ($("#inputCentral option:selected").index());

  }
//alert(val);
//console.log(centralescodigos);

$("#inputOrden option:selected").val(centralescodigos[val]["id_Ener_account_order"]);

$('#inputOrden option:selected').text(centralescodigos[val]["Ener_account_order"]);








estacionetotales2 = estacionetotales.reduce(function (sushiPeople, person) {
  

  if (person.cat_corp_subsidiary == centralescodigos[val]["cat_corp_subsidiary"]) {
    return sushiPeople.concat(person);
  } else {
    return sushiPeople
  }
}, []);



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

logicaExcel = "hot = new Handsontable(container, {data: data,maxRows:"+estacionetotales2.length+",colWidths: 34,colHeaders: true,rowHeaders: true,height: "+tamaoH+","+rowcabeceras+"rowHeaderWidth: 60,colHeaders: ['01h', '02h', '03h', '04h', '05h', '06h', '07h', '08h', '09h', '10h', '11h', '12h', '13h', '14h', '15h', '16h', '17h', '18h', '19h', '20h', '21h', '22h', '23h', '24h', '25h'],columns: [{data: '1',type: 'numeric',allowEmpty: false},{data: '2',type: 'numeric',allowEmpty: false},{data: '3',type: 'numeric',allowEmpty: false},{data: '4',type: 'numeric',allowEmpty: false},{data: '5',type: 'numeric',allowEmpty:false},{data: '6',type: 'numeric',allowEmpty: false},{data: '7',type: 'numeric',allowEmpty: false},{data: '8',type: 'numeric',allowEmpty: false},{data: '9',type: 'numeric',allowEmpty: false},{data: '10',type: 'numeric',allowEmpty: false},{data: '11',type: 'numeric',allowEmpty: false},{data: '12',type: 'numeric',allowEmpty: false},{data: '13',type: 'numeric',allowEmpty: false},{data: '14',type: 'numeric',allowEmpty: false},{data: '15',type: 'numeric',allowEmpty: false},{data: '16',type: 'numeric',allowEmpty: false},{data: '17',type: 'numeric',allowEmpty: false},{data: '18',type: 'numeric',allowEmpty: false},{data: '19',type: 'numeric',allowEmpty: false},{data: '20',type: 'numeric',allowEmpty: false},{data: '21',type: 'numeric',allowEmpty: false},{data: '22',type: 'numeric',allowEmpty: false},{data: '23',type: 'numeric',allowEmpty: false},{data: '24',type: 'numeric',allowEmpty: false},{data: '25',type: 'numeric',allowEmpty: true}],afterChange: function(src, changes){if(changes !== 'loadData'){var data = this.getDataAtRow(src[0][0]);getSourceDataExcel = hot.getSourceData();totgetSourceData=getSourceDataExcel.length -1;getHeadersDataExcel = hot.getRowHeader();}}});";

construirExcel();


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

                
                if (resultdata[cuentahoras]["Ener_ov_offer_sale_hour"]==1) {

                 iniciaHoras = 0;
                  filaHoras ++;
                }

                hot.setDataAtCell(filaHoras, iniciaHoras, resultdata[cuentahoras]["Ener_ov_offer_sale_value"]);
                
                iniciaHoras++;

                



               }

}

function buscarango(){




construirtabla();


   var inputCentral = $("#inputCentral").val();



 $.ajax({
           url: 'consultaultimosorder',
           type: 'POST',
           data: {inputCentral:inputCentral},
           error: function() {
               
               alert("Ocurrio un error al tratar de consultar los datos");
           },
           success: function(data) {

           

            if (data == -1) {
              
              $("#fechainicio").prop( "disabled",true);
              var nowDate = new Date();
              cambiafecha = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
               
              
               reiniciacalendario();
             

            }
               else{
            $("#fechainicio").val(data);
            $("#fechafin").val(data);
            cambiafecha = data;
              
           $("#fechainicio").prop( "disabled",true);

               ///
               reiniciacalendario();
                 ///
                
                }

           }
        }); 
}

function reiniciacalendario(){
$(function() {
  $('input[name="fechafin"]').daterangepicker({
    
    minDate: cambiafecha,
    startDate:cambiafecha,
    singleDatePicker: true,
    locale: {
                format: 'DD/MM/YYYY',
                "daysOfWeek": [
            "Do",
            "Lu",
            "Ma",
            "Mi",
            "Ju",
            "Vi",
            "Sa"
        ],
        "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Deciembre"
        ]
            }

  });
});
             
  $(function() {
  $('input[name="fechas"]').daterangepicker({
    
    //minDate: cambiafecha,
    startDate:cambiafecha,
    singleDatePicker: true,
    locale: {
                format: 'DD/MM/YYYY',
                "daysOfWeek": [
            "Do",
            "Lu",
            "Ma",
            "Mi",
            "Ju",
            "Vi",
            "Sa"
        ],
        "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Deciembre"
        ]
            }

  });
});


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