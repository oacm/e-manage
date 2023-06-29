<div class="right_col" role="main">
    <div class="">
        <?php
        if ($vMenu["render"]) {
            $this->load->view("main/vMenu", $vMenu["data"]);
        }
        ?>

        <div class="row">
            
            <div id="Panswered" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                
                <div class="x_panel">
                    
                    <div class="x_title">
                        <h2>
                            <p>Elaborar respuesta</p>
                        </h2>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="x_content">
                        <table id="Tanswered" class="table table-striped table-bordered dt-responsive nowrap hover cursor-picker" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th># Control</th>
                                    <th>Folio</th>
                                    <th>Asunto</th>
                                    <th>Tema</th>
                                    <th>Remitente</th>
                                    <th>Prioridad</th>
                                    <th>Expiración</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    
                </div>
                
            </div>
            
            <div id="panel-history" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 panel-go-to" style="display: none;">
                
                <div class="x_panel">
                    
                    <div class="x_title">
                        <h2>
                            <p>Historial</p>
                        </h2>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="x_content">
                        <table class="table table-striped table-bordered dt-responsive nowrap hover cursor-picker" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th># Control</th>
                                    <th>Folio</th>
                                    <th>Asunto</th>
                                    <th>Tema</th>
                                    <th>Remitente</th>
                                    <th>Expiración</th>
                                    <th>Antecedente</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    
                </div>
                
            </div>
            
            <div id="view-doc" class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="display: none;">
                
                <div class="x_panel antecedent-panel" style="height: auto;">
                    
                    <div class="x_title">
                        <h2>Antecedentes</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li style="float: right;">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="x_content">
                        <div class="wizard_horizontal history-timeline">
                            <ul class="wizard_steps"></ul>
                        </div>
                    </div>
                    
                    <?php $this->load->view("tpl_general/layerLoading", array("msg" => "Adquiriendo Antecedentes")); ?>
                    
                </div>
                
                <div class="x_panel">
                    
                    <div class="x_title">
                        <h2>Documento</h2>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="x_content">
                        <form class="form-horizontal form-label-left input_mask" method="post">
                            
                            <div class="form-group">
                                
                                <div class="col-md-4 col-sm-2 col-xs-12">
                                    <label class="control-label info-doc-label col-xs-12">Número de control</label>
                                    <p data-key="control_folio" class="info-doc-label">XXXXX</p>
                                </div>
                                <div class="col-md-4 col-sm-2 col-xs-12">
                                    <label class="control-label info-doc-label col-xs-12">Tema</label>
                                    <p data-key="theme" class="info-doc-label">XXXXX</p>
                                </div>
                                <div class="col-md-4 col-sm-2 col-xs-12">
                                    <label class="control-label info-doc-label col-xs-12">Fecha de expiración</label>
                                    <p data-key="expiration" class="info-doc-label">XXXXX</p>
                                </div>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <div class="col-md-4 col-sm-2 col-xs-12">
                                    <label class="control-label info-doc-label col-xs-12">Folio del documento</label>
                                    <p data-key="folio_doc" class="info-doc-label">XXXXX</p>
                                </div>
                                <div class="col-md-4 col-sm-2 col-xs-12">
                                    <label class="control-label info-doc-label col-xs-12">Asunto</label>
                                    <p data-key="subject" class="info-doc-label">XXXXX</p>
                                </div>
                                <div class="col-md-4 col-sm-2 col-xs-12">
                                    <label class="control-label info-doc-label col-xs-12">Remitente</label>
                                    <p data-key="nameSender" class="info-doc-label">XXXXX</p>
                                </div>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <div class="col-md-11 col-sm-2 col-xs-12">
                                    <fieldset>
                                        <legend>Comentarios</legend>                                    
                                    </fieldset>

                                    <textarea data-key="comments" readonly="readonly" class="col-md-12 col-sm-12 col-xs-12">XXXXXXXXXX XXXXXXXXXX XXXXXXX</textarea>
                                </div>
                                
                                <div class="col-md-1 col-sm-2 col-xs-12">
                                    
                                    <div data-key="fileType" class="thumbnail attach-file" style="margin-top: 50px;">
                                        <div class="image view view-first">
                                            <img style="width: 100%; display: block;" src="<?php echo base_url() . "assets/images/word_icon_128.png"; ?>" alt="" />
                                            <div class="mask">
                                                <div class="tools tools-bottom">
                                                    <a href="javascript:void();" target="_blank">
                                                        <i class="fa fa-download"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>                                        
                                    </div>
                                    
                                </div>
                                
                            </div>
                            
                            <div data-buttons="answered" class="form-group" style="display: none;">
                                <div style="display: table; float: left;">
                                    <button type="button" data-action="answered" class="btn btn-success">
                                        <span class="docs-tooltip">
                                            <span class="fa fa-file-text"></span>
                                        </span>
                                        <span id="label-submit">Responder</span>
                                    </button>                                
                                    <button type="reset" data-action="return" class="btn btn-default">
                                        <span class="docs-tooltip">
                                            <span class="fa fa-mail-reply"></span>
                                        </span>
                                        <span id="label-submit">Regresar</span>
                                    </button>                                
                                </div>
                            </div>
                            
                        </form>
                    </div>
                    
                </div>
                
            </div>
            
        </div>
    </div>
</div>

<?php
$this->load->view("modal_windows/modalInformation", array(
    "idPanel"  => "answered",
    "module"   => "manage_email",
    "classCss" => "modal-content-alert modal-content-alert-form",
    "classSec" => "modal-body-alert",
    "tpl"      => "modals/flowAnsweredDoc",
    "title"    => "Responder"
));
$this->load->view("modal_windows/modalViewFiles", array(
    "module"   => "tpl_general",
    "tpl"      => "canvas"
));
$this->load->view("modal_windows/modalAlert");