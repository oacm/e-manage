<div class="right_col" role="main">
    <div class="">

        <button type="button" class="btn btn-lg btn-default" id="verinicio">
            <span class="glyphicon glyphicon-home"></span> Inicio
        </button>
        <button type="button" class="btn btn-lg btn-default" id="btnnuevocliente" data-toggle="modal"
            data-target="#nuevoCliente">
            <span class="glyphicon glyphicon-pencil"></span> Nuevo Cliente
        </button>
        <button type="button" class="btn btn-lg btn-default" id="btnnuevorpu" data-toggle="modal"
            data-target="#nuevoRPU">
            <span class="glyphicon glyphicon-pencil"></span> Nuevo RPU
        </button>

        <?php
        if ($vMenu["render"]) {
            $this->load->view("main/vMenu", $vMenu["data"]);
        }
        ?>
    </div>
    <input id="empid" name="empid" type="hidden" value="<?php echo $userData["employee_id"]; ?>">
    <br>
    <form class="form-inline" id="filter-form">
        <div class="form-group">
            <label for="nombreCliente">Nombre del cliente:</label>
            <input type="text" class="form-control" id="nombreCliente" name="nombreCliente">
        </div>
        <div class="form-group">
            <label for="nombreCliente">Rpu:</label>
            <input type="text" class="form-control" id="nombreCliente" name="nombreCliente">
        </div>
        <button type="button" class="btn btn-lg btn-default" id="filtro" data-toggle="modal-filtro"
            data-target="#Filtro-m">
            <span class="glyphicon glyphicon-search"></span> FILTRO
        </button>

    </form>
    <div class="row">
        <div id="pending-doc" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?php
        $clientes = $this->mainctrdao->getClientesRPU();
        $totalClientes = count($clientes);
        $porPagina = 5;
        $totalPaginas = ceil($totalClientes / $porPagina);

        if (isset($_GET['pagina']) && $_GET['pagina'] > 0 && $_GET['pagina'] <= $totalPaginas) {
            $paginaActual = $_GET['pagina'];
        } else {
            $paginaActual = 1;
        }

        $inicio = ($paginaActual - 1) * $porPagina;
        $clientesPaginados = array_slice($clientes, $inicio, $porPagina);
        ?>
            <div class="row">
                <div class="col-md-12">
                    <br>

                    <table class="table table-bordered table-striped" style="width: 98%">
                        <thead>
                            <tr>
                                <!-- <th>ID CLIENTE</th> -->
                                <!-- <th>ID RPU</th> -->
                                <th>Nombre</th>
                                <th>RPU</th>
                                <th>Más Datos Rpu</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clientesPaginados as $cliente) { ?>
                            <tr>
                                <!-- <td><?php echo $cliente['clienteId']; ?></td>  -->
                                <!-- <td class="rpuid"><?php echo $cliente['RPUid']; ?></td> -->
                                <td><?php echo $cliente['nombre']; ?></td>
                                <td><?php echo $cliente['rpu']; ?></td>
                                <td>
                                    <button type="button" class="btn btn-lg btn-default" data-toggle="modal"
                                        data-target="#rpuModal<?php echo $cliente['RPUid']; ?>">
                                        <span class="Ver RPU glyphicon glyphicon-eye-open"></span>
                                    </button>

                                    <div class="modal fade" id="rpuModal<?php echo $cliente['RPUid']; ?>" tabindex="-1"
                                        role="dialog" aria-labelledby="rpuModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Dirección:</strong> <?php echo $cliente['direccion']; ?>
                                                    </p>
                                                    <p><strong>División:</strong> <?php echo $cliente['division']; ?>
                                                    </p>
                                                    <p><strong>Demanda contratada:</strong>
                                                        <?php echo $cliente['demandaContratada']; ?></p>
                                                    <p><strong>Demanda máxima:</strong>
                                                        <?php echo $cliente['demandaMaxima']; ?></p>
                                                    <p><strong>Consumo registrado:</strong>
                                                        <?php echo $cliente['consumoRegistrado']; ?></p>
                                                    <p><strong>No. de recibos:</strong>
                                                        <?php echo $cliente['noRecibos']; ?></p>
                                                    <p><strong>Consumo anual:</strong>
                                                        <?php echo $cliente['consumoAnual']; ?></p>
                                                    <p><strong>Demanda requerida:</strong>
                                                        <?php echo $cliente['demandaRequerida']; ?></p>
                                                    <p><strong>Planta:</strong> <?php echo $cliente['planta']; ?></p>
                                                    <p><strong>Razón social:</strong>
                                                        <?php echo $cliente['razonSocialRPU']; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-lg btn-default"
                                        onclick="<?php echo 'removeRPU('.$cliente["RPUid"].')' ?>">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </button>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php if ($totalPaginas > 1) { ?>
                    <nav aria-label="Navegación de paginación">
                        <ul class="pagination justify-content-center">
                            <?php if ($paginaActual != 1) { ?>
                            <li class="page-item">
                                <a class="page-link" href="?pagina=<?php echo $paginaActual - 1; ?>">Anterior</a>
                            </li>
                            <?php } ?>

                            <?php for ($i = 1; $i <= $totalPaginas; $i++) { ?>
                            <li class="page-item <?php echo $i == $paginaActual ? 'active' : ''; ?>">
                                <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                            <?php } ?>

                            <?php if ($paginaActual != $totalPaginas) { ?>
                            <li class="page-item">
                                <a class="page-link" href="?pagina=<?php echo $paginaActual + 1; ?>">Siguiente</a>
                            </li>
                            <?php } ?>
                        </ul>
                    </nav>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <style>
    .table th,
    .table td {
        text-align: center;
        vertical-align: middle;
    }
    </style>
</div>


<!-- Modal  cliente-->
<div class="modal fade" id="nuevoCliente" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Nuevo Cliente</h4>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form>
                        <div class="form-group">
                            <label for="textNombreCliente">Nombre:</label>
                            <input type="text" class="form-control" id="txtNombreCliente" name="textNombreCliente">
                        </div>
                        <div class="form-group">
                            <label for="txtRazonSocial">Razon Social:</label>
                            <input type="text" class="form-control" id="txtRazonSocial" name="txtRazonSocial">
                        </div>
                        <button type="button" id="btnGuardaCliente" class="btn btn-success">Guardar</button>
                    </form>
                </div>
            </div>
            <!--<div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>-->
        </div>

    </div>
</div>


<!-- Modal RPU-->
<div class="modal fade" style="widht: 800px" id="nuevoRPU" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Nuevo RPU</h4>
            </div>
            <div class="modal-body">
                <div class="container mt-3">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="selCliente" class="form-label">Cliente:</label>
                                    <select class="form-control" id="selCliente" name="selCliente">
                                        <?php foreach ($clientsSelects as $cs) {
                                        echo "<option value='" . $cs["clienteId"] . "'>" . $cs["nombre"] . "</option>";
                                    } ?>
                                    </select>
                                    <label for="textRPU">RPU:</label>
                                    <input type="text" class="form-control" id="txtRPU" name="txtRPU">

                                    <label for="txtdireccion">Dirección:</label>
                                    <input type="text" class="form-control" id="txtdireccion" name="txtdireccion">

                                    <label for="txtRZ">Razon Social:</label>
                                    <input type="text" class="form-control" id="txtRZ" name="txtRZ">

                                    <label for="txtPlanta">Planta:</label>
                                    <input type="text" class="form-control" id="txtPlanta" name="txtPlanta">

                                    <label for="txtNR">No. Recibos:</label>
                                    <input type="text" class="form-control" id="txtNR" name="txtNR">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="txtdivisiom">División:</label>
                                    <input type="text" class="form-control" id="txtdivisiom" name="txtdivisiom">

                                    <label for="txtDC">Demanda Contratada:</label>
                                    <input type="text" class="form-control" id="txtDC" placeholder="KWh" name="txtDC">

                                    <label for="txtDM">Demanda Maxima:</label>
                                    <input type="text" class="form-control" id="txtDM" placeholder="KWh" name="txtDM">

                                    <label for="txtCR">Consumo Registrado:</label>
                                    <input type="text" class="form-control" id="txtCR" placeholder="KWh" name="txtCR">

                                    <label for="txtCA">Consumo Anual:</label>
                                    <input type="text" class="form-control" id="txtCA" placeholder="KWh" name="txtCA">

                                    <label for="txtDR">Demanda Requerida:</label>
                                    <input type="text" class="form-control" id="txtDR" placeholder="KWh" name="txtDR">
                                </div>
                            </div>
                        </div>
                        <button type="button" id="btnGuardaRPU" class="btn btn-success">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>