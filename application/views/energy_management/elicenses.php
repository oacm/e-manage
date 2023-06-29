<?php date_default_timezone_set('America/Mexico_City');
$timestamp = time(); // CDT
      $current_date = date('d/m/Y',$timestamp);
      ?>
<script type="text/javascript">
      var fechaservidor = '<?php echo $current_date; ?>';  
</script>
<style type="text/css">
    fieldset.scheduler-border {
    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
}

    legend.scheduler-border {
        font-size: 1.2em !important;
        font-weight: bold !important;
        text-align: left !important;
        width:auto;
        padding:0 10px;
        border-bottom:none;
    }

    .divScroll {
  height:350px;
  overflow-y: scroll;
}
</style>
<div class="right_col" role="main">
    <div class="">
       


 
 
        <?php
        if ($vMenu["render"]) {
            $this->load->view("main/vMenu", $vMenu["data"]);
        }
        ?>

    <?php
      $posuserInfoData=count($userInfoData);
      $posuserStationData=count($userStationData);

 $verAdminWC = $userData["AdminWorkCenter"];

  



?> 

<script type="text/javascript">var centralescodigos = <?php echo json_encode( $userInfoData); ?>;</script>
<script type="text/javascript">var estacionetotales = <?php echo json_encode( $userStationData); ?>;</script>






<div class="row">
            
<div id="pending-doc" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                
                <div class="x_panel">
                    <div class="x_title">
                        <h2>
                            <p>Licencias </p>
                        </h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         

 <button type="button"  id="registrarbtn" class="btn btn-default" data-toggle="modal" data-target="#modal-win-info-add-licenses">
                                <span class="glyphicon glyphicon-plus"></span> Registrar Licencia
         
</button>

    



 <br><br>
 

  <fieldset class="scheduler-border">
                <legend class="scheduler-border">Buscar por:</legend>
       
    <div id ="contienebusquedas"  class="container col-xs-12"">
        
       <div class="form-group col-xs-2">
      <label for="inputCentral">Central</label>
      <select id="inputCentral" class="form-control">

        <?php 

          $verAdminWC = $userData["AdminWorkCenter"];


         //$verAdminWC = $userData["AdminWorkCenter"];

        if ($userData["WorkCenter"]==1 || count($verAdminWC)>0) {?>
            
        <?php }

        for ($icentrales=0; $icentrales < count($userInfoData) ; $icentrales++) { 
            
        ?>

        <option  value="<?php echo $userInfoData[$icentrales]["id_Ener_station"]?>"><?php echo $userInfoData[$icentrales]["Ener_station"]?></option>

    <?php }?>
        
      </select>
    </div>

    <div class="form-group col-xs-2">
      <label for="inputCentral">Unidades</label>
      <select id="inputUnidades" class="form-control">
      </select>
    </div>
    <div class="form-group col-xs-2">
    <label for="inputFinicio" id="feinicio">Fecha Inicio</label>
     <input class="form-control" type="text" id="fechainicio" name="fechasinbus" placeholder="//" style="font-size: 13px; padding-left: 2px" >
  </div>
  <div class="form-group col-xs-2" id="bloquefecha">
    <label for="inputFfin">Fecha Fin</label>
     <input class="form-control" type="text" id="fechafin" name="fechasfinbus" placeholder="//" style="font-size: 13px; padding-left: 2px" >
  </div>

        <div class="form-group col-xs-2">
             <div class="radio">
              <label><input type="radio" id="optradio" value="1" name="optradio" checked>Vigentes</label>
            </div>
            <div class="radio">
              <label><input type="radio" id="optradio" value="0" name="optradio">Expiradas</label>
            </div>
            <div class="radio">
              <label><input type="radio" id="optradio" value="2" name="optradio">Todas</label>
            </div>



        </div> 
        <div class="form-group col-xs-2" id="bloquefecha" id="bhistoricos" style="padding-top: 35px;">
    <button class="btn btn-default" id="buscarunidades" style="height: 70px" >
      <span class="glyphicon glyphicon-search"></span> Buscar
    </button>
  </div>
           

    </div>
 
     <div style="padding-left: 20px;padding-top: 0px;padding-bottom:10px;"class="form-group col-xs-2" id="bpolicencia">
        
    <label for="inputFfin">Núm. Licencia</label>
     <input class="form-control" type="text" id="numlicinput" name="numlicinput" placeholder="Licencia" onchange="validaentrada();" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();"/>
    </div> 
    
   </fieldset>

<div class="form-group col-xs-12" id="resultadostablas" style="display:none;">
  <br><br>
  <h2>Resultados</h2>
         
  <table id="tabladeresultados" class="table table-striped table-bordered" style="width:100%">
    <thead>
      <tr>
        <th>Unidad</th>
        <th>Fecha de Inicio</th>
        <th>Fecha Final</th>
        <th>Núm. Licencia</th>
        <th>Estatus</th>
         <th>Acción</th>
      </tr>
    </thead>
    <tbody>
      
    </tbody>
    
  </table>

  
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
$this->load->view("modal_windows/modalElicenses", array(
    "idPanel"  => "add-licenses",
    "module"   => "energy_management",
    "classCss" => "modal-form",
    "classSec" => "",
    "tpl"      => "modals/addLicense",
    "title"    => "Añadir Licencias"
));
$this->load->view("modal_windows/modalInformation", array(
    "idPanel"  => "pending-doc",
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