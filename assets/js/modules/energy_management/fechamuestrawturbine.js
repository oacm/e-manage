
var nowDate = new Date();
var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
var todaymax = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);

var dateOffset = (24*60*60*1000) * 1; 
today.setTime(today.getTime()-1);




$(function() {
  $('input[name="fechas"]').daterangepicker({
    
    minDate: today,
    maxDate: todaymax,
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








