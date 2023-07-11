<div class="right_col" role="main">
    <div class="">

        <button type="button" class="btn btn-lg btn-default" id="verinicio">
            <span class="glyphicon glyphicon-home"></span> Inicio
        </button>
        <button type="button" class="btn btn-lg btn-default" id="nuevaoferta" data-toggle="modal"
            data-target="#nuevaOferta">
            <span class="glyphicon glyphicon-pencil"></span> Nueva Oferta
        </button>
        <button type="button" class="btn btn-lg btn-default" id="nuevatarifa" data-toggle="modal"
    data-target="#nuevaTarifa">
    <span class="glyphicon glyphicon-pencil"></span> Subir Tarifa
</button>
        <?php
            if ($vMenu["render"]) {
                $this->load->view("main/vMenu", $vMenu["data"]);
            }
            ?>

    </div>
    <input id="empid" name="empid" type="hidden" value="<?php echo $userData["employee_id"]; ?>">
    <form class="form-inline" id="filter-form">
        <div class="form-group">
            <label for="nombreCliente">Nombre del cliente:</label>
            <input type="text" class="form-control" id="nombreCliente" name="nombreCliente">
        </div>
        <div class="form-group">
            <label for="nombreCliente">Folio:</label>
            <input type="text" class="form-control" id="nombreCliente" name="nombreCliente">
        </div>
        <button type="button" class="btn btn-lg btn-default" id="filtro" data-toggle="modal-filtro"
            data-target="#Filtro-m">
            <span class="glyphicon glyphicon-search"></span> FILTRO
        </button>

    </form>


    <?php
        define('MAX_ITEMS_PER_PAGE', 3);

        $clientes = array();
        foreach ($deals as $deal) {
            $cliente = $deal['cliente'];
            if (!array_key_exists($cliente, $clientes)) {
                $clientes[$cliente] = array();
            }
            $clientes[$cliente][] = $deal;
        }

        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $total_items = count($clientes);
        $total_pages = ceil($total_items / MAX_ITEMS_PER_PAGE);
        $start_index = ($page - 1) * MAX_ITEMS_PER_PAGE;
        $clientes_subset = array_slice($clientes, $start_index, MAX_ITEMS_PER_PAGE);
    ?>
    <?php foreach ($clientes_subset as $cliente => $deals): ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <a data-toggle="collapse" href="#collapse-<?php echo str_replace(' ', '', $cliente); ?>">
                <?php echo $cliente; ?>
            </a>
        </div>
        <div id="collapse-<?php echo str_replace(' ', '', $cliente); ?>" class="panel-collapse collapse">
            <div class="panel-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Estado</th>
                            <th>Paso</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($deals as $deal): ?>
                        <tr>
                            <td><?php echo $deal['fol']; ?></td>
                            <td><?php echo $deal['estado']; ?></td>
                            <td><?php echo $deal['paso']; ?></td>
                            <td>
                                <button type="button" class="btn btn-lg btn-default"
                                    onclick="viewDeal(<?php echo $deal['ofertaId']; ?>)">
                                    <span class="glyphicon glyphicon-eye-open"></span>
                                </button>
                                <button type="button" class="btn btn-lg btn-default"
                                    onclick="removeDeal(<?php echo $deal['ofertaId']; ?>)">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endforeach; 
    ?>
    <?php if ($total_pages > 1): ?>
    <nav aria-label="Navegación de paginación">
        <ul class="pagination justify-content-center">
            <?php if ($total_pages > 1): ?>
            <li class="page-item">
                <?php if ($page > 1): ?>
                <a class="page-link" href="?page=<?php echo $page - 1; ?>">Anterior</a>
                <?php endif; ?>
            </li>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?php if ($i === $page) echo 'active'; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
            <?php endfor; ?>
            <li class="page-item">
                <?php if ($page < $total_pages): ?>
                <a class="page-link" href="?page=<?php echo $page + 1; ?>">Siguiente</a>
                <?php endif; ?>
            </li>
            <?php endif; ?>
        </ul>
    </nav>
    <?php endif; ?>
</div>

<div class="modal fade" id="nuevaOferta" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Nueva Oferta</h4>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form>
                        <div class="form-group">
                            <label for="selCliente" class="form-label">Cliente:</label>
                            <select class="form-control custom-select-lg" id="selCliente" name="selCliente"
                                style="width:100%">
                                <?php foreach ($clientsSelects as $cs) {
                                    echo "<option value='" . $cs["clienteId"] . "'>" . $cs["nombre"] . "</option>";
                                } ?>
                            </select>
                            <label for="selTipoOferta" class="form-label">Tipo de Oferta:</label>
                            <select class="form-control custom-select-lg" id="selTipoOferta" name="selTipoOferta"
                                style="width:100%">
                                <option value="SC">Suministro Calificado</option>
                                <option value="CE">Compra de Energía</option>
                                <option value="VE">Venta de Energía</option>
                                <option value="VCEL">Venta de CEL</option>
                                <option value="CCEL">Compra de CEL</option>
                            </select>
                            <label for="selFormatoOferta" class="form-label">Formato de Oferta:</label>
                            <select class="form-control custom-select-lg" id="selFormatoOferta" name="selFormatoOferta"
                                style="width:100%">
                                <option value="F">Formal</option>
                                <option value="X">Excel</option>
                                <option value="P">Presentación</option>
                            </select>
                        </div>
                        <button type="button" id="btnGuardaOferta" class="btn btn-success">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="nuevaTarifa" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Nuevas Tarifas</h4>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="input-group">
                        <label class="input-group-btn">
                            <span class="btn btn-primary btn-file">
                                Archivo <input accept=".xls,.xlsx,.csv" name="btarifas" type="file" class="hidden"
                                    id="btarifas" onchange="updateFileName(this)">
                            </span>
                        </label>
                        <input class="form-control" id="tarifas_captura" readonly="readonly" name="tarifas_captura"
                            type="text" value="">
                    </div>
                    <button type="button" id="subir" class="btn btn-success">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateFileName(input) {
        var fileName = input.value.split("\\").pop();
        document.getElementById("tarifas_captura").value = fileName;
    }
</script>


<style>
#loader {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9999;
}

.loader-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
}

.loader-text {
    font-size: 24px;
    color: white;
}
</style>
<div id="loader">
    <div class="loader-content">
        <span class="loader-text">Cargando...</span>
        <div class="loader-spinner"></div>
    </div>
</div>

<!-- // Modal  oferta
<div class="modal fade" id="nuevaOferta" role="dialog">
    <div class="modal-dialog">

        // Modal content
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Nueva Oferta</h4>
            </div>
            <div class="modal-body">
                <div class="container">

                    <form>
                        //<div class="form-group">
                           // <label for="textNombreOferta">Nombre:</label>
                           // <input type="text" class="form-control" id="txtNombreOferta" name="txtNombreOferta">
                       // </div> 
                        <div class="form-group">
                            <label for="selCliente" class="form-label">Cliente:</label>
                            <select class="form-select" id="selCliente" name="selCliente">
                                <?php foreach ($clientsSelects as $cs) {
                                    echo "<option value='" . $cs["clienteId"] . "'>" . $cs["nombre"] . "</option>";
                                } ?>
                            </select>
                            <label for="selTipoOferta" class="form-label">Tipo de Oferta:</label>
                            <select class="form-select" id="selTipoOferta" name="selTipoOferta" disabled>
                                <option value="SC">Suministro Calificado</option>
                                <option value="CE">Compra de Energía</option>
                                <option value="VE">Venta de Energía</option>
                                <option value="VCEL">Venta de CEL</option>
                                <option value="CCEL">Compra de CEL</option>
                            </select>
                            <label for="selFormatoOferta" class="form-label">Formato de Oferta:</label>
                            <select class="form-select" id="selFormatoOferta" name="selFormatoOferta" disabled >
                                <option value="F">Formal</option>
                                <option value="X">Excel</option>
                                <option value="P">Presentación</option>
                            </select>
                        </div>
                        <button type="button" id="btnGuardaOferta" class="btn btn-success">Guardar</button>
                    </form>
                </div>
            </div>
            //<div class="modal-footer">
         // <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
       // </div>
        </div>
    </div>
</div> -->