<div class="right_col" role="main">
    <div class="">
        
 <button type="button" class="btn btn-lg btn-default" id="verinicio">
      <span class="glyphicon glyphicon-home"></span> Inicio
    </button>
 <button type="button" class="btn btn-lg btn-default" id="verhistorico">
      <span class="glyphicon glyphicon-pencil"></span> Editar
    </button>
        <?php
        if ($vMenu["render"]) {
            $this->load->view("main/vMenu", $vMenu["data"]);
        }
        ?>

    <?php
      $posuserInfoData=count($userInfoData);
      $posuserStationData=count($userStationData);

 $verAdminWC = $userData["AdminWorkCenter"];

  if (count($verAdminWC)>0) {
     $armaexcel = 1;
  }
    else{

    $armaexcel = $userData["WorkCenter"];

    }

$cargararray = "var data = [";
$rowcabeceras = "rowHeaders: [";
    for ($i=0; $i < $posuserStationData; $i++) { 
    $cargararray = $cargararray . "{},";
    $rowcabeceras = $rowcabeceras."'".$userStationData[$i]["Ener_rel_acronym"].$userStationData[$i]["Ener_unit"]."'";
    $arrayrelunit[] = $userStationData[$i]["id_Ener_rel_stationunit"];
    if ($i < $posuserStationData - 1) {
        $rowcabeceras = $rowcabeceras.",";
    }
    }
    $cargararray = $cargararray . "];";
    $rowcabeceras = $rowcabeceras . "],";



?> 

<?php 
    $tamaoH = 0;
    if ($posuserStationData <= 3) {
        $tamaoH = $posuserStationData*38;
    }else{
        $tamaoH = $posuserStationData*28;
    }

$logicaExcel = "hot = new Handsontable(container, {data: data,maxRows:".$posuserStationData.",colWidths: 34,colHeaders: true,rowHeaders: true,height: ".($tamaoH).",".$rowcabeceras."rowHeaderWidth: 74,colHeaders: ['01h', '02h', '03h', '04h', '05h', '06h', '07h', '08h', '09h', '10h', '11h', '12h', '13h', '14h', '15h', '16h', '17h', '18h', '19h', '20h', '21h', '22h', '23h', '24h', '25h'],columns: [{data: '1',type: 'numeric',allowEmpty: false},{data: '2',type: 'numeric',allowEmpty: false},{data: '3',type: 'numeric',allowEmpty: false},{data: '4',type: 'numeric',allowEmpty: false},{data: '5',type: 'numeric',allowEmpty:false},{data: '6',type: 'numeric',allowEmpty: false},{data: '7',type: 'numeric',allowEmpty: false},{data: '8',type: 'numeric',allowEmpty: false},{data: '9',type: 'numeric',allowEmpty: false},{data: '10',type: 'numeric',allowEmpty: false},{data: '11',type: 'numeric',allowEmpty: false},{data: '12',type: 'numeric',allowEmpty: false},{data: '13',type: 'numeric',allowEmpty: false},{data: '14',type: 'numeric',allowEmpty: false},{data: '15',type: 'numeric',allowEmpty: false},{data: '16',type: 'numeric',allowEmpty: false},{data: '17',type: 'numeric',allowEmpty: false},{data: '18',type: 'numeric',allowEmpty: false},{data: '19',type: 'numeric',allowEmpty: false},{data: '20',type: 'numeric',allowEmpty: false},{data: '21',type: 'numeric',allowEmpty: false},{data: '22',type: 'numeric',allowEmpty: false},{data: '23',type: 'numeric',allowEmpty: false},{data: '24',type: 'numeric',allowEmpty: false},{data: '25',type: 'numeric',allowEmpty: true}],afterChange: function(src, changes){if(changes !== 'loadData'){var data = this.getDataAtRow(src[0][0]);getSourceDataExcel = hot.getSourceData();totgetSourceData=getSourceDataExcel.length -1;}}});";


?>
<script type="text/javascript">var armaexcel = "<?php echo $armaexcel ?>";</script>
<script type="text/javascript">var cargararray = "<?php echo $cargararray ?>";</script>
<script type="text/javascript">var logicaExcel = "<?php echo $logicaExcel ?>";</script>
<script type="text/javascript">var arrayrelunit = <?php echo json_encode($arrayrelunit); ?>;</script>
<script type="text/javascript">var centralescodigos = <?php echo json_encode( $userInfoData); ?>;</script>
<script type="text/javascript">var estacionetotales = <?php echo json_encode( $userStationData); ?>;</script>





<div class="row">
            
<div id="pending-doc" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                
                <div class="x_panel">
                    <div class="x_title">
                        <h2>
                            <p>Energía Producida [MWh]</p>
                        </h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         

  <div class="form-row col-md-12">
 <form id="excel-form" action="javascript:void(0);" method="post">
    <div class="form-group col-md-3">
    <label for="inputAddress" id="feinicio">Fecha de Inicio</label>
    <label for="inputAddress" id="febusqueda" style="display:none;">Fecha a Buscar</label>
     <input class="form-control" type="text" id="fechainicio" name="fechas" placeholder="//">
  </div>
   <div class="form-group col-md-3">
      <label for="inputCentral">Central</label>
      <select id="inputCentral" class="form-control">

        <?php 

          $verAdminWC = $userData["AdminWorkCenter"];
         
         //$verAdminWC = $userData["AdminWorkCenter"];

        if ($userData["WorkCenter"]==1 || count($verAdminWC)>0) {?>
             <option selected="TRUE"  value="0">Seleccionar Central..</option>
        <?php }

        for ($icentrales=0; $icentrales < count($userInfoData) ; $icentrales++) { 
            
        ?>

        <option  value="<?php echo $userInfoData[$icentrales]["id_Ener_station"]?>"><?php echo $userInfoData[$icentrales]["Ener_station"]?></option>

    <?php }?>
        
      </select>
    </div>
    <div class="form-group col-md-3">
      <label for="inputOrden">Cuenta de Orden</label>
      <select id="inputOrden" class="form-control" disabled="true">
         <?php 

        if ($userData["WorkCenter"]==1 || count($verAdminWC)>0) {?>
             <option selected="TRUE"  value="0">Cuenta de Orden..</option>
            
        <?php }?> 
        <option  value="<?php echo $userInfoData[$posuserInfoData-1]["id_Ener_account_order"]?>"><?php echo $userInfoData[$posuserInfoData-1]["Ener_account_order"]?></option>
        
      </select>
    </div>


<div class="form-group col-md-1" id="bhistoricos" style="display:none;">
    <label for="inputOrden"></label>
<button class="btn btn-default" id="buscarexcel" >
      <span class="glyphicon glyphicon-search"></span> Buscar
    </button>
    </div>

        <div class="form-group col-md-12">
        <br><br>
        <div id="tablaexcel" style="font-size: 10px; "  ></div>

        <div id="tablaexcelo" style="font-size: 10px; height: 46px; overflow: hidden;" data-initialstyle="font-size: 10px; " data-originalstyle="font-size: 10px; height: 114px; overflow: hidden;" class="handsontable htRowHeaders htColumnHeaders"><div class="ht_clone_top handsontable" style="position: absolute; top: 0px; left: 0px; overflow: hidden; width: 924px; height: 30px;"><div class="wtHolder" style="position: relative; width: 924px; height: 46px;"><div class="wtHider" style="width: 924px;"><div class="wtSpreader" style="position: relative; left: 0px;"><table class="htCore"><colgroup><col class="rowHeader" style="width: 74px;"><col style="width: 34px;"><col style="width: 34px;"><col style="width: 34px;"><col style="width: 34px;"><col style="width: 34px;"><col style="width: 34px;"><col style="width: 34px;"><col style="width: 34px;"><col style="width: 34px;"><col style="width: 34px;"><col style="width: 34px;"><col style="width: 34px;"><col style="width: 34px;"><col style="width: 34px;"><col style="width: 34px;"><col style="width: 34px;"><col style="width: 34px;"><col style="width: 34px;"><col style="width: 34px;"><col style="width: 34px;"><col style="width: 34px;"><col style="width: 34px;"><col style="width: 34px;"><col style="width: 34px;"><col style="width: 34px;"></colgroup><thead><tr><th class="" style="height: 25px;"><div class="relative"><span class="colHeader cornerHeader">TOTAL</span></div></th><th class=""><div class="relative"><span class="colHeader" id="toth1">0</span></div></th><th class=""><div class="relative"><span class="colHeader" id="toth2">0</span></div></th><th class=""><div class="relative"><span class="colHeader" id="toth3">0</span></div></th><th class=""><div class="relative"><span class="colHeader" id="toth4">0</span></div></th><th class=""><div class="relative"><span class="colHeader" id="toth5">0</span></div></th><th class=""><div class="relative"><span class="colHeader" id="toth6">0</span></div></th><th class=""><div class="relative"><span class="colHeader" id="toth7">0</span></div></th><th class=""><div class="relative"><span class="colHeader" id="toth8">0</span></div></th><th class=""><div class="relative"><span class="colHeader" id="toth9">0</span></div></th><th class=""><div class="relative"><span class="colHeader" id="toth10">0</span></div></th><th class=""><div class="relative"><span class="colHeader" id="toth11">0</span></div></th><th class=""><div class="relative"><span class="colHeader" id="toth12">0</span></div></th><th class=""><div class="relative"><span class="colHeader" id="toth13">0</span></div></th><th class=""><div class="relative"><span class="colHeader" id="toth14">0</span></div></th><th class=""><div class="relative"><span class="colHeader" id="toth15">0</span></div></th><th class=""><div class="relative"><span class="colHeader" id="toth16">0</span></div></th><th class=""><div class="relative"><span class="colHeader" id="toth17">0</span></div></th><th class=""><div class="relative"><span class="colHeader" id="toth18">0</span></div></th><th class=""><div class="relative"><span class="colHeader" id="toth19">0</span></div></th><th class=""><div class="relative"><span class="colHeader" id="toth20">0</span></div></th><th class=""><div class="relative"><span class="colHeader" id="toth21">0</span></div></th><th class=""><div class="relative"><span class="colHeader" id="toth22">0</span></div></th><th class=""><div class="relative"><span class="colHeader" id="toth23">0</span></div></th><th class=""><div class="relative"><span class="colHeader" id="toth24">0</span></div></th><th class=""><div class="relative"><span class="colHeader" id="toth25">0</span></div></th></tr></thead><tbody></tbody></table></div></div></div></div></div>
        
        <div id="rangemsg"></div>
        <br>
       
        <br>
        <button class="btn btn-success" id="guardaform">Guardar</button>
        <button class="btn btn-success" id="actualizaform" style="display:none;">Actualizar</button>
        <button class="btn btn-danger" id="cancelarform">Cancelar</button>
        </div>
    </form>
    </div>  

                    </div>
                </div>
                
</div>
            
            
            
</div>



    </div>
</div>





<?php
$this->load->view("modal_windows/modalInformation", array(
    "idPanel"  => "assing",
    "module"   => "manage_email",
    "classCss" => "modal-form",
    "tpl"      => "modals/assingDoc"
));
$this->load->view("modal_windows/modalInformation", array(
    "idPanel"  => "acknowledgment",
    "module"   => "manage_email",    
    "classCss" => "modal-content-alert modal-content-alert-form",
    "classSec" => "modal-body-alert",
    "tpl"      => "modals/acknowledgmentDoc"
));
$this->load->view("modal_windows/modalInformation", array(
    "idPanel"  => "replace",
    "module"   => "manage_email",    
    "classCss" => "modal-content-alert modal-content-alert-form",
    "classSec" => "modal-body-alert",
    "tpl"      => "modals/replaceDoc"
));
$this->load->view("modal_windows/modalInformation", array(
    "idPanel"  => "add-history",
    "module"   => "manage_email",
    "classCss" => "modal-form",
    "classSec" => "",
    "tpl"      => "modals/addHistory",
    "title"    => "Agregar al historial"
));
$this->load->view("modal_windows/modalViewFiles", array(
    "module"   => "tpl_general",
    "tpl"      => "canvas"
));
$this->load->view("modal_windows/modalAlert");