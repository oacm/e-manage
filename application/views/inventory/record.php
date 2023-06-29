<div class="right_col" role="main">
    <div class="">
        <?php
        if ($vMenu["render"]) {
            $this->load->view("main/vMenu", $vMenu["data"]);
        }
        ?>

        <div class="row">
            
            <?php $this->load->view("inventory/panels/brands", array("idPanel" => "brands")); ?>
            
            <?php $this->load->view("inventory/panels/models", array("idPanel" => "models")); ?>
            
        </div>
        
    </div>
</div>

<?php
//$this->load->view("modal_windows/modalInformation", array(
//    "idPanel"  => "assing",
//    "module"   => "manage_email",
//    "classCss" => "modal-form",
//    "tpl"      => "modals/assingDoc"
//));
//$this->load->view("modal_windows/modalInformation", array(
//    "idPanel"  => "acknowledgment",
//    "module"   => "manage_email",    
//    "classCss" => "modal-content-alert modal-content-alert-form",
//    "classSec" => "modal-body-alert",
//    "tpl"      => "modals/acknowledgmentDoc"
//));
//$this->load->view("modal_windows/modalInformation", array(
//    "idPanel"  => "replace",
//    "module"   => "manage_email",    
//    "classCss" => "modal-content-alert modal-content-alert-form",
//    "classSec" => "modal-body-alert",
//    "tpl"      => "modals/replaceDoc"
//));
//$this->load->view("modal_windows/modalAlert");