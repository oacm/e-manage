<div id="modal-win-info-<?php echo "$idPanel"; ?>" class="modal" <?php echo (!isset($showModal) ? "" : $showModal) ? "style='display:block;'" : ""; ?>>
    
    <div class="modal-content <?php echo isset($classCss) ? $classCss : ""; ?>">
        <div class='modal-header'>
            <?php if(!isset($enableClose)){ ?><span class='close'>×</span><?php }
            else if(!$enableClose){ ?><span class='close'>×</span><?php } ?>
            <h2><?php echo isset($title) ? $title : ""; ?></h2>
        </div>
        <div class='modal-body <?php echo isset($classSec) ? $classSec : ""; ?>'>
            <?php $this->load->view("$module/$tpl", isset($args) ? $args : NULL); ?>
        </div>
    </div>

</div>