
<div id="modal-win-info-<?php echo "$idPanel"; ?>" class="modal" <?php echo !isset($showModal) ? "" : $showModal ? "style='display:block;'" : ""; ?>>
    
    <div class="modal-content <?php echo isset($classCss) ? $classCss : ""; ?>">
        <div class='modal-header'>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h2><?php echo isset($title) ? $title : ""; ?></h2>

        </div>

        <div class='modal-body <?php echo isset($classSec) ? $classSec : ""; ?>'>
            <?php $this->load->view("$module/$tpl", isset($args) ? $args : NULL); ?>

        

        
         <div class="modal-footer" align="center" >

        <button class="btn btn-success" id="guardaform">Guardar</button>
       
        <button class="btn btn-danger" type="button" id="cancelarform" >Limpiar</button>
        <label style="padding-right: 150px"></label>
        
        <button type="button"  id="cerrarform" class="btn btn-default" >
        <span class="glyphicon glyphicon-remove"></span> Salir
         </button>
        </div>

        </div>
       
    </div>

</div>
