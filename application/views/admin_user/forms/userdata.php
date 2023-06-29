<form id="user-data" class="form-horizontal form-label-left input_mask" method="post">
    
    <div class="form-group-sm">
        
        <div class="user-img-config">
            
            <aside class="profile_img img-circle">
                
                <section id="profile-img-user" data-default="<?php echo base_url() . "uploads/images/profile/$userData[icon]?timestamp=" . rand(1000, 2000); ?>" style="background-image: url(<?php echo base_url() . "uploads/images/profile/$userData[icon]"; ?>)"></section>
                                
            </aside>
            
        </div>

        <div class="col-md-6">
            <input name="name" data-key="name" class="form-control" value="<?php echo $userData["name"]; ?>" readonly />
            <a data-key="edit-name" href="javascript:void(0);">Editar Nombre</a>
        </div>
        
        <div class="col-md-6 cell-empty"></div>        
        <div class="col-md-6 cell-empty"></div>        
        <div class="col-md-6 cell-empty"></div>
        <div class="col-md-6 cell-empty"></div>
        <div class="col-md-6 cell-empty"></div>
        <div class="col-md-6 cell-empty"></div>
        
        <div class="col-md-6">
            
            <button type="reset" class="btn btn-danger alignright">Cancelar</button>
            
            <button type="submit" class="btn btn-success alignright" disabled>
                <span class="docs-tooltip">
                    <span class="fa fa-envelope"></span>
                </span>
                Guardar
            </button>
            
        </div>
        
    </div>
    
    <div class="form-group">
        <div class="col-md-1"></div>
        <div class="alignleft attachment-left-aling-22" style="display: inline-block;">

            <label class="btn btn-default btn-upload">
                <input type="file" data-key="file" class="sr-only" name="file[]" accept="image/*">
                <span class="docs-tooltip">
                    <span class="fa fa-paperclip"></span>
                    Perfil
                </span>
            </label>

        </div>
        
    </div>
    
</form>