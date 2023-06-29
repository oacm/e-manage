<form class="form-horizontal form-label-left input_mask" action="javascript:void(0);" method="post">
                
    <div class="form-group">
        ¿Deseas Re Turnar el documento <br> <b class="folio-doc">Folio Doc</b>?
    </div>

    <div class="form-group">
        <label class="control-label col-md-5 col-sm-2 col-xs-12">
            Turnar A <span class="required">*</span>
        </label>
        <div class="col-md-7 col-sm-10 col-xs-12">
            <select id="turned-on" name="area_id" class="select2_single form-control" required="required" tabindex="-1" style="width: 100%;"></select>
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label col-md-1 col-sm-1 col-xs-1">
            CC
        </label>
        <div class="control-label col-md-11 col-sm-11 col-xs-11">
            <select id="cc-returned" name="cc[]" multiple="true" class="select2_single form-control" tabindex="-1" style="width: 100%;"></select>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label alignleft">
            Motivo <span class="required">*</span>
        </label>
        <textarea class="col-md-12 col-sm-12 col-xs-12" name="comments" required="required"></textarea>
    </div>

    <div class="form-group margin-bottom-0">

        <div class="col-md-12 col-sm-2 col-xs-12">

            <button type="submit" class="btn btn-success">
                <span id="label-submit">Continuar</span>
            </button>
            <button type="reset" class="btn btn-danger">Cancelar</button>

        </div>

    </div>

</form>