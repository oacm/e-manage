 
 <div style="padding-bottom: 5px; padding-right: 5px; padding-left: 5px; padding-top: 5px;" id ="contieneunidades" class="container col-xs-14 divScroll">
        
        <?php 
        //echo json_encode( $userStationData);
        //echo json_encode( $userInfoData);

        //echo $userStationData[0]["cat_corp_subsidiary"]; 
        //echo count($userStationData);



        $unidadesver = 0;
        for ($icentrales=0; $icentrales < count($userInfoData) ; $icentrales++) { 
            
        ?>

        <div class="container col-xs-14 ">
  
           

            <fieldset class="scheduler-border">
                <legend class="scheduler-border"><?php echo $userInfoData[$icentrales]["Ener_station"]?></legend>
          
        
        
            <?php 
           echo '<label style="color:black" id="allchec'.$userStationData[$unidadesver]["Ener_rel_acronym"].'"><input type="checkbox"  value="'.$userStationData[$unidadesver]["Ener_rel_acronym"].'" id="allchecval" name="allchecver'.$userStationData[$unidadesver]["Ener_rel_acronym"].'"> Seleccionar Todos  &nbsp;&nbsp;&nbsp;</label><br>';
             
            for($creaunidad = 0; ; ){

                //echo $userInfoData[$icentrales]["cat_corp_subsidiary"];
                //echo $userStationData[$unidadesver]["cat_corp_subsidiary"];

                if ($unidadesver < count($userStationData)) {
                    if ($userInfoData[$icentrales]["cat_corp_subsidiary"] == $userStationData[$unidadesver]["cat_corp_subsidiary"] ) {
                    //echo $userStationData[$unidadesver]["Ener_rel_acronym"];

                    echo  ' 
                    <div class="container col-xs-12 ">
            <label style="color:black" id="labchec'.$userStationData[$unidadesver]["Ener_rel_acronym"].$userStationData[$unidadesver]["Ener_unit"].'"><input type="checkbox"  value="'.$userStationData[$unidadesver]["Ener_rel_acronym"].$userStationData[$unidadesver]["Ener_unit"].'" id="chec'.$userStationData[$unidadesver]["Ener_rel_acronym"].$userStationData[$unidadesver]["Ener_unit"].'"> '.$userStationData[$unidadesver]["Ener_rel_acronym"].$userStationData[$unidadesver]["Ener_unit"].'  &nbsp;&nbsp;&nbsp;</label> </div><div align="center" class="container col-xs-10 "  style="padding-bottom: 0px; padding-right: 5px; padding-left: 5px; padding-top: 7px; background-color: rgb(235, 232, 232); color: rgb(0, 0, 0);" id="divis'.$userStationData[$unidadesver]["Ener_rel_acronym"].$userStationData[$unidadesver]["Ener_unit"].'">
            <div class="form-group col-xs-4" align="left"><label for="inputAddress" id="feinicio"  > Fecha Inicio </label>
            <input  class ="form-control input-sm " style=" width:80%; color:black" type="text" id="fei'.$userStationData[$unidadesver]["Ener_rel_acronym"].$userStationData[$unidadesver]["Ener_unit"].'" name="fechasin" placeholder="//" disabled> </div>
            <div class="form-group col-xs-4" align="left"> <label for="inputAddress" id="febusqueda" > Fecha Fin </label>
            <input class ="form-control input-sm" style="width:80%; color:black" type="text" id="fef'.$userStationData[$unidadesver]["Ener_rel_acronym"].$userStationData[$unidadesver]["Ener_unit"].'" name="fechasfin" placeholder="//" disabled> </div>
            <div class="form-group col-xs-4" align="left"> <label for="inputAddress" id="febusqueda" > Num. Licencia </label>
            <input  class ="form-control input-sm" style="width:80%; color:black" type="text" id="numl'.$userStationData[$unidadesver]["Ener_rel_acronym"].$userStationData[$unidadesver]["Ener_unit"].'" name="numl'.$userStationData[$unidadesver]["Ener_rel_acronym"].$userStationData[$unidadesver]["Ener_unit"].'" placeholder="Licencia" disabled onchange="validaentradalicreg(\'numl'.$userStationData[$unidadesver]["Ener_rel_acronym"].$userStationData[$unidadesver]["Ener_unit"].'\');" onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();"> 
            <input  type="hidden" id="ocul'.$userStationData[$unidadesver]["Ener_rel_acronym"].$userStationData[$unidadesver]["Ener_unit"].'" name="ocul'.$userStationData[$unidadesver]["Ener_rel_acronym"].$userStationData[$unidadesver]["Ener_unit"].'" value="0"></div></div>
        ';    
                    $unidadesver ++;
                    $creaunidad++;
                }
               
                else{
                   break; 
                }
                }
                else
                {
                    break;
                }


                
            }

            ?>

        
           

         
         </fieldset>
  </div>
       
    <?php }?>

        
  
  

        
        
        
        
        </div>
   
    </div>  

