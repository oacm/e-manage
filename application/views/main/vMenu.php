<div class="row top_tiles">
    <div class="animated flipInY col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <?php
        foreach ($buttons as $value) {
            ?>

            <a id="B<?php echo $value["name"] ?>" href="javascript:void(0);" class="btn btn-app btn-go-to <?php echo $value["active"] ? "btn-active" : ""; ?>" <?php echo "data-panel='P$value[name]'";?> >
                <span class="badge bg-red"></span>
                <i class="<?php echo "$value[icon]"; ?>"></i>
                <p><?php echo "$value[label]"; ?></p>
            </a>
        <?php } ?>
    </div>
</div>