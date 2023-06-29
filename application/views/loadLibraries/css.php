<?php

foreach ($dependences as $value) {
    if(gettype($value) === "string"){
?>
<link href="<?php echo base_url() . $value ?>" rel="stylesheet" />

<?php
    }else{
        ?>
        <link href="<?php echo base_url() . $value["href"] ?>" rel="<?php echo $value["rel"] ?>" type="<?php echo $value["type"] ?>" />
    <?php }
}