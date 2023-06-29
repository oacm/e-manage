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
            Se ha turnado un documento a tu área.
            <br>
            Datos del documento: 
            <ul>
                <li>Número de Folio: <span style="font-weight: bold;"><?php echo "$folio"; ?></span></li>
                <li>Número de Control: <span style="font-weight: bold;"><?php echo "$folioDoc"; ?></span></li>
                <li>Asunto: <span style="font-weight: bold;"><?php echo "$subject"; ?></span></li>
                <li>Remitente: <span style="font-weight: bold;"><?php echo "$sender"; ?></span></li>
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