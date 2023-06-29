<div class="right_col" role="main">
    <div class="">
        <?php
        if ($vMenu["render"]) {
            $this->load->view("main/vMenu", $vMenu["data"]);
        }
        ?>

        <div class="row">
            
            <div id="PdocStart" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                
                <div class="x_panel">
                    <div class="x_title">
                        <h2>
                            <p>Documentos de Entrada</p>
                        </h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form id="FdocStart" class="form-horizontal form-label-left input_mask" action="javascript:void(0);" method="post">
                            <div class="form-group">

                                <div class="col-lg-3">

                                    <label class="btn btn-default btn-upload">
                                        <input type="file" class="sr-only" name="file" accept=".pdf" required="required" />
                                        <span class="docs-tooltip">
                                            <span class="fa fa-paperclip"></span>
                                            Documento Nuevo
                                        </span>
                                    </label>

                                </div>

                            </div>
                        </form>
                        
                        <table id="TdocStart" data-parent="pending-doc" class="table table-striped table-bordered dt-responsive nowrap hover cursor-picker" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th># Control</th>
                                    <th>Status</th>
                                    <th></th>                                  
                                </tr>
                            </thead>
                        </table>
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