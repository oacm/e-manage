<div class="right_col" role="main">
    <div class="">
        <?php
        if ($vMenu["render"]) {
            $this->load->view("main/vMenu", $vMenu["data"]);
        }
        ?>

        <div class="row">
            
            <div id="Poutdoc" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                
                <div class="x_panel">
                    
                    <div class="x_title">
                        <h2>
                            <p>Responder Documentos</p>
                        </h2>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="x_content">
                        <table id="Toutdoc" class="table table-striped table-bordered dt-responsive nowrap hover cursor-picker" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th># Control</th>
                                    <th>Asunto</th>
                                    <th>Tema</th>
                                    <th>Descarga</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    
                </div>
                
            </div>
            
        </div>
    </div>
</div>

<?php
$this->load->view("modal_windows/modalInformation", array(
    "idPanel"  => "response",
    "module"   => "manage_email",
    "title"    => "Documento",
    "classCss" => "modal-content-alert modal-content-alert-form",
    "tpl"      => "modals/responseDoc"
));
$this->load->view("modal_windows/modalViewFiles", array(
    "module"   => "tpl_general",
    "tpl"      => "canvas"
));
$this->load->view("modal_windows/modalAlert");