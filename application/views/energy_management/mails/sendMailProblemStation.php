<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <style>
            body{
                font-family: texta;
            }
            table{
                color: #2a2a2a;
                background: #fafafa;
            }
            
            table th{
                height: 50px;
                padding: 0 20px;
                border-bottom: 1px solid #cdcdcd;
            }
  
        </style>
    </head>
    <body>
        <?php $typeError = isset($validation["missingHours"]); ?>
        <font style="color: rgb(0, 32, 96); font-size: 1.3em; margin: 0 0 0 15px;"><strong>Informes Fénix</strong></font>
        <br>
        <br>
        <div style="font-size: 1.3em; margin: 0 0 0 15px;">
            Las siguientes estaciones presentan alguna anomalia.            
            <br>
            <br>
            <table>
                <thead>
                    <tr>
                        <th>Estación</th>
                        <th>Problema</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($problemStation as $value){?>
                    <tr>
                        <td><?php echo $value["idDamIGS"]; ?></td>
                        <?php if($value["webService"]){?>
                            <td>El web service <br>
                                http://igscloud.ddns.net/IgsServicios/DatosSensorEx?idAsignado=<?php echo $value["idDamIGS"]; ?>&numeroSensor=0002&horas=<?php echo $value["missingHours"]; ?>&idC=CC5254C6-1E86-4BBD-8D43-65C6DA6550AB
                                <br> No esta disponible.
                            </td>
                        <?php } else if($value["dataNull"] > 0) { ?>
                            <td>
                                Los valores de nivel de agua presentan un <?php echo $value["dataNull"]; ?>% datos iguales a 0 o Nulos.                                
                            </td>
                        <?php } else {?>
                            <td>
                                La estación presenta perdida de datos mayores a <?php echo $value["missingHours"]; ?> hrs.                                
                            </td>
                        <?php } ?>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <br>        
        <?php 
        $this->load->view("tpl_general/signature", array(
            "signatureTitle" => "Atentamente:",
            "phone"          => "T +(52) 55 4163 4350"));
        ?>
    </body>
</html>