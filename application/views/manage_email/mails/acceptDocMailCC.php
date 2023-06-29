<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <style>
            body{
                font-family: texta;
            }
        </style>
    </head>
    <body>
        
        <div style="font-size: 1.5em;">
            Se acepto la respuesta al documento <span style="font-weight: bold;"><?php echo "$control_folio"; ?></span> 
            <?php if($onlyRead == 1){ ?>
            .
            <?php }else{ ?>
            , se le asigno el No. de Oficio <span style="font-weight: bold;"><?php echo "$control_folio_out"; ?></span>
            y se encuentra en proceso de firma.
            <?php } ?>
        </div>
        
        <p style="font-size: 1.5em;">
            Puedes revisarlo entrando al siguiente enlace: 
            <br />
            <a href="<?php echo base_url() . "login"; ?>" style="color: #FF8300; text-decoration: none; margin-left: 15px;">
                <?php echo base_url() . "login"; ?>
            </a>
        </p>
        
        
        <?php 
        $this->load->view("tpl_general/signatureMngMail");
        ?>
    </body>
</html>