<div class="right_col" role="main">
    <div class="">

         
 
        <?php
        if ($vMenu["render"]) {
            $this->load->view("main/vMenu", $vMenu["data"]);
        }
        ?>

    
<div class="row">
            
            <div id="pending-doc" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                
                <div class="x_panel">
                    <div class="x_title">
                        <h2>
                            <p>Agua Turbinada</p>
                        </h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
    

  <div class="form-row col-md-12">
    <form id="excel-form" action="javascript:void(0);" method="post">
        <div class="form-group col-md-3">
      <label for="inputCentral">Presa</label>
      <select id="inputCentral" class="form-control">

        <?php 

        if ($userData["WorkCenter"]==1) {?>
            
        <?php }

        for ($icentrales=0; $icentrales < count($userInfoData) ; $icentrales++) { 
            
        ?>

        <option  value="<?php echo $userInfoData[$icentrales]["id_weather_dam"]?>"><?php echo $userInfoData[$icentrales]["weather_dam_name"]?></option>

    <?php }?>
        
      </select>
    </div>
 <div class="form-group col-md-3">
    <label for="inputFinicio" id="feinicio">Fecha</label>
    <label for="inputAddress" id="febusqueda" style="display:none;">Fecha a Buscar</label>
     <input class="form-control" type="text" id="fechainicio" name="fechas" placeholder="//">
  </div>
  <div class="form-group col-md-3" id="bloquefecha">
    <label for="inputFfin">Valor Agua Turbinada</label>
     <input id="txtNumber" placeholder="0.0" onkeypress="return isNumberKey(event)"   type="text" name="txtNumber" class="form-control">
  </div>
  <div class="form-group col-md-3" id="bloquefecha">
    <label for="inputFfin">Valor Agua X Mes</label>
     <input id="txtNumberMes" placeholder="0.0" onkeypress="return isNumberKey(event)"   type="text" name="txtNumber" class="form-control">
  </div>
  
<div class="form-group col-md-12">
<button  class="btn btn-success" id="guardaform">Guardar </button>
<button  class="btn btn-danger" id="cancelarform">Cancelar</button>

    </div>
 

  </div>
   
</form>
                    </div>
                </div>
                
            </div>
            
            <?php $this->load->view("manage_email/panels/history", array(
                "visible" => TRUE, 
                "columns" => array(
                    "# Oficio", "# Control", "Folio" , "Asunto", "Dependencía", 
                    "Área", "Elaborado por:", "Fecha de Creación", "Status", ""),
                "extraBtn" => array(
                    array(
                        "action" => "add-history",
                        "icon"   => "fa fa-plus",
                        "text"   => "Agregar Documento"
                    ))
                )); ?>
            
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