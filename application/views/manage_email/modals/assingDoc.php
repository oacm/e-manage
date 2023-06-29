<form class="form-horizontal form-label-left input_mask" action="javascript:void(0);" method="post">
    
    <input data-key="numDocument" type="hidden" name="numDocument" required="required" />

    <div class="form-group">
        <label class="control-label col-md-2 col-sm-3 col-xs-12" style="padding-right: 0px;">
            Turnar A <span class="required">*</span>
        </label>
        <div class="col-md-10 col-sm-9 col-xs-12">
          <select id="turned-on" name="area" class="select2_single form-control js-example-responsive" style="width: 100%;" required="required" tabindex="-1"></select>
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-md-2 col-sm-3 col-xs-12" style="padding-right: 0px;">
            Copia A
        </label>
        <div class="col-md-10 col-sm-9 col-xs-12">
          <select id="cc-answered" name="cc[]" multiple="true" class="select2_single form-control js-example-responsive" style="width: 100%;" tabindex="-1"></select>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-2 col-sm-2 col-xs-12" style="padding-right: 0px;">
            Asunto <span class="required">*</span>
        </label>
        <div class="col-md-10 col-sm-10 col-xs-12">
            <input type="text" name="subject" class="form-control" required="required" />
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-2 col-sm-2 col-xs-12" style="padding-right: 0px;">
            No. Folio <span class="required">*</span>
        </label>
        <div class="col-md-4 col-sm-10 col-xs-12">
            <input type="text" name="folio_document" class="form-control" required="required" />
        </div>                                                                
        <label class="col-md-2 col-sm-2 col-xs-12 form-label-right">
            Fecha del documento <span class="required">*</span>
        </label>
        <div class="col-md-4 col-sm-10 col-xs-12">
            <input id="date_document" type="text" name="date_document" class="form-control" required="required" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}">
        </div>                                                                
    </div>
    
    <div class="form-group">
        <label class="control-label col-md-2 col-sm-2 col-xs-12" style="padding-right: 0px;">
            Antecedentes
        </label>
        <div class="col-md-10 col-sm-10 col-xs-12">
            <input type="text" name="antecedent" class="form-control" pattern="[A-Z]{0,1}FN[X]{0,1}-[A-Za-z]{2,}-[A-Za-z]{2,}-[0-9]{2,}/[0-9]{4}" title="FNX-CODIGO DE AREA-XX/AÑO"/>
        </div> 
    </div>

    <div class="form-group">
        <label class="control-label col-md-2 col-sm-2 col-xs-12" style="padding-right: 0px;">
            Dependencia<span class="required">*</span>
        </label>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <select id="sender" name="sender" class="select2_single form-control js-example-responsive" style="width: 100%;" tabindex="-1" required="required">
                <option></option>
            </select>
        </div>
        <label class="control-label col-md-2 col-sm-2 col-xs-12" style="padding-right: 0px;">
            Firmante <span class="required">*</span>
        </label>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <select id="signatory" name="signatory" class="select2_single form-control js-example-responsive" style="width: 100%;" tabindex="-1" style="width: 100%;" required="true">
                <option></option>
            </select>
        </div>
    </div>

    <div class="form-group has-feedback">
        <div class="col-md-12">
            <textarea id="add-comment-doc" name="comments" class="comment-area" required="required"></textarea>
        </div>
    </div>

    <div class="form-group has-feedback">

        <div class="col-md-12" style="padding-right: 0px;">

            <button type="submit" class="btn btn-success btn-lg">
                <span class="docs-tooltip">
                    <span class="fa fa-envelope"></span>
                </span>
                Turnar
            </button>
            <button type="reset" class="btn btn-danger btn-lg">Cancelar</button>

        </div>

    </div>

</form>