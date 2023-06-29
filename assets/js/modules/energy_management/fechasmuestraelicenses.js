var nowDate = new Date();
var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
var todaymax = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);

var dateOffset = (24*60*60*1000) * 1; 
today.setTime(today.getTime()-1);


$(function() {
  $('input[name="fechasin"]').daterangepicker({
    
    timePicker: true,
    timePicker24Hour: true,
    minDate: todaymax,
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
    minDate: todaymax,
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
  $('input[name="fechasinbus"]').daterangepicker({
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
  $('input[name="fechasfinbus"]').daterangepicker({
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


