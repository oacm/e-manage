/*        const stepButtons = document.querySelectorAll('.step-button');
        const progress = document.querySelector('#progress');

        Array.from(stepButtons).forEach((button,index) => {
            button.addEventListener('click', () => {
                progress.setAttribute('value', index * 100 /(stepButtons.length - 1) );//there are 3 buttons. 2 spaces.

                stepButtons.forEach((item, secindex)=>{
                    if(index > secindex){
                        item.classList.add('done');
                    }
                    if(index < secindex){
                        item.classList.remove('done');
                    }
                });
            });
        });*/

        $(document).ready(function () {
            var findPaso = $('#findPasoValue').data('findpaso');
            habilitaPasos(findPaso);
        });
        
        
        
        $(document).on('change', '.btn-file :file', function () {
            var input = $(this);
            var numFiles = input.get(0).files ? input.get(0).files.length : 1;
            var label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [numFiles, label]);
        });
        $(document).ready(function () {
            $('.btn-file :file').on('fileselect', function (event, numFiles, label) {
                var input = $(this).parents('.input-group').find(':text');
                var log = numFiles > 1 ? numFiles + ' files selected' : label;
                if (input.length) { input.val(log); } else { if (log) alert(log); }
            });
        });
        
        $("#paso1").click(function (event) {
            if (confirm("¿Seguro que quiere ir al paso 2?")) {
                var ofertaId = $("#ofertaId").val();
                $.ajax({
                    url: 'paso1',
                    type: 'POST',
                    data: { ofertaId: ofertaId },
                    error: function () {
                        alert("Ocurrió un error al tratar de ir al paso 2.");
                    },
                    success: function (data) {
                        res = JSON.parse(data);
                        if (res.status == "success") {
                            const stepButtons = document.querySelectorAll('.step-button');
                            const progress = document.querySelector('#progress');
                            progress.setAttribute('value', 1 * 100 / (stepButtons.length - 1));
                            stepButtons.forEach((item, secindex) => {
                                if (1 > secindex) {
                                    item.classList.add('done');
                                    habilitaPasos(1);
                                }
                            });
                        } else {
                            alert("Ocurrió un error al tratar de ir al paso 2");
                        }
                    }
                });
            }
        });
        
        
        
        $("#paso2").click(function (event) {
            if (confirm("¿Seguro que quiere ir al paso 3?")) {
                var ofertaId = $("#ofertaId").val();
                $.ajax({
                    url: 'paso2',
                    type: 'POST',
                    data: { ofertaId: ofertaId },
                    error: function () {
                        alert("Ocurrió un error al tratar de ir al paso 3.");
                    },
                    success: function (data) {
                        res = JSON.parse(data);
                        if (res.status == "success") {
                            const stepButtons = document.querySelectorAll('.step-button');
                            const progress = document.querySelector('#progress');
                            progress.setAttribute('value', 2 * 100 / (stepButtons.length - 1));
                            stepButtons.forEach((item, secindex) => {
                                if (2 > secindex) {
                                    item.classList.add('done');
                                    habilitaPasos(2);
                                }
                        
                            });
                        } else {
                            alert("Ocurrió un error al tratar de ir al paso 2");
                        }
                    }
                });
            }
        });
        
        $("#paso3").click(function (event) {
            if (confirm("¿Seguro que quiere ir al paso 4?")) {
                var ofertaId = $("#ofertaId").val();
                $.ajax({
                    url: 'paso3',
                    type: 'POST',
                    data: { ofertaId: ofertaId },
                    error: function () {
                        alert("Ocurrió un error al tratar de ir al paso 4.");
                    },
                    success: function (data) {
                        res = JSON.parse(data);
                        if (res.status == "success") {
                            const stepButtons = document.querySelectorAll('.step-button');
                            const progress = document.querySelector('#progress');
                            progress.setAttribute('value', 3 * 100 / (stepButtons.length - 1));
                            stepButtons.forEach((item, secindex) => {
                                if (3 > secindex) {
                                    item.classList.add('done');
                                    habilitaPasos(3);
                                }
                            });
                        } else {
                            alert("Ocurrió un error al tratar de ir al paso 4.");
                        }
                    }
                });
            }
        });
        
        
        $("#paso4").click(function (event) {
            if (confirm("¿Seguro que quiere ir al paso 5?")) {
                var ofertaId = $("#ofertaId").val();
                $.ajax({
                    url: 'paso4',
                    type: 'POST',
                    data: { ofertaId: ofertaId },
                    error: function () {
                        alert("Ocurrió un error al tratar de ir al paso 5.");
                    },
                    success: function (data) {
                        res = JSON.parse(data);
                        if (res.status == "success") {
                            const stepButtons = document.querySelectorAll('.step-button');
                            const progress = document.querySelector('#progress');
                            progress.setAttribute('value', 4 * 100 / (stepButtons.length - 1));
                            stepButtons.forEach((item, secindex) => {
                                if (4 > secindex) {
                                    item.classList.add('done');
                                    habilitaPasos(4);
                                }
                        
                            });
                        } else {
                            alert("Ocurrió un error al tratar de ir al paso 5.");
                        }
                    }
                });
            }
        });
        
        
        $("#paso5").click(function (event) {
            const stepButtons = document.querySelectorAll('.step-button');
            const progress = document.querySelector('#progress');
            progress.setAttribute('value', 5 * 100 / (stepButtons.length - 1));
            stepButtons.forEach((item, secindex) => {
                if (5 > secindex) {
                    item.classList.add('done');
                    habilitaPasos(5);
                }
        
            });
        
        });
        function habilitaPasos(pasoActual) {
            const stepButtons = document.querySelectorAll('.step-button');
            const progress = document.querySelector('#progress');
            progress.setAttribute('value', pasoActual * 100 / (stepButtons.length - 1));
            stepButtons.forEach((item, secindex) => {
                if (pasoActual > secindex) {
                    item.classList.add('done');
        
                }
            });
            if (pasoActual == 0) {
                sb1 = document.getElementById('sb1');
                sb1.disabled = false;
                sb2 = document.getElementById('sb2');
                sb2.disabled = true;
                sb3 = document.getElementById('sb3');
                sb3.disabled = true;
                sb4 = document.getElementById('sb4');
                sb4.disabled = true;
                sb5 = document.getElementById('sb5');
                sb5.disabled = true;
        
                paso1 = document.getElementById('paso1');
                paso1.disabled = false;
                paso2 = document.getElementById('paso2');
                paso2.disabled = true;
                paso3 = document.getElementById('paso3');
                paso3.disabled = true;
                paso4 = document.getElementById('paso4');
                paso4.disabled = true;
                paso5 = document.getElementById('paso5');
                paso5.disabled = true;
        
            }
            if (pasoActual == 1) {
                $('#sb1').addClass('collapsed');
                $('#sb1').attr("aria-expanded", false);
                $('#collapseOne').removeClass('show');
        
                $('#sb2').removeClass('collapsed');
                $('#sb2').attr("aria-expanded", true);
                $('#collapseTwo').addClass('show');
        
                sb1 = document.getElementById('sb1');
                sb1.disabled = false;
                sb2 = document.getElementById('sb2');
                sb2.disabled = false;
                sb3 = document.getElementById('sb3');
                sb3.disabled = true;
                sb4 = document.getElementById('sb4');
                sb4.disabled = true;
                sb5 = document.getElementById('sb5');
                sb5.disabled = true;
        
                paso1 = document.getElementById('paso1');
                paso1.disabled = true;
                paso2 = document.getElementById('paso2');
                paso2.disabled = false;
                paso3 = document.getElementById('paso3');
                paso3.disabled = true;
                paso4 = document.getElementById('paso4');
                paso4.disabled = true;
                paso5 = document.getElementById('paso5');
                paso5.disabled = true;
        
                subir = document.getElementById('subir'); 
                subir.disabled = true;
        
                validar = document.getElementById('validar'); 
                validar.disabled = true;
        
            }
            if (pasoActual == 2) {
                $('#sb1').addClass('collapsed');
                $('#sb1').attr("aria-expanded", false);
                $('#collapseOne').removeClass('show');
        
                $('#sb2').addClass('collapsed');
                $('#sb2').attr("aria-expanded", false);
                $('#collapseTwo').removeClass('show');
        
                $('#sb3').removeClass('collapsed');
                $('#sb3').attr("aria-expanded", true);
                $('#collapseThree').addClass('show');
                sb1 = document.getElementById('sb1');
                sb1.disabled = false;
                sb2 = document.getElementById('sb2');
                sb2.disabled = false;
                sb3 = document.getElementById('sb3');
                sb3.disabled = false;
                sb4 = document.getElementById('sb4');
                sb4.disabled = true;
                sb5 = document.getElementById('sb5');
                sb5.disabled = true;
        
                paso1 = document.getElementById('paso1');
                paso1.disabled = true;
                paso2 = document.getElementById('paso2');
                paso2.disabled = true;
                paso3 = document.getElementById('paso3');
                paso3.disabled = false;
                paso4 = document.getElementById('paso4');
                paso4.disabled = true;
                paso5 = document.getElementById('paso5');
                paso5.disabled = true;
        
                subir = document.getElementById('subir'); 
                subir.disabled = true;
        
                validar = document.getElementById('validar'); 
                validar.disabled = true;
        
                
                guardar = document.getElementById('guardar'); 
                guardar.disabled = true;
        
                validar2 = document.getElementById('validar2'); 
                validar2.disabled = true;
            }
            if (pasoActual == 3) {
                $('#sb1').addClass('collapsed');
                $('#sb1').attr("aria-expanded", false);
                $('#collapseOne').removeClass('show');
        
                $('#sb2').addClass('collapsed');
                $('#sb2').attr("aria-expanded", false);
                $('#collapseTwo').removeClass('show');
        
                $('#sb3').addClass('collapsed');
                $('#sb3').attr("aria-expanded", false);
                $('#collapseThree').removeClass('show');
        
                $('#sb4').removeClass('collapsed');
                $('#sb4').attr("aria-expanded", true);
                $('#collapseFour').addClass('show');
        
        
                sb1 = document.getElementById('sb1');
                sb1.disabled = false;
                sb2 = document.getElementById('sb2');
                sb2.disabled = false;
                sb3 = document.getElementById('sb3');
                sb3.disabled = false;
                sb4 = document.getElementById('sb4');
                sb4.disabled = false;
                sb5 = document.getElementById('sb5');
                sb5.disabled = true;
        
                paso1 = document.getElementById('paso1');
                paso1.disabled = true;
                paso2 = document.getElementById('paso2');
                paso2.disabled = true;
                paso3 = document.getElementById('paso3');
                paso3.disabled = true;
                paso4 = document.getElementById('paso4');
                paso4.disabled = false;
                paso5 = document.getElementById('paso5');
                paso5.disabled = true;
        
        
                subir = document.getElementById('subir'); 
                subir.disabled = true;
        
                validar = document.getElementById('validar'); 
                validar.disabled = true;
        
                
                guardar = document.getElementById('guardar'); 
                guardar.disabled = true;
        
                validar2 = document.getElementById('validar2'); 
                validar2.disabled = true;
        
                guardar2 = document.getElementById('guardar2'); 
                guardar2.disabled = true;
        
                validar3 = document.getElementById('validar3'); 
                validar3.disabled = true;
        
        
            }
            if (pasoActual == 4) {
         
                $('#sb1').addClass('collapsed');
                $('#sb1').attr("aria-expanded", false);
                $('#collapseOne').removeClass('show');
        
                $('#sb2').addClass('collapsed');
                $('#sb2').attr("aria-expanded", false);
                $('#collapseTwo').removeClass('show');
        
                $('#sb3').addClass('collapsed');
                $('#sb3').attr("aria-expanded", false);
                $('#collapseThree').removeClass('show');
        
                $('#sb4').addClass('collapsed');
                $('#sb4').attr("aria-expanded", false);
                $('#collapseFour').removeClass('show');
        
                $('#sb5').removeClass('collapsed');
                $('#sb5').attr("aria-expanded", true);
                $('#collapseFive').addClass('show');
        
                sb1 = document.getElementById('sb1');
                sb1.disabled = false;
                sb2 = document.getElementById('sb2');
                sb2.disabled = false;
                sb3 = document.getElementById('sb3');
                sb3.disabled = false;
                sb4 = document.getElementById('sb4');
                sb4.disabled = false;
                sb5 = document.getElementById('sb5');
                sb5.disabled = false;
        
                paso1 = document.getElementById('paso1');
                paso1.disabled = true;
                paso2 = document.getElementById('paso2');
                paso2.disabled = true;
                paso3 = document.getElementById('paso3');
                paso3.disabled = true;
                paso4 = document.getElementById('paso4');
                paso4.disabled = true;
                paso5 = document.getElementById('paso5');
                paso5.disabled = false;
        
                subir = document.getElementById('subir'); 
                subir.disabled = true;
        
                validar = document.getElementById('validar'); 
                validar.disabled = true;
        
                
                guardar = document.getElementById('guardar'); 
                guardar.disabled = true;
        
                validar2 = document.getElementById('validar2'); 
                validar2.disabled = true;
        
                guardar2 = document.getElementById('guardar2'); 
                guardar2.disabled = true;
        
                validar3 = document.getElementById('validar3'); 
                validar3.disabled = true;
        
                guardar4 = document.getElementById('guardar3'); 
                guardar4.disabled = true;
        
                validar4 = document.getElementById('validar4'); 
                validar4.disabled = true;
        
        
            }
            if (pasoActual == 5) {
                sb1 = document.getElementById('sb1');
                sb1.disabled = false;
                sb2 = document.getElementById('sb2');
                sb2.disabled = false;
                sb3 = document.getElementById('sb3');
                sb3.disabled = false;
                sb4 = document.getElementById('sb4');
                sb4.disabled = false;
                sb5 = document.getElementById('sb5');
                sb5.disabled = false;
        
                paso1 = document.getElementById('paso1');
                paso1.disabled = true;
                paso2 = document.getElementById('paso2');
                paso2.disabled = true;
                paso3 = document.getElementById('paso3');
                paso3.disabled = true;
                paso4 = document.getElementById('paso4');
                paso4.disabled = true;
                paso5 = document.getElementById('paso5');
                paso5.disabled = true;
            }
        
        }

        
        $("#backOfertas").click(function (event) {
            window.location.href = window.location.origin + "/e-manage/module/deal/deals";
        });
        
        
        
        $("#subir").click(function (event) {
            var preciosFile = $("#bprecios")[0].files[0];
            var tarifasFile = $("#btarifas")[0].files[0];
            var horariosFile = $("#bdatoshorarios")[0].files[0];
            var generadorFile = $("#bgenerador")[0].files[0];
            var ofertaId = $("#ofertaId").val();
        
        
            if (!preciosFile && !tarifasFile && !horariosFile && !generadorFile) {
                alert("Debe seleccionar los archivos.");
                return;
            }
        
            var confirmar = confirm("¿Está seguro de subir los archivos?");
        
            if (confirmar) {
                // window.location.href = window.location.origin + "/e-manage/module/deal/deals";
                var maxSize = 5 * 1024 * 1024;
                if (preciosFile && preciosFile.size > maxSize) {
                    alert("El archivo de precios excede el tamaño máximo permitido.");
                    return;
                }
                if (horariosFile && horariosFile.size > maxSize) {
        
                    alert("El archivo de horarios excede el tamaño máximo permitido.");
                    return;
                }
        
                if (tarifasFile && tarifasFile.size > maxSize) {
                    alert("El archivo de tarifas excede el tamaño máximo permitido.");
                    return;
                }
        
                if (generadorFile && generadorFile.size > maxSize) {
                    alert("El archivo de generador excede el tamaño máximo permitido.");
                    return;
                }
        
                var formData = new FormData();
                formData.append('preciosFile', preciosFile);
                formData.append('tarifasFile', tarifasFile);
                formData.append('horariosFile', horariosFile);
                formData.append('generadorFile', generadorFile);
                formData.append('ofertaId', ofertaId);
                $.ajax({
                    url: 'saveData',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) { 
                        location.reload();          
                    },
                    error: function () {
                        alert("Ocurrió un error al guardar el archivo. Por favor, inténtelo de nuevo más tarde.");
                    }
                });
            }
        });
        
        
        $("#validar").click(function (event) {
            if (confirm("¿seguro que quiere validar el paso 1?") == true) {
                var ofertaId = $("#ofertaId").val();
                $.ajax({
                    url: 'validarSeguimiento',
                    type: 'POST',
                    data: { ofertaId: ofertaId },
                    error: function () {
                        alert("Ocurrio un error al tratar de validar el paso 1.");
                    },
                    success: function (data) {
                        res = JSON.parse(data);
                        if (res.status == "success") {
                            alert("Se valido correctamente.");
                            location.reload();
                        } else {
                            alert("Ocurrio un error al tratar de validar el paso 1.");
                        }
                    }
                });
            }
        });
        
        $("#validar2").click(function (event) {
            if (confirm("¿seguro que quiere validar el paso 2?") == true) {
                var ofertaId = $("#ofertaId").val();
                $.ajax({
                    url: 'validarSeguimiento2',
                    type: 'POST',
                    data: { ofertaId: ofertaId },
                    error: function () {
                        alert("Ocurrio un error al tratar de validar el paso 2.");
                    },
                    success: function (data) {
                        res = JSON.parse(data);
                        if (res.status == "success") {
                            alert("Se valido correctamente.");
                            location.reload();
                        } else {
                            alert("Ocurrio un error al tratar de validar el paso 2.");
                        }
                    }
                });
            }
        });
        
        $("#validar3").click(function (event) {
            if (confirm("¿seguro que quiere validar el paso 3?") == true) {
                var ofertaId = $("#ofertaId").val();
                $.ajax({
                    url: 'validarSeguimiento3',
                    type: 'POST',
                    data: { ofertaId: ofertaId },
                    error: function () {
                        alert("Ocurrio un error al tratar de validar el paso 3.");
                    },
                    success: function (data) {
                        res = JSON.parse(data);
                        if (res.status == "success") {
                            alert("Se valido correctamente.");
                            location.reload();
                        } else {
                            alert("Ocurrio un error al tratar de validar el paso 3.");
                        }
                    }
                });
            }
        });
        
        $("#validar4").click(function (event) {
            if (confirm("¿seguro que quiere validar el paso 4?") == true) {
                var ofertaId = $("#ofertaId").val();
                $.ajax({
                    url: 'validarSeguimiento4',
                    type: 'POST',
                    data: { ofertaId: ofertaId },
                    error: function () {
                        alert("Ocurrio un error al tratar de validar el paso 4.");
                    },
                    success: function (data) {
                        res = JSON.parse(data);
                        if (res.status == "success") {
                            alert("Se valido correctamente.");
                            location.reload();
                        } else {
                            alert("Ocurrio un error al tratar de validar el paso 4.");
                        }
                    }
                });
            }
        });
        
        
        $("#guardar3").click(function (event) {
            var archivo = $("#contrato")[0].files[0];
            var formData = new FormData();
            formData.append("contrato", archivo);
            if (confirm("¿QUIERE SUBIR EL ARCHIVO?") == true) {
            $.ajax({
                url: "/e-manage/application/views/deal/viewDeal.php", 
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    res = JSON.parse(data);
                        if (res.status == "success") {
                            alert("Se guardo correctamente.");
                            location.reload();
                        } else {
                            alert("Ocurrió un error al guardar el archivo.");
                        }
                },
                error: function () {
                    alert("Ocurrió un error al guardar el archivo. Por favor, inténtelo de nuevo más tarde.");
                }
            });
        }
        });
        
        
        $("#generar").click(function(event){
            var selTarifa = $( "#selTarifa" ).val();
            var selDivision = $( "#selDivision" ).val();
            var txtD = $( "#txtD" ).val();
            var ofertaId = $( "#ofertaId" ).val();
            var selZC = $( "#selZC" ).val();
            var perfil = $( "#selPerfil" ).val();
            var anio1=$( "#txtTAnio1" ).val();
            var mes1=$( "#txtTMes1" ).val();
            var recibo1=$( "#txtTTarifa1" ).val();
            var anio2=$( "#txtTAnio2" ).val();
            var mes2=$( "#txtTMes2" ).val();
            var recibo2=$( "#txtTTarifa2" ).val();
            var anio3=$( "#txtTAnio3" ).val();
            var mes3=$( "#txtTMes3" ).val();
            var recibo3=$( "#txtTTarifa3" ).val();
            var anio4=$( "#txtTAnio4" ).val();
            var mes4=$( "#txtTMes4" ).val();
            var recibo4=$( "#txtTTarifa4" ).val();
            var anio5=$( "#txtTAnio5" ).val();
            var mes5=$( "#txtTMes5" ).val();
            var recibo5=$( "#txtTTarifa5" ).val();
            var anio6=$( "#txtTAnio6" ).val();
            var mes6=$( "#txtTMes6" ).val();
            var recibo6=$( "#txtTTarifa6" ).val();
            var anio7=$( "#txtTAnio7" ).val();
            var mes7=$( "#txtTMes7" ).val();
            var recibo7=$( "#txtTTarifa7" ).val();
            var anio8=$( "#txtTAnio8" ).val();
            var mes8=$( "#txtTMes8" ).val();
            var recibo8=$( "#txtTTarifa8" ).val();
            var anio9=$( "#txtTAnio9" ).val();
            var mes9=$( "#txtTMes9" ).val();
            var recibo9=$( "#txtTTarifa9" ).val();
            var anio10=$( "#txtTAnio10" ).val();
            var mes10=$( "#txtTMes10" ).val();
            var recibo10=$( "#txtTTarifa10" ).val();
            var anio11=$( "#txtTAnio11" ).val();
            var mes11=$( "#txtTMes11" ).val();
            var recibo11=$( "#txtTTarifa11" ).val();
            var anio12=$( "#txtTAnio12" ).val();
            var mes12=$( "#txtTMes12" ).val();
            var recibo12=$( "#txtTTarifa12" ).val();

            var energia=$( "#txtEnergia" ).val();
            var potencia=$( "#txtPotencia" ).val();
            var cel=$( "#txtCel" ).val();
            var fee=$( "#txtFee" ).val();
            var reqcel1=$( "#txtPorcentajeReqCel1" ).val();
            var reqcel2=$( "#txtPorcentajeReqCel2" ).val();
            var reqcel3=$( "#txtPorcentajeReqCel3" ).val();
            var reqcel4=$( "#txtPorcentajeReqCel4" ).val();
            var reqcel5=$( "#txtPorcentajeReqCel5" ).val();
            var reqcel6=$( "#txtPorcentajeReqCel6" ).val();
            var reqcel7=$( "#txtPorcentajeReqCel7" ).val();
            var reqcel8=$( "#txtPorcentajeReqCel8" ).val();
            var reqcel9=$( "#txtPorcentajeReqCel9" ).val();
            var reqcel10=$( "#txtPorcentajeReqCel10" ).val();
            var reqcel11=$( "#txtPorcentajeReqCel11" ).val();
            var reqcel12=$( "#txtPorcentajeReqCel12" ).val();
            
            
            
            if (selDivision == 0 || txtD == "" || selZC == 0 || perfil == 0){
                alert("Debe llenar todos los datos para poder generar.");
                return;
            }
            $.ajax({
                url: 'generar',
                type: 'POST',
                data: {selTarifa:selTarifa, selDivision:selDivision, txtD:txtD, 
                    ofertaId:ofertaId, selZC:selZC, perfil:perfil, anio1:anio1, mes1:mes1, recibo1:recibo1, 
                    anio2:anio2, mes2:mes2, recibo2:recibo2, anio3:anio3, mes3:mes3, recibo3:recibo3, anio4:anio4,
                     mes4:mes4, recibo4:recibo4, anio5:anio5, mes5:mes5, recibo5:recibo5, anio6:anio6, mes6:mes6, 
                     recibo6:recibo6, anio7:anio7, mes7:mes7, recibo7:recibo7, anio8:anio8, mes8:mes8, recibo8:recibo8, 
                     anio9:anio9, mes9:mes9, recibo9:recibo9, anio10:anio10, mes10:mes10, recibo10:recibo10, anio11:anio11, 
                     mes11:mes11, recibo11:recibo11, anio12:anio12, mes12:mes12, recibo12:recibo12, 
                     energia:energia, potencia:potencia, cel:cel, fee:fee, reqcel1:reqcel1,reqcel2:reqcel2,reqcel3:reqcel3,
                     reqcel4:reqcel4,reqcel5:reqcel5,reqcel6:reqcel6,reqcel7:reqcel7,reqcel8:reqcel8,reqcel9:reqcel9,reqcel10:reqcel10,
                     reqcel11:reqcel11,reqcel12:reqcel12},
                error: function() {
                    alert("Ocurrio un error al tratar de Generar");
                },
                success: function(data) {
                    res=JSON.parse(data);
                    if (res.status == "success"){
                        //mostramos la tabla y la grafica con los resultados.
                        console.log("");
                        console.log(res);
                    }else{
                        alert("Ocurrio un error al generar, intente nuevamente.");
                    }
                   
                }
            });
         });
        
         $("#selDivision").change(function(event){
            $.ajax({
                url: 'getZonasCarga',
                type: 'POST',
                data: {division:$(this).val()},
                error: function() {
                    alert("Ocurrio un error al las zonas de carga");
                },
                success: function(data) {
                    res=JSON.parse(data);
                    if (res.status == "success"){
                        stroptionsZC="";
                        stroptionsZC+="<option value=0>Seleccione una zona de carga...</option>";
                        res.data.forEach(function(item,index){
                            //console.log(item.zona_carga);
                            stroptionsZC+="<option value='"+item.of_zonas_carga_id+"'>"+item.zona_carga+"</option>";
                        })
                        $("#selZC").html(stroptionsZC);
                        //console.log(res);
                    }else{
                        alert("Ocurrio un error al traer las zonas de carga, intente nuevamente.");
                    }
                   
                }
            });
         });
          
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        