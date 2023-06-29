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
            <span style="font-weight: bold;"><?php echo "$user"; ?></span> 
            rechazo la respuesta al documento <span style="font-weight: bold;"><?php echo "$controlFolio"; ?></span> 
            y realizo la siguientes observaciones:
            <ul>
                <li><span style="font-weight: bold"><?php echo "$comment"?></span></li>
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