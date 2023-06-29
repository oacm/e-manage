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
            Tiene documentos pendientes por atender:
            <br>
            <ul>
                <?php
                if ($Answer > 0){
                ?>
                <li>Tiene <?php echo $Answer; ?> documentos pendientes de firma y digitalización. </li>
                <span style="font-weight: bold;"><?php echo $DocAnswer; ?></span>
                <?php } ?>
                <?php 
                if ($Maker > 0){
                ?>
                <li>Tiene <?php echo $Maker; ?> documentos pendientes de elaborar respuesta. </li>
                <span style="font-weight: bold;"><?php echo $DocMaker; ?></span>
                <?php } ?>
            </ul>
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