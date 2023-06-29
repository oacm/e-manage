var guardaoactualiza=0;

$("#guardaform").click(function(event){


if ($("#inputCentral" ).val() != 0) 
      {
        inicispinner("Guardando");
      }

      
   event.preventDefault();

    
                
    
       
       var fechainicio = $( "#fechainicio" ).val();
       var inputCentral = $( "#inputCentral" ).val();
       var inputValor = $( "#txtNumber" ).val();
       var inputValorMes = $( "#txtNumberMes" ).val();


       



        $.ajax({
           url: 'saveFormasWturbine',
           type: 'POST',
           data: {fechainicio:fechainicio,inputCentral:inputCentral,inputValor:inputValor,guardaoactualiza:guardaoactualiza,inputValorMes:inputValorMes},
           error: function() {
               
               cerrarerrorspinner("Ocurrio un error al tratar de Guardar");
           },
           success: function(data) {
               
                
                cerrarnormalspinner("Valor Agua Turbinada Guardada correctamente");
                

           }
        }); 


    });

$("#cancelarform").click(function(){

$("#txtNumber").val("0.0");


  });

$('#fechainicio').change(function() { 


  if ($("#inputCentral" ).val() != 0) 
      {
        inicispinner("Buscando");
      }

var inputCentral = $( "#inputCentral" ).val();
var fechainicio = $( "#fechainicio" ).val();
$.ajax({
           url: 'consultaFormasWturbine',
           type: 'POST',
           data: {fechainicio:fechainicio,inputCentral:inputCentral},
           error: function() {
              
               cerrarerrorspinner("Ocurrio un error al buscar datos");
           },
           success: function(data) {


            resultdata = JSON.parse(data);

            console.log(resultdata);
              cerrarnormalspinner("Capture el nuevo valor de Agua turbinada");
            if (resultdata[0] == 1) {
              $("#guardaform").html('Guardar');
              $("#txtNumber").val("0.0");
              $("#txtNumberMes").val(resultdata[1]) ;
               
               guardaoactualiza = 0;

            }
               else{
            cerrarnormalspinner("Se encotrarón datos capturados anteriormente");
               $("#guardaform").html('Actualizar');
               $("#txtNumber").val(resultdata[1]) ;
               $("#txtNumberMes").val(resultdata[2]) ;
               guardaoactualiza = 1;
                
                }

           }
        }); 



 });

$('#inputCentral').change(function() {
    // $(this).val() will work here
    $("#txtNumber").val("0.0");
     $("#txtNumberMes").val("0.0");
    $("#fechainicio").val("/ /");


});

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


