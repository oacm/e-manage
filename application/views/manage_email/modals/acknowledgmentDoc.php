<form class="form-horizontal form-label-left input_mask" action="javascript:void(0);" method="post">
    
    <div class="form-group">
        Adjuntar acuse al documento: <br><b class="folio-doc">Folio Doc</b>
    </div>
    
    <div class="form-group attach-content">

        <div class="alignleft" >
            
            <input type="hidden" data-key="numDocument" name="folio" />
            
            <label class="btn btn-default btn-upload">
                <input type="file" class="sr-only" name="file" accept=".pdf" required="required">
                <span class="docs-tooltip">
                    <span class="fa fa-paperclip"></span>
                </span>
            </label>

        </div>

        <div id="acknowledgmentContainerAttach" class="attachment alignleft"></div>

    </div>
    
    <div class="form-group">
        
        <div class="col-lg-12 text-center">
            <button type="submit" class="btn btn-success">
                <span class="docs-tooltip">
                    <span class="fa fa-check"></span>
                </span>
                Finalizar
            </button>
            <button type="reset" class="btn btn-danger">Cancelar</button>
        </div>
        
    </div>
    
</form>