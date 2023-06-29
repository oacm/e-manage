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
            El gerente del área <span style="font-weight: bold;"><?php echo "$area"; ?></span> 
            te ha pedido que elabores una respuesta al documento 
            <span style="font-weight: bold;"><?php echo "$controlFolio"; ?></span> el cual contiene los siguientes datos:
            <ul>
                <li>Asunto: <span style="font-weight: bold;"><?php echo "$subject"; ?></span></li>
                <li>Tema: <span style="font-weight: bold;"><?php echo "$theme"; ?></span></li>
                <li>Vence: <span style="font-weight: bold;"><?php echo "$expiration"; ?></span></li>
                <li>Comentario: <span style="font-weight: bold"><?php echo "$comment"?></span></li>
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