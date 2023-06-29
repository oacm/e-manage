<div class="right_col" role="main">
    <div class="">
        <?php
        if ($vMenu["render"]) {
            $this->load->view("main/vMenu", $vMenu["data"]);
        }
        ?>

        <div class="row">
            
            <?php $this->load->view("manage_email/panels/history", array("columns" => array("#Control", "Folio", "Asunto", "Remitente", "Tema", "Status"), "class" => "cursor-picker")); ?>
            
            <?php $this->load->view("manage_email/panels/documentViewer", array("display" => FALSE, "buttons" => "history")); ?>
            
        </div>
    </div>
</div>

<?php
$this->load->view("modal_windows/modalInformation", array(
    "idPanel"  => "comment",
    "module"   => "manage_email",
    "classCss" => "modal-content-alert modal-content-alert-form",
    "classSec" => "modal-body-alert",
    "tpl"      => "modals/commentDoc",
    "title"    => "Comentar"
));
$this->load->view("modal_windows/modalAlert");