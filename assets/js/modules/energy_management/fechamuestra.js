
var nowDate = new Date();
var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);

var todaymax = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
var todaymaxdays = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);

var dateOffset = (24*60*60*1000) * 1; 
today.setDate(today.getDate() - 1);

var dateOffsetmaxday = (24*60*60*1000) * 1; 
todaymaxdays.setDate(todaymaxdays.getDate() - 1);




$(function() {
  $('input[name="fechas"]').daterangepicker({
    
    minDate: today,
    maxDate: today,
    startDate:today,
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
  $('input[name="fechasini"]').daterangepicker({
    //minDate: today,
    maxDate: todaymaxdays,
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


function ejefecha(){

    
$(function() {
  $('input[name="fechas"]').daterangepicker({
    
    minDate: today,
    maxDate: today,
    startDate:today,
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




function ejefechasini(){


   $(function() {
  $('input[name="fechasini"]').daterangepicker({
    
    //minDate: today,
    maxDate: todaymaxdays,
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
