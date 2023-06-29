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
            Tiene documentos pendientes por atender.
            <br>
            <ul>
                <?php
                if ($Asigned > 0){
                ?>
                <li><?php echo $Asigned; ?> documentos asignados pendientes de atender. </li>
                <span style="font-weight: bold;"><?php echo $DocumentsAsigned; ?></span>
                <?php } ?>
                <?php 
                if ($Checking > 0){
                ?>
                <li><?php echo $Checking; ?> documentos pendientes de revisión. </li>
                <span style="font-weight: bold;"><?php echo $DocumentsChecking; ?></span>
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