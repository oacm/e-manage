$('#tabladeresultados').DataTable({
        
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        }
    });


buscarTodasElicensesActivas();

    
    var buscarpor = 0;
    //pintaractivos();
        pintarselectunidades();
        $("#bhistoricos").show();
        $("#bpolicencia").show();
        $("#contienebusquedas").show();
        $("#resultadostablas").show();

    $("#guardaform").click(function(event){

    	inicispinner("Procesando");
    	var existevacio = 0;

    	console.log(estacionetotales);

      var licenciascapt = { valoreslic: [] };

      for (var recorre = 0; recorre < estacionetotales.length; recorre++) 
     {
      	

       
      	if ($('#ocul'+estacionetotales[recorre]["Ener_rel_acronym"]+estacionetotales[recorre]["Ener_unit"]).val()==0) 
      	{
      		if ($('#chec'+estacionetotales[recorre]["Ener_rel_acronym"]+estacionetotales[recorre]["Ener_unit"]).prop('checked')) 
      		{
      			

      			 if ($('#numl'+estacionetotales[recorre]["Ener_rel_acronym"]+estacionetotales[recorre]["Ener_unit"]).val().length!=0)	
       			{ 

    			licenciascapt.valoreslic.push({ 
    			"estacion" : estacionetotales[recorre]["id_Ener_station"],
    			"unidad" : estacionetotales[recorre]["id_Ener_unit"],	
		        "fechainicio" : $('#fei'+estacionetotales[recorre]["Ener_rel_acronym"]+estacionetotales[recorre]["Ener_unit"]).val(),
		        "fechafinal"  : $('#fef'+estacionetotales[recorre]["Ener_rel_acronym"]+estacionetotales[recorre]["Ener_unit"]).val(),
		        "licencia"    : $('#numl'+estacionetotales[recorre]["Ener_rel_acronym"]+estacionetotales[recorre]["Ener_unit"]).val(),
		        "procesado"    : "0",
		        "unidadAcron" : estacionetotales[recorre]["Ener_rel_acronym"]+estacionetotales[recorre]["Ener_unit"]
										    });

    			}

    			else
      			{
      			existevacio = 1;
      			break;
      			}
      		}
      	}
      
      
     }

      if (existevacio == 0) {

      $.ajax({
           url: 'saveFormasElicenses',
           type: 'POST',
           data: {dataLicencias: JSON.stringify(licenciascapt)},
           error: function() {
               
               cerrarerrorspinner("Ocurrio un error intentelo de nuevo");
           },
           success: function(data) 
           {

           	var objjson = $.parseJSON(data);

            
           

            switch(objjson[0]) 
            {
						  case 400:
						    cerrarerrorspinner("Sin información para guardar en BD");
						    break;
						  case 0:
						    cerrarnormalspinner("Información Guardada correctamente");
						    limpiarselect();
						    buscarTodasElicensesActivas();
						    break;

						  default:
						    cerrarerrorspinner("El rango de fechas de algunas licencias se cruza con licencias activas");
              		        var objjsonRes = (objjson[1]);

              		        resultadoscruzados(objjsonRes);
              		        buscarTodasElicensesActivas();
              		        
              		        

			}
            
                
                
           }
        }); 


     //alert(JSON.stringify(licenciascapt)); 
 			}

 			else
 			{
 				cerrarerrorspinner("Debe capturar el número de licencia");
 			}
       

    });


$(":checkbox").change(function () 
     {
      //

    

    if ($(this).attr('id')=="allchecval") 
    {
    	
    	

    	for (var recorreuni = 0; recorreuni < estacionetotales.length; recorreuni++) 
		{
			if ($(this).prop('checked')==true) 
       			{
					if (estacionetotales[recorreuni]['Ener_rel_acronym']==$(this).val()) 
					{
						$('#chec'+$(this).val()+estacionetotales[recorreuni]['Ener_unit']).prop('checked', true);
						
						$('#divis'+$(this).val()).css("background-color", "#5cb85c");
						activadesactivaselect($(this).val()+estacionetotales[recorreuni]['Ener_unit'],"0"); 
					}
				}
			else
				{
						$('#chec'+$(this).val()+estacionetotales[recorreuni]['Ener_unit']).prop('checked', false);
						activadesactivaselect($(this).val()+estacionetotales[recorreuni]['Ener_unit'],"0"); 
				}
		}



    }

     else
    {
       
    	activadesactivaselect($(this).val(),"1"); 

       
   	}

     });


$("#verinicio").click(function(){
        $("#bhistoricos").hide();
        $("#bpolicencia").hide();
        $("#contieneunidades").show();
        $("#contienebusquedas").hide();
        $("#resultadostablas").hide();


        


        

        });


$("#verhistorico").click(function(){
        $("#bhistoricos").show();
        $("#bpolicencia").show();
        $("#contieneunidades").hide();
        $("#contienebusquedas").show();
         $("#resultadostablas").show();

    });   





$("#cancelarform").click(function(){
     //location.reload();
     limpiarselect();
	 }); 

$("#cerrarform").click(function(){
   $('#modal-win-info-add-licenses').modal('toggle');
     
	 }); 


$("#registrarbtn").click(function(){
     //location.reload();
     limpiarselect();
	 }); 


$("#buscarunidades").click(function(){
        
        inicispinner("Procesando");
        
	var inputCentralval = $('#inputCentral').val();
	var inputUnidadesval = $('#inputUnidades').val();
	var fechainicioval = $('#fechainicio').val();
	var fechafinval = $('#fechafin').val();
	var optradioval = $('input[name=optradio]:checked').val();
	var numlicinputval = $('#numlicinput').val();


        //$("#tabladeresultados").empty();
        var tableRes = $('#tabladeresultados').DataTable();
        tableRes.clear();
        //$('#tabladeresultados').append('<thead><tr><th>Unidad</th><th>Fecha de Inicio</th><th>Fecha Final</th><th>Núm. Licencia</th><th>Estatus</th><th>Acción</th></tr></thead>');

        $.ajax({
           url: 'buscandoElicenses',
           type: 'POST',
           data: {buscarpor:buscarpor,inputCentralval:inputCentralval,inputUnidadesval:inputUnidadesval,fechainicioval:fechainicioval,fechafinval:fechafinval,optradioval:optradioval,numlicinputval:numlicinputval},
           error: function() {
               
               cerrarerrorspinner("Ocurrio un error en la busqueda.");
           },
           success: function(data) 
           {
            
           
                	
                	var objjson = $.parseJSON(data);
                	if (objjson.length == 0) 
                	{

                	var limpiatabla = $('#tabladeresultados').DataTable();
                    limpiatabla.clear();
                	cerrarnormalspinner("No se encotrarón coincidencias");	

                	
                	}
                	else
                	{
                		creartablaresultados(objjson,tableRes);
                		cerrarnormalspinner("Desplegando datos");
                		
                	}
                	

                 

              	
               
                
           }
        }); 






    }); 




$("#inputCentral").change(function(){ 

	pintarselectunidades();

	}); 


function validaentrada(){




if ($('#numlicinput').val().length != 0)
{

$("#fechainicio").prop('disabled', true);
$("#fechafin").prop('disabled', true);
$("#inputCentral").prop('disabled', true);
$("#inputUnidades").prop('disabled', true);
$("input[name='optradio']").prop('disabled', true);
buscarpor = 1;
}
else
{
$("#fechainicio").prop('disabled', false);
$("#fechafin").prop('disabled', false);
$("#inputCentral").prop('disabled', false);
$("#inputUnidades").prop('disabled', false);
$("input[name='optradio']").prop('disabled', false);
buscarpor = 0;
}
}

function pintarselectunidades()
{

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



$("#inputOrden option:selected").val(centralescodigos[val]["id_Ener_account_order"]);

$('#inputOrden option:selected').text(centralescodigos[val]["Ener_account_order"]);








estacionetotales2 = estacionetotales.reduce(function (sushiPeople, person) {
  

  if (person.id_Ener_station == centralescodigos[val]["id_Ener_station"]) {
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

$('#inputUnidades').empty();
$('#inputUnidades').append('<option value="0">Todas</option>');
for (var unidparse = 0; unidparse < estacionetotales2.length ; unidparse++) {
	var numunidad = unidparse;
	numunidad++;
	$('#inputUnidades').append('<option value="'+numunidad+'">'+estacionetotales2[unidparse]["Ener_rel_acronym"]+'U'+numunidad+'</option>');
}



}
}

function pintaractivos()
{
	$.ajax({
           url: 'muestraElicenses',
           type: 'POST',
           data: {activo:"1"},
           error: function() {
               
               cerrarerrorspinner("Ocurrio un error intentelo de nuevo");
           },
           success: function(data) 
           {
            
           
                	
                	var objjson = $.parseJSON(data);
                	if (objjson.length == 0) 
                	{
                	//cerrarerrorspinner("Ocurrio un error al guardar la información en BD ");	
                	}
                	else
                	{
                		bloquearedicion(objjson);
                		//cerrarnormalspinner("Información Guardada correctamente");
                	}
                	

                 

              	
               
                
           }
        }); 
}


	function resultadoscruzados(unidadescrear)
	{
		
	limpiarselect();

        for (var recorreuni = 0; recorreuni < unidadescrear["valoreslic"].length; recorreuni++) 

        {
        if (unidadescrear["valoreslic"][recorreuni]["procesado"]==1) 
        {
		$('#chec'+unidadescrear["valoreslic"][recorreuni]["unidadAcron"]).prop('checked', true);
  		$('#labchec'+unidadescrear["valoreslic"][recorreuni]["unidadAcron"]).css("color", "black");
  		$('#divis'+unidadescrear["valoreslic"][recorreuni]["unidadAcron"]).show();
  		$('#divis'+unidadescrear["valoreslic"][recorreuni]["unidadAcron"]).css("background-color", "#EDDD21");
  		$('#divis'+unidadescrear["valoreslic"][recorreuni]["unidadAcron"]).css("color", "black");
		$('#fei'+unidadescrear["valoreslic"][recorreuni]["unidadAcron"]).prop('disabled', false);
  		$('#fef'+unidadescrear["valoreslic"][recorreuni]["unidadAcron"]).prop('disabled', false);
  		$('#numl'+unidadescrear["valoreslic"][recorreuni]["unidadAcron"]).prop('disabled', false);
  		$('#numl'+unidadescrear["valoreslic"][recorreuni]["unidadAcron"]).val(unidadescrear["valoreslic"][recorreuni]["licencia"]);
  		$('#fei'+unidadescrear["valoreslic"][recorreuni]["unidadAcron"]).val(unidadescrear["valoreslic"][recorreuni]["fechainicio"]);
  		$('#fef'+unidadescrear["valoreslic"][recorreuni]["unidadAcron"]).val(unidadescrear["valoreslic"][recorreuni]["fechafinal"]);
  		}
  	}

	}


	function creartablaresultados(unidadescrear,tableRes)
	{
		reiniciafechasbusqueda();
		tableRes.clear();
	

		
		for (var recorreuni = 0; recorreuni < unidadescrear.length; recorreuni++) 
		{

        tableRes.row.add( [
            '<input type="hidden" id="inputcl'+unidadescrear[recorreuni]["id_Ener_licenses_unit"]+'" value="'+unidadescrear[recorreuni]["station_id"]+'-'+unidadescrear[recorreuni]["unit_id"]+'"><span id="spanclave'+unidadescrear[recorreuni]["id_Ener_licenses_unit"]+'">'+unidadescrear[recorreuni]["unidades"]+'</span>',
            '<input style="font-size: 13px; padding-left: 2px" class="form-control" type="text" id="feibusq'+unidadescrear[recorreuni]["id_Ener_licenses_unit"]+'" name="fechasinbusact" value="'+unidadescrear[recorreuni]["fechainicio"]+'">',
            '<input style="font-size: 13px; padding-left: 2px" class="form-control" type="text" id="fefinbusq'+unidadescrear[recorreuni]["id_Ener_licenses_unit"]+'" name="fechasfinbusact" value="'+unidadescrear[recorreuni]["fechafin"]+'">',
            unidadescrear[recorreuni]["num_license"],
            tipodestatus(unidadescrear[recorreuni]["active"]),
            '<button onclick="actualizaestaunidad('+unidadescrear[recorreuni]["id_Ener_licenses_unit"]+',\''+unidadescrear[recorreuni]["unidades"]+'\')" class="btn btn-success" id="guadrarform'+unidadescrear[recorreuni]["id_Ener_licenses_unit"]+'">Actualizar</button>'
        ] ).draw( false );

       if (unidadescrear[recorreuni]["active"] == 0 || (comparaFechasActualizar(unidadescrear[recorreuni]["fechainicio"]) == 1 || comparaFechasActualizar(unidadescrear[recorreuni]["fechafin"])== 1)) 
       {
       	$('#feibusq'+unidadescrear[recorreuni]["id_Ener_licenses_unit"]).prop('disabled', true);
       	$('#fefinbusq'+unidadescrear[recorreuni]["id_Ener_licenses_unit"]).prop('disabled', true);
       	$('#numlibusq'+unidadescrear[recorreuni]["id_Ener_licenses_unit"]).prop('disabled', true);
       	$('#guadrarform'+unidadescrear[recorreuni]["id_Ener_licenses_unit"]).css("display", "none");
		
       }



		}

		

	}

function reiniciafechasbusqueda(){

	$(function() {
  $('input[name="fechasinbusact"]').daterangepicker({
    timePicker: true,
    timePicker24Hour: true,
    //minDate: cambiafecha,
    singleDatePicker: true,
    drops: "up",


    locale: {
                format: 'DD/MM/YYYY HH:mm',
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
        ],
        "applyLabel": "Seleccionar",
        "cancelLabel": "Cancelar"
            }

  });
});


$(function() {
  $('input[name="fechasfinbusact"]').daterangepicker({
    timePicker: true,
    timePicker24Hour: true,
    //minDate: cambiafecha,
    singleDatePicker: true,
	drops: "up",

    locale: {
                format: 'DD/MM/YYYY HH:mm',
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
        ],
        "applyLabel": "Seleccionar",
        "cancelLabel": "Cancelar"
            }

  });
});
}

function reiniciafechasselect(){

	$(function() {
  $('input[name="fechasin"]').daterangepicker({
    timePicker: true,
    timePicker24Hour: true,
    //minDate: cambiafecha,
    singleDatePicker: true,
    locale: {
               format: 'DD/MM/YYYY HH:mm',
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
        ],
        "applyLabel": "Seleccionar",
        "cancelLabel": "Cancelar"
            }

  });
});


$(function() {
  $('input[name="fechasfin"]').daterangepicker({
    timePicker: true,
    timePicker24Hour: true,
    //minDate: cambiafecha,
    singleDatePicker: true,
    locale: {
                format: 'DD/MM/YYYY HH:mm',
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
        ],
        "applyLabel": "Seleccionar",
        "cancelLabel": "Cancelar"
            }

  });
});
}
  function bloquearedicion(unidadesbloq){


  	//console.log(unidadesbloq);
  	//alert(unidadesbloq.length);

  	for (var recorreuni = 0; recorreuni < unidadesbloq.length; recorreuni++) {
  		
  		//alert('#chec'+unidadesbloq[recorreuni]["unidades"]);
  		$('#chec'+unidadesbloq[recorreuni]["unidades"]).prop('checked', true);
  		$('#chec'+unidadesbloq[recorreuni]["unidades"]).prop('disabled', true);
  		$('#labchec'+unidadesbloq[recorreuni]["unidades"]).css("color", "gray");
  		$('#divis'+unidadesbloq[recorreuni]["unidades"]).show();
  		$('#divis'+unidadesbloq[recorreuni]["unidades"]).css("background-color", "#EBE8E8");
  		$('#divis'+unidadesbloq[recorreuni]["unidades"]).css("color", "black");
		$('#fei'+unidadesbloq[recorreuni]["unidades"]).prop('disabled', true);
  		$('#fef'+unidadesbloq[recorreuni]["unidades"]).prop('disabled', true);
  		$('#numl'+unidadesbloq[recorreuni]["unidades"]).prop('disabled', true);
  		$('#numl'+unidadesbloq[recorreuni]["unidades"]).val(unidadesbloq[recorreuni]["num_license"]);
  		$('#fei'+unidadesbloq[recorreuni]["unidades"]).val(unidadesbloq[recorreuni]["fechainicio"]);
  		$('#fef'+unidadesbloq[recorreuni]["unidades"]).val(unidadesbloq[recorreuni]["fechafin"]);
  	}

  }  


function actualizaestaunidad(idunidadactualiar,unidadactualiar)
{

inicispinner("Procesando");	
var cadenaunidad = $('#inputcl'+idunidadactualiar).val();

var arraycadenaunidad = cadenaunidad.split("-");

var actualizafei = $('#feibusq'+idunidadactualiar).val();
var actualizafefin = $('#fefinbusq'+idunidadactualiar).val();
var estacionval = arraycadenaunidad[0];
var unidadval = arraycadenaunidad[1];





	$.ajax({
           url: 'ActualizandoFormasElicenses',
           type: 'POST',
           data: {idunidadactualiar:idunidadactualiar,actualizafei:actualizafei,actualizafefin:actualizafefin,estacionval:estacionval,unidadval:unidadval},
           error: function() {
               
               cerrarerrorspinner("Ocurrio un error al tratar de Actualizar");
           },
           success: function(data) 
           {
            
           

            if (data==1) 
                {
                  
                  cerrarnormalspinner("Información actualizada correctamente");
                   //pintaractivos();
                }

                else
                {
                cerrarerrorspinner("El rango de fechas actualizadas se cruza con licencias activas");
                }
                
               
                
           }
        }); 

		
		

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

function activadesactivaselect(thisvalue,centralcorr){



	if ($('#chec'+thisvalue).prop('checked')==true) 
       {
       	
       	$('#fef'+thisvalue).prop('disabled', false);
       	$('#fei'+thisvalue).prop('disabled', false);
       	$('#numl'+thisvalue).prop('disabled', false);
       	$('#divis'+thisvalue).css("background-color", "#5cb85c");
       	$('#divis'+thisvalue).css("color", "white");

       }
       else
       {
       
       	$('#fef'+thisvalue).prop('disabled', true);
       	$('#fei'+thisvalue).prop('disabled', true);
       	$('#numl'+thisvalue).prop('disabled', true);
       	$('#divis'+thisvalue).css("background-color", "#EBE8E8");
       	$('#divis'+thisvalue).css("color", "black");

       	if (centralcorr=="1") {

       		$('input[name=allchecver'+thisvalue.slice(0, 6)+']').prop('checked', false);
       	}
       	

       }

}


function limpiarselect(){
//reiniciafechasselect();
	for (var recorreuni = 0; recorreuni < estacionetotales.length; recorreuni++) 
		{
			
       		
					
		$('#chec'+estacionetotales[recorreuni]['Ener_rel_acronym']+estacionetotales[recorreuni]['Ener_unit']).prop('checked', false);
		$('#numl'+estacionetotales[recorreuni]['Ener_rel_acronym']+estacionetotales[recorreuni]['Ener_unit']).val('');
						
		activadesactivaselect(estacionetotales[recorreuni]['Ener_rel_acronym']+estacionetotales[recorreuni]['Ener_unit'],"1");
						
						
			
		}


}


function comparaFechasActualizar(fechavalidar)
{


var fechadiahoy = stringToDate(fechaservidor,"dd/MM/yyyy","/");


var fechaFormulariovalidar = stringToDate(fechavalidar,"dd/MM/yyyy","/");


if (fechaFormulariovalidar <= fechadiahoy  ) {
  
  return 1;
}
else {
  return 0;
}
}

function stringToDate(_date,_format,_delimiter)
{
            var formatLowerCase=_format.toLowerCase();
            var formatItems=formatLowerCase.split(_delimiter);
            var dateItems=_date.split(_delimiter);
            var monthIndex=formatItems.indexOf("mm");
            var dayIndex=formatItems.indexOf("dd");
            var yearIndex=formatItems.indexOf("yyyy");
            var month=parseInt(dateItems[monthIndex]);
            month-=1;
            var formatedDate = new Date(dateItems[yearIndex],month,dateItems[dayIndex]);
            return formatedDate;
}
function validaentradalicreg(valorinput){
	

var valexpres = $('#'+valorinput).val();

        var expresionver = new RegExp('^[a-zA-Z0-9-_/]+$');

        if (expresionver.test(valexpres)) {
            
        }
        else
        {
        	valexpres = valexpres.slice(0, -1);
        	$('#'+valorinput).val(valexpres);
        	
        }

	return true;
}

function buscarTodasElicensesActivas(){

        
       
        //console.log(centralescodigos);
        
	//var inputCentralval = $('#inputCentral').val();
	//var inputUnidadesval = $('#inputUnidades').val();
	//var fechainicioval = $('#fechainicio').val();
	//var fechafinval = $('#fechafin').val();
	//var optradioval = $('input[name=optradio]:checked').val();
	//var numlicinputval = $('#numlicinput').val();


        //$("#tabladeresultados").empty();
        var tableRes = $('#tabladeresultados').DataTable();
        tableRes.clear();
        //$('#tabladeresultados').append('<thead><tr><th>Unidad</th><th>Fecha de Inicio</th><th>Fecha Final</th><th>Núm. Licencia</th><th>Estatus</th><th>Acción</th></tr></thead>');

        $.ajax({
           url: 'buscandoElicensesActivas',
           type: 'POST',
           data: {buscarpor:JSON.stringify(centralescodigos)},
           error: function() {
               
              var erroru = 0;
           },
           success: function(data) 
           {
            
           
                	
                	var objjson = $.parseJSON(data);
                	if (objjson.length == 0) 
                	{
                		
                	}
                	else
                	{
                		creartablaresultados(objjson,tableRes);
                		
                		
                	}
                	

                 

              	
               
                
           }
        }); 


}



function tipodestatus(estatus)

{
switch(estatus) 
            {
						  case "1":
						    return("Activa");
						    break;
						  case "0":
						    return("Expirada");
						    break;

						  default:
						     
						     return("0");
              		        
              		        

			}

}


