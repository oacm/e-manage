


$(function() {
  $('input[name="fechas"]').daterangepicker({
    
    //minDate: cambiafecha,
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







