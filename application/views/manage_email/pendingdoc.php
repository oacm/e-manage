<div class="right_col" role="main">
    <div class="">
        <?php
        if ($vMenu["render"]) {
            $this->load->view("main/vMenu", $vMenu["data"]);
        }
        ?>

        <div class="row">
            
            <div id="Pinbox" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                
                <div class="x_panel">
                    
                    <div class="x_title">
                        <h2>
                            <p>Bandeja de entrada</p>
                        </h2>
                        <button type="button" data-action="new-doc" class="btn btn-default btn-toggle">
                            <span class="docs-tooltip">
                                <span class="fa fa-file-text"></span>
                            </span>
                            <div class="btn-text">Nuevo Documento</div>
                        </button>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="x_content">
                        <table id="Tinbox" class="table table-striped table-bordered dt-responsive nowrap hover cursor-picker" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th># Control</th>
                                    <th>Folio</th>
                                    <th>Asunto</th>
                                    <th>Remitente</th>
                                    <th>Contacto</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    
                </div>
                
            </div>
            
            <div id="Pcheck" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 panel-go-to" style="display: none;">
                
                <div class="x_panel">
                    
                    <div class="x_title">
                        <h2>
                            <p>Panel de revisión</p>
                        </h2>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="x_content">
                        <table id="Tcheck" class="table table-striped table-bordered dt-responsive nowrap hover cursor-picker" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th># Control</th>
                                    <th>Folio</th>
                                    <th>Asunto</th>
                                    <th>Remitente</th>
                                    <th>Contacto</th>
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
                "columns" => array("Secuencial", "No. Oficio", "Folio", "Asunto", "Remitente", "Tema", "Turnado A:", "Encaminado A","Status"), 
                "class"   => "cursor-picker",
                "extraBtn" => array(
                    array(
                        "action" => "add-history",
                        "icon"   => "fa fa-plus",
                        "text"   => "Agregar Documento"
                    ))
                )); ?>

            <div id="view-doc" class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="display: none;">
                
                <div class="x_panel antecedent-panel" style="height: auto; display: none;">
                    
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
                        <h2>Acciones de documento</h2>
                        <div class="clearfix"></div>
                    </div>
                    
                    <div class="x_content">
                        <form action="javascript:void(0);" class="form-horizontal form-label-left input_mask" method="post">
                            
                            <div class="form-group">
                                
                                <div class="col-md-4 col-sm-2 col-xs-12">
                                    <label class="control-label info-doc-label col-xs-12">Número de control</label>
                                    <p data-key="control_folio" class="info-doc-label">XXXXX</p>
                                </div>
                                <div class="col-md-4 col-sm-2 col-xs-12">
                                    <label class="control-label info-doc-label col-xs-12">Folio del documento</label>
                                    <p data-key="folio_doc" class="info-doc-label">XXXXX</p>
                                </div>
                                <div class="col-md-4 col-sm-2 col-xs-12">
                                    <label class="control-label info-doc-label col-xs-12">Fecha de expiración</label>
                                    <p data-key="expiration" class="info-doc-label">XXXXX</p>
                                </div>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <div class="col-md-4 col-sm-2 col-xs-12">
                                    <label class="control-label info-doc-label col-xs-12">Asunto</label>
                                    <p data-key="subject" class="info-doc-label">XXXXX</p>
                                </div>
                                <div class="col-md-4 col-sm-2 col-xs-12">
                                    <label class="control-label info-doc-label col-xs-12">Remitente</label>
                                    <p data-key="nameSender" class="info-doc-label">XXXXX</p>
                                </div>
                                <div class="col-md-4 col-sm-2 col-xs-12">
                                    <label class="control-label info-doc-label col-xs-12">Contacto</label>
                                    <p data-key="contactName" class="info-doc-label">XXXXX</p>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                
                                <div class="col-md-11 col-sm-2 col-xs-12">
                                    <fieldset>
                                        <legend>Comentarios</legend>                                    
                                    </fieldset>

                                    <textarea data-key="comments" name="comments" readonly="readonly" class="col-md-12 col-sm-12 col-xs-12">XXXXXXXXXX XXXXXXXXXX XXXXXXX</textarea>
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
                            
                            <div data-buttons="check" class="form-group" style="display: none;">
                                
                                <div class="col-md-12 col-sm-2 col-xs-12">
                                    <div class="checkbox" style="padding-top: initial;">
                                        <label style="padding-left: initial;">
                                            <input type="checkbox" class="flat"> Documento Definitivo
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-md-12 col-sm-2 col-xs-12">
                                
                                    <button id="accept-check-btn" disabled="disabled" type="button" data-action="accept" class="btn btn-success">
                                        <span class="docs-tooltip">
                                            <span class="fa fa-check"></span>
                                        </span>
                                        <span>Aceptar</span>
                                    </button>
                                    <button type="button" data-action="reject" class="btn btn-danger">
                                        <span class="docs-tooltip">
                                            <span class="fa fa-close"></span>
                                        </span>
                                        <span>Rechazar</span>
                                    </button>
                                    <button type="button" data-action="return" class="btn btn-default">
                                        <span class="docs-tooltip">
                                            <span class="fa fa-mail-reply"></span>
                                        </span>
                                        <span>Regresar</span>
                                    </button>
                                
                                </div>
                                
                            </div>
                            
                            <div data-buttons="inbox" class="form-group" style="display: none;">
                                
                                <div class="form-group">
                                    
                                    <label class="control-label col-md-1 col-sm-2 col-xs-12">
                                        Tema *
                                    </label>

                                    <div class="col-md-3 col-sm-2 col-xs-12">
                                        <select data-key="theme_id" name="theme_id" class="select2_single form-control" tabindex="-1" required="required" style="width: 100%;">
                                            <option></option>
                                        </select>
                                    </div>

                                    <label class="control-label col-md-1 col-sm-2 col-xs-12">
                                        Prioridad *
                                    </label>

                                    <div class="col-md-3 col-sm-2 col-xs-12">
                                        <select data-key="priority_id" name="priority_id" class="select2_single form-control" tabindex="-1" required="required" style="width: 100%;">
                                            <option></option>
                                        </select>
                                    </div>

                                    <label class="control-label col-md-1 col-sm-2 col-xs-12">
                                        Antecedente
                                    </label>

                                    <div class="col-md-3 col-sm-2 col-xs-12">
                                        <input id="select-antecedent" data-key="antecedent" name="antecedent" class="form-control" readonly="readonly" required="required" />
                                    </div>
                                
                                </div>
                                
                                <div class="col-md-12 col-sm-2 col-xs-12">
                                    <button type="button" data-action="knowledge" class="btn btn-success">
                                        <span class="docs-tooltip">
                                            <span class="glyphicon glyphicon-floppy-disk"></span>
                                        </span>
                                        <span>Guardar</span>
                                    </button>
                                    <button type="submit" data-action="answered" class="btn btn-primary">
                                        <span class="docs-tooltip">
                                            <span class="fa fa-pencil"></span>
                                        </span>
                                        <span>Encaminar</span>
                                    </button>
                                    <button type="button" data-action="returned" class="btn btn-info">
                                        <span class="docs-tooltip">
                                            <span class="glyphicon glyphicon-send"></span>
                                        </span>
                                        <span>Re-enviar</span>
                                    </button>
                                    <button type="button" data-action="comment" class="btn btn-warning">
                                        <span class="docs-tooltip">
                                            <span class="fa fa-comment"></span>
                                        </span>
                                        <span>Comentar</span>
                                    </button>
                                    <button type="button" data-action="return" class="btn btn-default">
                                        <span class="docs-tooltip">
                                            <span class="fa fa-mail-reply"></span>
                                        </span>
                                        <span>Regresar</span>
                                    </button>
                                </div>
                                
                            </div>
                            
                            <div data-buttons="history" class="form-group" style="display: none;">
                                
                                <div class="form-group">
                                    
                                    <label class="control-label col-md-1 col-sm-2 col-xs-12">
                                        Tema
                                    </label>

                                    <div class="col-md-3 col-sm-2 col-xs-12">
                                        <select disabled="disabled" data-key="theme-history" class="select2_single form-control" tabindex="-1" style="width: 100%;">
                                            <option></option>
                                        </select>
                                    </div>

                                    <label class="control-label col-md-1 col-sm-2 col-xs-12">
                                        Prioridad
                                    </label>

                                    <div class="col-md-3 col-sm-2 col-xs-12">
                                        <select disabled="disabled" data-key="priority-history" class="select2_single form-control" tabindex="-1" style="width: 100%;">
                                            <option></option>
                                        </select>
                                    </div>
                                    
                                    <label class="control-label col-md-1 col-sm-2 col-xs-12">
                                        Antecedentes
                                    </label>

                                    <div class="col-md-3 col-sm-2 col-xs-12">
                                        <input data-key="antecedent" class="form-control" readonly="readonly" disabled="disabled" />
                                    </div>
                                
                                </div>
                                
                                <div class="col-md-12 col-sm-2 col-xs-12">
                                    <button type="button" data-action="comment" class="btn btn-warning">
                                        <span class="docs-tooltip">
                                            <span class="fa fa-comment"></span>
                                        </span>
                                        <span>Comentar</span>
                                    </button>
                                    <button type="button" data-action="return" class="btn btn-default">
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
$this->load->view("manage_email/modals/modalAntecedent");
$this->load->view("modal_windows/modalInformation", array(
    "idPanel"  => "returned",
    "module"   => "manage_email",
    "classCss" => "modal-content-alert modal-content-alert-form",
    "classSec" => "modal-body-alert",
    "tpl"      => "modals/returnedDoc",
    "title"    => "Returnar"
));
$this->load->view("modal_windows/modalInformation", array(
    "idPanel"  => "answered",
    "module"   => "manage_email",
    "classCss" => "modal-content-alert modal-content-alert-form",
    "classSec" => "modal-body-alert",
    "tpl"      => "modals/answeredDoc",
    "title"    => "Responder"
));
$this->load->view("modal_windows/modalInformation", array(
    "idPanel" => "reject",
    "module"  => "manage_email",
    "tpl"     => "modals/rejectCheckDoc"
));
$this->load->view("modal_windows/modalInformation", array(
    "idPanel" => "accept",
    "module"  => "manage_email",
    "tpl"     => "modals/acceptCheckDoc"
));
$this->load->view("modal_windows/modalInformation", array(
    "idPanel"  => "comment",
    "module"   => "manage_email",
    "tpl"      => "modals/commentDoc",
    "title"    => "Comentar"
));
$this->load->view("modal_windows/modalInformation", array(
    "idPanel"  => "comment-history",
    "module"   => "manage_email",
    "tpl"      => "modals/commentDoc",
    "title"    => "Comentar"
));
$this->load->view("modal_windows/modalInformation", array(
    "idPanel"  => "add-document",
    "module"   => "manage_email",
    "classCss" => "modal-form",
    "classSec" => "",
    "tpl"      => "modals/newDocument",
    "title"    => "Nuevo documento"
));
$this->load->view("modal_windows/modalInformation", array(
    "idPanel"  => "add-history",
    "module"   => "manage_email",
    "classCss" => "modal-form",
    "classSec" => "",
    "tpl"      => "modals/addHistory",
    "title"    => "Agregar al historial",
    "args"     => array(
        "setCorp" => TRUE,
        "setCode" => TRUE
    )
));
$this->load->view("modal_windows/modalViewFiles", array(
    "module"   => "tpl_general",
    "tpl"      => "canvas"
));
$this->load->view("modal_windows/modalAlert");