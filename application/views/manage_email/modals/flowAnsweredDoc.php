<form class="form-horizontal form-label-left input_mask" action="javascript:void(0);" method="post">
                
    <div class="form-group">
        Respuesta al documento<br><b class="folio-doc">Folio Doc</b>
    </div>
    
    <div class="form-group">
        <label class="control-label alignleft">
            Comentario <span class="required">*</span>
        </label>
        <textarea class="col-md-12 col-sm-12 col-xs-12" name="comments" required="required"></textarea>
    </div>
    
    <div class="form-group">

        <div class="alignleft" style="display: inline-block;">

            <label class="btn btn-default btn-upload">
                <input type="file" class="sr-only" name="file" accept=".xls, .xlsx, .doc, .docx, .ppt, .pptx, .pdf">
                <span class="docs-tooltip">
                    <span class="fa fa-paperclip"></span>
                </span>
            </label>

        </div>

        <div class="attachment" style="float: left;"></div>

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