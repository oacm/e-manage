<div class="col-md-55">
    <div class="thumbnail">
        <div class="image view view-first">
            <img style="width: 100%; display: block;" src="<?php echo $thumbUrl; ?>" alt="<?php echo $theme ?>" />
            <div class="mask">
                <p><?php echo $theme ?></p>
                <div class="tools tools-bottom">
                    <a href="javascript:void(0);">
                        <i class="fa fa-check" data-antecedent="<?php echo $folioDoc; ?>"></i>
                    </a>
                    <a href="<?php echo base_url() . $docOut; ?>" target="_blank"><i class="fa fa-eye"></i></a>
                </div>
            </div>
        </div>
        <div class="caption">
            <b><?php echo $folioDoc; ?></b>
            <span><?php echo $subject; ?></span>
        </div>
    </div>
</div>