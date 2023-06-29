<form class="form-horizontal form-label-left input_mask" action="javascript:void(0);" method="post" novalidate>
    
    <h2 style="margin: 0px;">
        Necesitas actualizar la contraseña porque se trata de la primera vez que inicias sesión.
    </h2>

    <div class="form-group">
        <label class="control-label col-md-12 col-sm-12 col-xs-12">
            Usuario
        </label>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <input type="text" data-key="username" name="username" class="form-control" value="<?php echo $user;?>" readonly="readonly" />
        </div>
    </div>

    <div class="item form-group">
        <label class="control-label col-md-12 col-sm-12 col-xs-12">
            Contraseña Antigua <span class="required">*</span>
        </label>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <input type="password" data-key="password" name="password" class="form-control" required="required" />
        </div>                                                              
    </div>

    <div class="item form-group">
        <label class="control-label col-md-12 col-sm-12 col-xs-12">
            Nueva Contraseña <span class="required">*</span>
        </label>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <input type="password" data-key="new_pass" name="new_pass" class="form-control" required="required" />
        </div>                                                              
    </div>

    <div class="item form-group">
        <label class="control-label col-md-12 col-sm-12 col-xs-12">
            Confirmar Contraseña <span class="required">*</span>
        </label>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <input type="password" data-key="confirm_pass" name="confirm_pass" data-validate-linked="new_pass" class="form-control" required="required" />
        </div>                                                              
    </div>
    
    <div class="form-group has-feedback">

        <div class="col-md-12 col-sm-12 col-xs-12">

            <button type="submit" class="btn btn-success btn-sm">
                Actualizar
            </button>

        </div>

    </div>

</form>