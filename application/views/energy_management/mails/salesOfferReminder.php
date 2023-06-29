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
        <font style="color: rgb(0, 32, 96); font-size: 1.3em; margin: 0 0 0 15px;"><strong>Informes Fénix</strong></font>
        <br>
        <br>
        <div style="font-size: 1.3em; margin: 0 0 0 15px;">
            Para su información se le muestra el Estatus General de las Ofertas de Venta registradas para los siguientes Informes:
            <br>
            <br>            
            <?php 
            foreach($salesOffer as $sale){
                $cols = $sale["Columns"];
                $info = $sale["ResultSet"];
            ?>
            <table>
                <thead>
                    <tr>
                        <th colspan="3"> Datos para Informe Diario del Día <?php echo $cols[2]; ?></th> 
                    </tr>
                    <tr>
                        <th>Planta</th>
                        <th>Oferta de Venta de <br> <?php echo $cols[1]; ?></th>
                        <th>Oferta de Venta de <br> <?php echo $cols[2]; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($info as $rs){?>
                    <tr>
                        <td><?php echo $rs["Ener_station"]; ?></td>
                        <td style="text-align: center;">
                            <?php if($rs[$cols[1]] == 0){ ?>
                            <img src="<?php echo base_url() . "assets/images/cancelMark.png"; ?>" width="25"/>
                            <?php } else { ?>
                            <img src="<?php echo base_url() . "assets/images/checkMark.png"; ?>" width="25" />
                            <?php } ?>
                        </td>
                        <td style="text-align: center;">
                            <?php if($rs[$cols[2]] == 0){ ?>
                            <img src="<?php echo base_url() . "assets/images/cancelMark.png"; ?>" width="25" />
                            <?php } else { ?>
                            <img src="<?php echo base_url() . "assets/images/checkMark.png"; ?>" width="25" />
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php } ?>
        </div>
        <br>        
        <?php 
        $this->load->view("tpl_general/signature", array(
            "signatureTitle" => "Atentamente:",
            "phone"          => "T +(52) 55 4163 4350"));
        ?>
    </body>
</html>