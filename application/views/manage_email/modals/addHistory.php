<form class="form-horizontal form-label-left input_mask" action="javascript:void(0);" method="post">

    <div class="form-group-sm">
        <label class="control-label col-md-12 col-sm-12 col-xs-12">
            No. de Oficio <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" data-key="control_folio" name="control_folio" class="form-control" placeholder="# Secuencial" readonly/>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="col-md-3 col-sm-3 col-xs-12" style="padding-right: 0px;">
                <?php if(!isset($setCorp)){ ?>
                <select data-key="corp" name="corp" class="select2_single form-control js-example-responsive" tabindex="-1" required style="width: 100%;">
                    <option></option>
                    <option value="1">GFNX</option>
                    <option value="2">SFNX</option>
                    <option value="3">CFNX</option>
                </select>
                <?php }else{ ?>
                <input type="text" data-key="corp" name="corp" class="form-control" placeholder="Inc." readonly/>
                <?php } ?>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12" style="padding-right: 0px;">
                <?php if(!isset($setCode)){ ?>
                <select data-key="area" name="area" class="select2_single form-control js-example-responsive" tabindex="-1" required style="width: 100%;">
                    <option></option>
                </select>
                <?php }else{ ?>
                <input type="text" data-key="doc_code" name="doc_code" class="form-control" placeholder="" readonly/>
                <input type="hidden" data-key="area" name="area"/>
                <?php } ?>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12" style="padding-right: 0px;">
                <select data-key="year_doc_out" name="year_doc_out" class="select2_single form-control js-example-responsive" tabindex="-1" required style="width: 100%;">                    
                </select>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12" style="padding-right: 0px;">
                <select data-key="num_doc_out" name="num_doc_out" class="select2_single form-control js-example-responsive" tabindex="-1" required style="width: 100%;">
                    <option></option>
                </select>
            </div>
        </div>                                                                
    </div>
    
    <div class="form-group-sm">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" data-key="subject" name="subject" class="form-control" placeholder="Asunto *" required="required" />
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <select data-key="theme_id" name="theme_id" class="select2_single form-control js-example-responsive" style="width: 100%;" tabindex="-1" required="required">
                <option></option>
            </select>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <input data-key="antecedent" type="text" name="antecedent" class="form-control" placeholder="Antecedentes" pattern="[A-Z]{0,1}FN[X]{0,1}-[A-Za-z]{2,}-[A-Za-z]{2,}-[0-9]{2,}/[0-9]{4}" title="No. Secuencial del documento ó el No. de Oficio"/>
        </div>
    </div>
    
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div>
            <label>
                <input data-check="input-activate" name="doc_initial" type="checkbox" class="js-switch" /> Documento recibido
            </label>
        </div>
    </div>
    
    <div class="form-group-sm container-activate" data-check="input-activate-container">
        <div class="col-md-3 col-sm-3 col-xs-12">
            <input data-key="folio_doc" type="text" name="folio_doc" class="form-control" placeholder="Folio *" disabled required="required" />
        </div>                                                                
        <div class="col-md-3 col-sm-3 col-xs-12">
            <input data-key="date_document" type="text" name="date_document" class="form-control" required="required" placeholder="Fecha del documento *" disabled pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}">
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12">
            <select data-key="sender_id" name="sender_id" class="select2_single form-control js-example-responsive" style="width: 100%;" tabindex="-1" disabled required="required">
                <option>Dependencia *</option>
            </select>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12">
            <select data-key="contact_id" name="contact_id" class="select2_single form-control js-example-responsive" style="width: 100%;" tabindex="-1" style="width: 100%;" disabled required="required">
                <option>Firmante *</option>
            </select>
        </div>
        <div class="alignleft attachment-left-aling" style="display: inline-block;">

            <label class="btn btn-default btn-sm btn-upload">
                <input id="initial-doc-file" type="file" class="sr-only" name="file[]" disabled accept=".pdf" required="required">
                <span class="docs-tooltip">
                    <span class="fa fa-paperclip"></span>
                    Documento
                </span>
            </label>

        </div>

        <div id="initial-doc-container" class="attachment" style="float: left;"></div>        
    </div>
    
    <div class="form-group-sm">
        <div class="alignleft attachment-left-aling" style="display: inline-block;">

            <label class="btn btn-sm btn-default btn-upload">
                <input id="final-doc-file" type="file" class="sr-only" name="file[]" accept=".pdf" required="required">
                <span class="docs-tooltip">
                    <span class="fa fa-paperclip"></span>
                    Oficio de respuesta
                </span>
            </label>

        </div>

        <div id="final-doc-container" class="attachment" style="float: left;"></div>
    </div>

    <div class="form-group-sm">
        <div class="col-md-12" >
            <textarea data-key="comments" name="comments" class="comment-area" required="required"></textarea>
        </div>
    </div>

    <div class="form-group-sm">

        <div class="col-md-12" style="padding-right: 0px;">
            
            <button type="reset" class="btn btn-sm btn-danger alignright">Cancelar</button>
            
            <button type="submit" class="btn btn-sm btn-success alignright">
                <span class="docs-tooltip">
                    <span class="fa fa-envelope"></span>
                </span>
                Guardar
            </button>

        </div>

    </div>

</form>