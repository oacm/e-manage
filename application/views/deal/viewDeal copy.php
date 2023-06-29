<div class="right_col" role="main">

    <div class="">

        <button type="button" class="btn btn-lg btn-default" id="backOfertas">
            <span class="glyphicon glyphicon-home"></span> Ofertas
        </button>

        <?php
        if ($vMenu["render"]) {
            $this->load->view("main/vMenu", $vMenu["data"]);

        }
        ?>

    </div>


    <input id="empid" name="empid" type="hidden" value="<?php echo $userData["employee_id"]; ?>">

    <input id="ofertaId" name="ofertaId" type="hidden" value="<?php echo $ofertaId; ?>">

    <div id="findPasoValue" data-findpaso="<?php echo $findPaso; ?>"></div>

    <div id="validarPrecioValue" data-validarPrecio="<?php echo $validarPrecio; ?>"></div>
    <div id="validarTarifaValue" data-validarTarifa="<?php echo $validarTarifa; ?>"></div>
    <div id="validarHorarioValue" data-validarHorario="<?php echo $validarHorario; ?>"></div>
    <div id="validarGeneradorValue" data-validarGenerador="<?php echo $validarGenerador; ?>"></div>
 

    <!-- inicio stepper ///////////////////// -->
    <div class="container">
        <div class="accordion" id="accordionExample">
            <div class="steps">
                <progress id="progress" value=0 max=100></progress>
                <div class="step-item">
                    <button id="sb1" class="step-button text-center" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        1
                    </button>
                    <div class="step-title">
                        Validar Datos
                    </div>
                </div>
                <div class="step-item">
                    <button id="sb2" class="step-button text-center collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        2
                    </button>
                    <div class="step-title">
                        Generar
                    </div>
                </div>
                <div class="step-item">
                    <button id="sb3" class="step-button text-center collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        3
                    </button>
                    <div class="step-title">
                        Oferta
                    </div>
                </div>
                <div class="step-item">
                    <button id="sb4" class="step-button text-center collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        4
                    </button>
                    <div class="step-title">
                        Contratos
                    </div>
                </div>
                <div class="step-item">
                    <button id="sb5" class="step-button text-center collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                        5
                    </button>
                    <div class="step-title">
                        Ejecucion
                    </div>
                </div>
            </div>
            <div class="card">
                <!-- paso uno -->
                <div id="headingOne">

                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                    data-bs-parent="#accordionExample">
                    <div class="card-body">
                       
                            <div class="container px-4 text-left">
                                <div class="row gx-5">
                                    <div class="col">
                                        <div class="p-3">
                                            <?php if ($validarPrecio == 1) { ?>
                                            <input class="form-check-input" type="checkbox" value="" id="chkprecios"
                                                checked disabled>
                                            <?php } else { ?>
                                            <input class="form-check-input" type="checkbox" value="" id="chkprecios">
                                            <?php } ?>
                                            <label class="form-check-label" for="chkprecios">
                                                Precios
                                            </label>
                                            <div class="input-group">
                                                <?php if ($validarPrecio == 1) { ?>
                                                <label class="input-group-btn">
                                                    <span class="btn btn-primary btn-file hidden">
                                                        Archivo <input accept=".xls,.xlsx,.csv" class="hidden"
                                                            name="bprecios" type="file" id="bprecios">
                                                    </span>
                                                </label>
                                                <?php } else { ?>
                                                <label class="input-group-btn">
                                                    <span class="btn btn-primary btn-file">
                                                        Archivo <input accept=".xls,.xlsx,.csv" class="hidden"
                                                            name="bprecios" type="file" id="bprecios">
                                                    </span>
                                                </label>
                                                <?php } ?>
                                                <input class="form-control" id="precios_captura" readonly="readonly"
                                                    name="precios_captura" type="text" value="">
                                            </div>
                                        </div>

                                        <!-- <div class="p-3">

                                        <input class="form-check-input" type="checkbox" value="" id="chkprecios">

                                        <label class="form-check-label" for="chkprecios">
                                            Precios
                                        </label>
                                        <div class="input-group">

                                            <label class="input-group-btn">
                                                <span class="btn btn-primary btn-file">
                                                    Archivo <input accept=".xls,.xlsx,.csv" class="hidden" name="bprecios"
                                                        type="file" id="bprecios">
                                                </span>
                                            </label>

                                            <input class="form-control" id="precios_captura" readonly="readonly"
                                                name="precios_captura" type="text" value="">
                                        </div>
                                    </div> -->

                                    </div>
                                </div>
                                <div class="row gx-5">
                                    <div class="col">
                                        <div class="p-3">
                                            <?php if ($validarTarifa == 1) { ?>
                                            <input class="form-check-input" type="checkbox" value="" id="chktarifas"
                                                checked disabled>
                                            <?php } else { ?>
                                            <input class="form-check-input" type="checkbox" value="" id="chktarifas">
                                            <?php } ?>
                                            <label class="form-check-label" for="chktarifas">
                                                Tarifas
                                            </label>
                                            <div class="input-group">
                                                <?php if ($validarTarifa == 1) { ?>
                                                <label class="input-group-btn">
                                                    <span class="btn btn-primary btn-file hidden">
                                                        Archivo <input accept=".xls,.xlsx,.csv" class="hidden"
                                                            name="btarifas" type="file" id="btarifas">
                                                    </span>
                                                </label>
                                                <?php } else { ?>
                                                <label class="input-group-btn">
                                                    <span class="btn btn-primary btn-file">
                                                        Archivo <input accept=".xls,.xlsx,.csv" class="hidden"
                                                            name="btarifas" type="file" id="btarifas">
                                                    </span>
                                                </label>
                                                <?php } ?>
                                                <input class="form-control" id="tarifa_captura" readonly="readonly"
                                                    name="tarifa_captura" type="text" value="">
                                            </div>
                                        </div>

                                        <!-- <div class="p-3">
                                            <input class="form-check-input" type="checkbox" value="" id="chktarifas">
                                            <label class="form-check-label" for="chktarifas">
                                                Tarifas
                                            </label>
                                            <div class="input-group">
                                                <label class="input-group-btn">
                                                    <span class="btn btn-primary btn-file-t">
                                                        Archivo <input accept=".xls,.xlsx,.csv" class="hidden"
                                                            name="btarifas" type="file" id="btarifas">
                                                    </span>
                                                </label>
                                                <input class="form-control" id="tarifa_captura" readonly="readonly"
                                                    name="tarifa_captura" type="text" value="">
                                            </div>
                                        </div> -->

                                    </div>
                                </div>
                                <div class="row gx-5">
                                    <div class="col">
                                        <div class="p-3">
                                            <?php if ($validarHorario == 1) { ?>
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="chkdatoshorarios" checked disabled>
                                            <?php } else { ?>
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="chkdatoshorarios">
                                            <?php } ?>
                                            <label class="form-check-label" for="chkdatoshorarios">
                                                Datos Horarios
                                            </label>
                                            <div class="input-group">
                                                <?php if ($validarHorario == 1) { ?>
                                                <label class="input-group-btn">
                                                    <span class="btn btn-primary btn-file hidden">
                                                        Archivo <input accept=".xls,.xlsx,.csv" class="hidden"
                                                            name="bdatoshorarios" type="file" id="bdatoshorarios">
                                                    </span>
                                                </label>
                                                <?php } else { ?>
                                                <label class="input-group-btn">
                                                    <span class="btn btn-primary btn-file">
                                                        Archivo <input accept=".xls,.xlsx,.csv" class="hidden"
                                                            name="bdatoshorarios" type="file" id="bdatoshorarios">
                                                    </span>
                                                </label>
                                                <?php } ?>
                                                <input class="form-control" id="datoshorarios_captura"
                                                    readonly="readonly" name="datoshorarios_captura" type="text"
                                                    value="">
                                            </div>
                                        </div>

                                        <!-- <div class="p-3">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="chkdatoshorarios">
                                            <label class="form-check-label" for="chkdatoshorarios">
                                                Datos Horarios
                                            </label>
                                            <div class="input-group">
                                                <label class="input-group-btn">
                                                    <span class="btn btn-primary btn-file-h">
                                                        Archivo <input accept=".xls,.xlsx,.csv" class="hidden"
                                                            name="bdatoshorarios" type="file" id="bdatoshorarios">
                                                    </span>
                                                </label>
                                                <input class="form-control" id="datoshorarios_captura"
                                                    readonly="readonly" name="datoshorarios_captura" type="text"
                                                    value="">
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="row gx-5">
                                    <div class="col">
                                        <div class="p-3">
                                            <?php if ($validarGenerador == 1) { ?>
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="chkgeneradosbloques" checked disabled>
                                            <?php } else { ?>
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="chkgeneradosbloques">
                                            <?php } ?>
                                            <label class="form-check-label" for="chkgeneradosbloques">
                                                Generador de bloques
                                            </label>
                                            <div class="input-group">
                                                <?php if ($validarGenerador == 1) { ?>
                                                <label class="input-group-btn">
                                                    <span class="btn btn-primary btn-file hidden">
                                                        Archivo <input accept=".xls,.xlsx,.csv" class="hidden"
                                                            name="bgenerador" type="file" id="bgenerador">
                                                    </span>
                                                </label>
                                                <?php } else { ?>
                                                <label class="input-group-btn">
                                                    <span class="btn btn-primary btn-file">
                                                        Archivo <input accept=".xls,.xlsx,.csv" class="hidden"
                                                            name="bgenerador" type="file" id="bgenerador">
                                                    </span>
                                                </label>
                                                <?php } ?>
                                                <input class="form-control" id="generador_captura" readonly="readonly"
                                                    name="generador_captura" type="text" value="">
                                            </div>
                                        </div>

                                        <!-- <div class="p-3">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="chkgeneradosbloques">
                                            <label class="form-check-label" for="chkgeneradosbloques">
                                                Generador de bloques
                                            </label>
                                            <div class="input-group">
                                                <label class="input-group-btn">
                                                    <span class="btn btn-primary btn-file-g">
                                                        Archivo <input accept=".xls,.xlsx,.csv" class="hidden"
                                                            name="bgenerador" type="file" id="bgenerador">
                                                    </span>
                                                </label>
                                                <input class="form-control" id="generador_captura" readonly="readonly"
                                                    name="generador_captura" type="text" value="">
                                            </div>
                                        </div> -->

                                    </div>
                                </div>
                            </div>
                            <!-- <button type="button" id="subir" class="btn btn-success ">Guardar</button> -->
                            <button type="submit" id="subir" class="btn btn-success ">Guardar</button>

                            <?php if ($validarBtnValidar == 1 ) { ?>
                            <button type="button" id="validar" class="btn btn-success ">Validar</button>
                            <?php } else { ?>
                            <button type="button" id="validar" class="btn btn-success "
                                style="display: none;">Validar</button>
                            <?php } ?>

                            <?php if ($validarBtnPasoSi == 1 ) { ?>
                            <button type="button" id="paso1" class="btn btn-success ">Siguiente Paso</button>
                            <?php } else { ?>
                            <button type="button" id="paso1" class="btn btn-success " style="display: none;">Siguiente
                                Paso</button>
                            <?php } ?>

                       
                    </div>
                </div>
            </div>
            <div class="card">
                <!-- paso 2 -->
                <div id="headingTwo">

                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="selTarifa" class="form-label">Tarifa:</label>
                                    <select class="form-control" id="selTarifa" name="selTarifa">
                                        <option value='GDMTH'>GDMTH</option>
                                        <option value='DIST'>DIST</option>
                                        <option value='DIT'>DIT</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="selDivision">Division:</label>
                                    <select class="form-control" id="selDivision" name="selDivision">
                                        <option value=0>Seleccione una division...</option>
                                    <?php foreach ($divisionesSelect as $ds) {
                                        echo "<option value='" . $ds["of_divisiones_id"] . "'>" . $ds["division"] . "</option>";
                                    } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    
                                    <label for="txtD">Demanda Contratada:</label>
                                    <input type="text" class="form-control" id="txtD" placeholder="KWh" name="txtD">

                                </div>
                                <div class="form-group">
                                    
                                    <label for="selZC">Zona de Carga:</label>
                                    <select class="form-control" id="selZC" name="selZC">
                                        <option value=0>Seleccione una zona de carga...</option>
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    
                                    <label for="selPerfil" class="form-label">Peril:</label>
                                    <select class="form-control" id="selPerfil" name="selPerfil">
                                        <option value=0>Seleccione un perfil...</option>
                                        <option value='_Base'>Base</option>
                                        <option value='CC'>CC</option>
                                        
                                    </select>

                                </div>
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="txtT1" class="form-label">Tarifas de Recibos (MXN/KWH):</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-1">
                                    <input type="text" class="form-control" id="txtTAnio1" placeholder="Año 1" name="txtTAnio1">
                                    <input type="text" class="form-control" id="txtTMes1" placeholder="Mes 1" name="txtTMes1">
                                    <input type="text" class="form-control" id="txtTTarifa1" placeholder="Tarifa 1" name="txtTTarifa1">
                                    
                            </div>
                            <div class="col-xs-1">
                                    <input type="text" class="form-control" id="txtTAnio2" placeholder="Año 2" name="txtTAnio2">
                                    <input type="text" class="form-control" id="txtTMes2" placeholder="Mes 2" name="txtTMes2">
                                    <input type="text" class="form-control" id="txtTTarifa2" placeholder="Tarifa 2" name="txtTTarifa2">
                                    
                            </div>
                            <div class="col-xs-1">
                                    <input type="text" class="form-control" id="txtTAnio3" placeholder="Año 3" name="txtTAnio3">
                                    <input type="text" class="form-control" id="txtTMes3" placeholder="Mes 3" name="txtTMes3">
                                    <input type="text" class="form-control" id="txtTTarifa3" placeholder="Tarifa 3" name="txtTTarifa3">
                                    
                            </div>
                            <div class="col-xs-1">
                                    <input type="text" class="form-control" id="txtTAnio4" placeholder="Año 4" name="txtTAnio4">
                                    <input type="text" class="form-control" id="txtTMes4" placeholder="Mes 4" name="txtTMes4">
                                    <input type="text" class="form-control" id="txtTTarifa4" placeholder="Tarifa 4" name="txtTTarifa4">
                                    
                            </div>
                            <div class="col-xs-1">
                                    <input type="text" class="form-control" id="txtTAnio5" placeholder="Año 5" name="txtTAnio5">
                                    <input type="text" class="form-control" id="txtTMes5" placeholder="Mes 5" name="txtTMes5">
                                    <input type="text" class="form-control" id="txtTTarifa5" placeholder="Tarifa 5" name="txtTTarifa5">
                                    
                            </div>
                            <div class="col-xs-1">
                                    <input type="text" class="form-control" id="txtTAnio6" placeholder="Año 6" name="txtTAnio6">
                                    <input type="text" class="form-control" id="txtTMes6" placeholder="Mes 6" name="txtTMes6">
                                    <input type="text" class="form-control" id="txtTTarifa6" placeholder="Tarifa 6" name="txtTTarifa6">
                                    
                            </div>
                            <div class="col-xs-1">
                                    <input type="text" class="form-control" id="txtTAnio7" placeholder="Año 7" name="txtTAnio7">
                                    <input type="text" class="form-control" id="txtTMes7" placeholder="Mes 7" name="txtTMes7">
                                    <input type="text" class="form-control" id="txtTTarifa7" placeholder="Tarifa 7" name="txtTTarifa7">
                                    
                            </div>
                            <div class="col-xs-1">
                                    <input type="text" class="form-control" id="txtTAnio8" placeholder="Año 8" name="txtTAnio8">
                                    <input type="text" class="form-control" id="txtTMes8" placeholder="Mes 8" name="txtTMes8">
                                    <input type="text" class="form-control" id="txtTTarifa8" placeholder="Tarifa 8" name="txtTTarifa8">
                                    
                            </div>
                            <div class="col-xs-1">
                                    <input type="text" class="form-control" id="txtTAnio9" placeholder="Año 9" name="txtTAnio9">
                                    <input type="text" class="form-control" id="txtTMes9" placeholder="Mes 9" name="txtTMes9">
                                    <input type="text" class="form-control" id="txtTTarifa9" placeholder="Tarifa 9" name="txtTTarifa9">
                                    
                            </div>
                            <div class="col-xs-1">
                                    <input type="text" class="form-control" id="txtTAnio10" placeholder="Año 10" name="txtTAnio10">
                                    <input type="text" class="form-control" id="txtTMes10" placeholder="Mes 10" name="txtTMes10">
                                    <input type="text" class="form-control" id="txtTTarifa10" placeholder="Tarifa 10" name="txtTTarifa10">
                                    
                            </div>
                            <div class="col-xs-1">
                                    <input type="text" class="form-control" id="txtTAnio11" placeholder="Año 11" name="txtTAnio11">
                                    <input type="text" class="form-control" id="txtTMes11" placeholder="Mes 11" name="txtTMes11">
                                    <input type="text" class="form-control" id="txtTTarifa11" placeholder="Tarifa 11" name="txtTTarifa11">
                                    
                            </div>
                            <div class="col-xs-1">
                                    <input type="text" class="form-control" id="txtTAnio12" placeholder="Año 12" name="txtTAnio12">
                                    <input type="text" class="form-control" id="txtTMes12" placeholder="Mes 12" name="txtTMes12">
                                    <input type="text" class="form-control" id="txtTTarifa12" placeholder="Tarifa 12" name="txtTTarifa12">
                                    
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                </br>
                                <label class="form-label">PRECIOS FIJOS</label>
                                </br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="txtEnergia" class="form-label">Energia:</label>
                                <input type="text" class="form-control" id="txtEnergia" placeholder="MXN/MWh" name="txtEnergia">
                            </div>
                            <div class="col-md-6">
                                <label for="txtPotencia" class="form-label">Potencia:</label>
                                <input type="text" class="form-control" id="txtPotencia" placeholder="MXN/MWh" name="txtPotencia">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="txtCel" class="form-label">CEL:</label>
                                <input type="text" class="form-control" id="txtCel" placeholder="MXN/CEL" name="txtCel">
                            </div>
                            <div class="col-md-6">
                                <label for="txtFee" class="form-label">Fee Intermediacion:</label>
                                <input type="text" class="form-control" id="txtFee" placeholder="" name="txtFee">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="txtCelMxn" class="form-label">CEL:</label>
                                <input type="text" class="form-control" id="txtCelMxn" placeholder="MXN/MWh" name="txtCelMxn">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-1">
                            <label class="form-label">Mes 1</label>
                            </div>
                            <div class="col-xs-1">
                            <label class="form-label">Mes 2</label>
                            </div>
                            <div class="col-xs-1">
                            <label class="form-label">Mes 3</label>
                            </div>
                            <div class="col-xs-1">
                            <label class="form-label">Mes 4</label>
                            </div>
                            <div class="col-xs-1">
                            <label class="form-label">Mes 5</label>
                            </div>
                            <div class="col-xs-1">
                            <label class="form-label">Mes 6</label>
                            </div>
                            <div class="col-xs-1">
                            <label class="form-label">Mes 7</label>
                            </div>
                            <div class="col-xs-1">
                            <label class="form-label">Mes 8</label>
                            </div>
                            <div class="col-xs-1">
                            <label class="form-label">Mes 9</label>
                            </div>
                            <div class="col-xs-1">
                            <label class="form-label">Mes 10</label>
                            </div>
                            <div class="col-xs-1">
                            <label class="form-label">Mes 11</label>
                            </div>
                            <div class="col-xs-1">
                            <label class="form-label">Mes 12</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-1">
                                <input type="text" class="form-control" id="txtPorcentajeReqCel1" placeholder="% Req Cel 1" name="txtPorcentajeReqCel1">
                            </div>
                            <div class="col-xs-1">
                            <input type="text" class="form-control" id="txtPorcentajeReqCel2" placeholder="% Req Cel 2" name="txtPorcentajeReqCel2">
                            </div>
                            <div class="col-xs-1">
                            <input type="text" class="form-control" id="txtPorcentajeReqCel3" placeholder="% Req Cel 3" name="txtPorcentajeReqCel3">
                            </div>
                            <div class="col-xs-1">
                            <input type="text" class="form-control" id="txtPorcentajeReqCel4" placeholder="% Req Cel 4" name="txtPorcentajeReqCel4">
                            </div>
                            <div class="col-xs-1">
                            <input type="text" class="form-control" id="txtPorcentajeReqCel5" placeholder="% Req Cel 5" name="txtPorcentajeReqCel5">
                            </div>
                            <div class="col-xs-1">
                            <input type="text" class="form-control" id="txtPorcentajeReqCel6" placeholder="% Req Cel 6" name="txtPorcentajeReqCel6">
                            </div>
                            <div class="col-xs-1">
                            <input type="text" class="form-control" id="txtPorcentajeReqCel7" placeholder="% Req Cel 7" name="txtPorcentajeReqCel7">
                            </div>
                            <div class="col-xs-1">
                            <input type="text" class="form-control" id="txtPorcentajeReqCel8" placeholder="% Req Cel 8" name="txtPorcentajeReqCel8">
                            </div>
                            <div class="col-xs-1">
                            <input type="text" class="form-control" id="txtPorcentajeReqCel9" placeholder="% Req Cel 9" name="txtPorcentajeReqCel9">
                            </div>
                            <div class="col-xs-1">
                            <input type="text" class="form-control" id="txtPorcentajeReqCel10" placeholder="% Req Cel 10" name="txtPorcentajeReqCel10">
                            </div>
                            <div class="col-xs-1">
                            <input type="text" class="form-control" id="txtPorcentajeReqCel11" placeholder="% Req Cel 11" name="txtPorcentajeReqCel11">
                            </div>
                            <div class="col-xs-1">
                            <input type="text" class="form-control" id="txtPorcentajeReqCel12" placeholder="% Req Cel 12" name="txtPorcentajeReqCel12">
                            </div>
                        </div>
                                </br>
                        <div class="row">
                            <div class="container text-center">
                                <button type="button" id="generar" class="btn btn-success">Generar</button>
                            </div>  
                        </div>  
                        <button type="button" id="guardar" class="btn btn-success">Guardar</button>
                        <button type="button" id="validar2" class="btn btn-success ">Validar</button>
                        <?php if ($validarBtnPasoSi2 == 1 ) { ?>
                        <button type="button" id="paso2" class="btn btn-success">Siguiente Paso</button>
                        <?php } else { ?>
                        <button type="button" id="paso2" class="btn btn-success " style="display: none;">Siguiente
                            Paso</button>
                        <?php } ?>
                        
                    </div>
                    <div class="container text-center">
  
                </div>
            </div>
            <div class="card">
                <!-- paso 3 -->
                <div id="headingThree">

                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                    data-bs-parent="#accordionExample">
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <button type="button" id="excel" class="btn btn-success">Descargar Excel</button>
                                <button type="button" id="word" class="btn btn-success">Descargar word</button>
                            </div>
                            <button type="button" id="guardar2" class="btn btn-success">Guardar</button>
                            <button type="button" id="validar3" class="btn btn-success ">Validar</button>
                            <?php if ($validarBtnPasoSi3 == 1 ) { ?>
                            <button type="button" id="paso3" class="btn btn-success">Siguiente Paso</button>
                            <?php } else { ?>
                            <button type="button" id="paso3" class="btn btn-success " style="display: none;">Siguiente
                                Paso</button>
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card">
                <!-- paso  4-->

                <div id="headingFour">

                </div>
                <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                    data-bs-parent="#accordionExample">
                    <div class="card-body">
                        <form>
                            <div class="p-3">
                                <label class="form-check-label" for="contrado_label">
                                    Contrato
                                </label>
                                <div class="input-group">
                                    <form action="" method="post" enctype="multipart/form-data">
                                        <input accept=".pdf" name="contrato" type="file" id="">
                                        <input type="submit">
                                    </form>
                                </div>
                            </div>

                            <button type="button" id="validar4" class="btn btn-success ">Validar</button>
                            <?php if ($validarBtnPasoSi4 == 1 ) { ?>
                            <button type="button" id="paso4" class="btn btn-success">Siguiente Paso</button>
                            <?php } else { ?>
                            <button type="button" id="paso4" class="btn btn-success " style="display: none;">Siguiente
                                Paso</button>
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </div>

            <?php

            $dir = "../../assets/Contratos";

            $ruta_carga = $dir;

            if(isset($_FILES['contrato']) && $_FILES['contrato']['type'] === 'application/pdf') {
                    
                    move_uploaded_file($_FILES['contrato']['tmp_name'], $ruta_carga);                       
    
                }
            ?>

            <div class="card">
                <!-- paso  5-->
                <div id="headingFive">

                </div>
                <div id="collapseFive" class="collapse" aria-labelledby="headingFive"
                    data-bs-parent="#accordionExample">
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label for="textNombreOferta">Nombre:</label>
                                <input type="text" class="form-control" name="tct">
                            </div>


                            <button type="button" id="paso5" class="btn btn-success">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin stepper  /////////////////////// -->
</div>