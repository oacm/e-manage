<form class="form-horizontal form-label-left input_mask" action="javascript:void(0);" method="post">

    <div class="form-group">
        <label class="control-label col-md-2 col-sm-2 col-xs-12" style="padding-right: 0px;">
            Secuencial
        </label>
        <div class="col-md-4 col-sm-10 col-xs-12">
            <input type="text" data-key="control_folio" name="control_folio" class="form-control" readonly="readonly" />
        </div>
        <button type="button" data-action="generate-folio-out" style="margin-right: 0px;" class="btn btn-default col-md-2 col-sm-2 col-xs-12 ">
            <span>Generar Folio</span>
        </button>
        <div class="col-md-4 col-sm-10 col-xs-12">
            <input type="text" data-key="control_folio_out" name="folio_doc_out" class="form-control" required="required" readonly="readonly">
        </div>                                                                
    </div>
    
    <div class="form-group">
        <label class="control-label col-md-2 col-sm-3 col-xs-12" style="padding-right: 0px;">
            Copia A
        </label>
        <div class="col-md-10 col-sm-9 col-xs-12">
          <select data-key="cc" name="cc[]" multiple="true" class="select2_single form-control js-example-responsive" style="width: 100%;" tabindex="-1"></select>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-2 col-sm-2 col-xs-12" style="padding-right: 0px;">
            Asunto <span class="required">*</span>
        </label>
        <div class="col-md-10 col-sm-10 col-xs-12">
            <input type="text" data-key="subject" name="subject" class="form-control" required="required" />
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-md-2 col-sm-2 col-xs-12">
            Tema <span class="required">*</span>
        </label>
        <div class="col-md-4 col-sm-10 col-xs-12">
            <select data-key="theme_id" name="theme_id" class="select2_single form-control js-example-responsive" style="width: 100%;" tabindex="-1" required="required" /></select>
        </div>                                                                
        <div class="alignleft" style="display: inline-block;">

            <label class="btn btn-default btn-upload">
                <input type="file" class="sr-only" name="file" accept=".pdf" required="required">
                <span class="docs-tooltip">
                    <span class="fa fa-paperclip"></span>
                </span>
            </label>

        </div>

        <div class="attachment" style="float: left;"></div>                                                               
    </div>

    <div class="form-group has-feedback">
        <div class="col-md-12">
            <textarea id="add-comment-doc" data-key="comments" name="comments" class="comment-area" required="required"></textarea>
        </div>
    </div>

    <div class="form-group has-feedback">

        <div class="col-md-12" style="padding-right: 0px;">

            <button type="submit" class="btn btn-success btn-lg">
                <span class="docs-tooltip">
                    <span class="fa fa-envelope"></span>
                </span>
                Guardar
            </button>
            <button type="reset" class="btn btn-danger btn-lg">Cancelar</button>

        </div>

    </div>

</form>