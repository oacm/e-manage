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
            Por el momento el sistema de gestión de correspondencia solo soporta <?php echo $message; ?>.
        </div>
        
        <?php 
        $this->load->view("tpl_general/signatureMngMail");
        ?>
    </body>
</html>