<div id="Phistory" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 <?php echo isset($visible) ? "panel-go-to" : ""; ?>" >
                
    <div class="x_panel">

        <div class="x_title">
            <h2>
                <p>Historial</p>
            </h2>
            
            <?php if(isset($extraBtn)){
                foreach ($extraBtn as $btn) {
            ?>
            <button type="button" data-action="<?php echo $btn["action"]; ?>" class="btn btn-default btn-toggle">
                <span class="docs-tooltip">
                    <span class="<?php echo $btn["icon"]; ?>"></span>
                </span>
                <div class="btn-text"><?php echo $btn["text"]; ?></div>
            </button>
            <?php
                }
            } ?>
            
            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <table id="Thistory" class="table table-striped table-bordered dt-responsive nowrap hover <?php echo isset($class) ? $class : ""; ?>" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <?php
                        foreach ($columns as $colum) {
                        ?>
                        <th><?php echo $colum; ?></th>
                        <?php 
                        }
                        ?>
                    </tr>
                </thead>
            </table>
        </div>

    </div>

</div>