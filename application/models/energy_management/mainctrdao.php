<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mainctrDao
 *
 * @author oscar.f.medellin
 */
class mainCtrDao extends VX_Model {
    
    public function __construct() {
        parent::__construct(array("energy"));
        
        $this->load->library("DataTables", "datatables");
        $this->load->library("session");
        $this->load->library("Logging", "logging");
    }
    
    
    
    public function getInfoWorkCenter($idworkcenter) {

         $energy = $this->load->database('energy', TRUE);

         
         $verAdminWC = $idworkcenter["AdminWorkCenter"];
         //$verAdminWC = $idworkcenter["AdminWorkCenter"];

         if (count($verAdminWC)>0) {
            $energy->select("sta.cat_corp_subsidiary,sta.id_Ener_station,sta.Ener_station,sta.id_Ener_account_order,O.Ener_account_order ");
        $energy->from("Ener_station sta");
        $energy->join("Ener_account_order O", "sta.id_Ener_account_order = O.id_Ener_account_order");
        $energy->where_in("sta.cat_corp_subsidiary",  $verAdminWC);
        //$energy->where("sta.cat_corp_subsidiary",  $idworkcenter["WorkCenter"]);

        
        
        $infoWorkcenter = $energy->get();
         }

         else{

                if ($idworkcenter["WorkCenter"] == 1) {
                $energy->select("sta.cat_corp_subsidiary,sta.id_Ener_station,sta.Ener_station,sta.id_Ener_account_order,O.Ener_account_order ");
                $energy->from("Ener_station sta");
                $energy->join("Ener_account_order O", "sta.id_Ener_account_order = O.id_Ener_account_order");
                $infoWorkcenter = $energy->get();
                }
                else{
                $energy->select("sta.id_Ener_station,sta.Ener_station,sta.id_Ener_account_order,O.Ener_account_order ");
                $energy->from("Ener_station sta");
                $energy->join("Ener_account_order O", "sta.id_Ener_account_order = O.id_Ener_account_order");
                $energy->where("sta.cat_corp_subsidiary",  $idworkcenter["WorkCenter"]);
                
                $infoWorkcenter = $energy->get();

                }

    }

        //$this->logging->lfile('application/logs/logws/'.date("DmyHis").'daos.txt');

        //$this->logging->lwrite($energy->last_query());
        
        return $infoWorkcenter->result_array();
    }
    

    ///
    public function getInfoWorkCenterLic($idworkcenter) {

         $energy = $this->load->database('energy', TRUE);

         
         $verAdminWC = $idworkcenter["AdminWorkCenter"];
         //$verAdminWC = $idworkcenter["AdminWorkCenter"];

         if (count($verAdminWC)>0) {
            $energy->select("sta.cat_corp_subsidiary,sta.id_Ener_station,sta.Ener_station,sta.id_Ener_account_order,O.Ener_account_order ");
        $energy->from("Ener_station sta");
        $energy->join("Ener_account_order O", "sta.id_Ener_account_order = O.id_Ener_account_order");
        $energy->where_in("sta.cat_corp_subsidiary",  $verAdminWC);
        //$energy->where("sta.cat_corp_subsidiary",  $idworkcenter["WorkCenter"]);

        
        
        $infoWorkcenter = $energy->get();
         }

         else{

         if ($idworkcenter["WorkCenter"] == 1) {
        $energy->select("sta.cat_corp_subsidiary,sta.id_Ener_station,sta.Ener_station,sta.id_Ener_account_order,O.Ener_account_order ");
        $energy->from("Ener_station sta");
        $energy->join("Ener_account_order O", "sta.id_Ener_account_order = O.id_Ener_account_order");
        $energy->order_by("sta.id_Ener_station", "asc");
        $infoWorkcenter = $energy->get();
         }
        else{
        $energy->select("sta.cat_corp_subsidiary,sta.id_Ener_station,sta.Ener_station,sta.id_Ener_account_order,O.Ener_account_order ");
        $energy->from("Ener_station sta");
        $energy->join("Ener_account_order O", "sta.id_Ener_account_order = O.id_Ener_account_order");
        $energy->where("sta.cat_corp_subsidiary",  $idworkcenter["WorkCenter"]);
        
        $infoWorkcenter = $energy->get();

        }

    }

        //$this->logging->lfile('application/logs/logws/'.date("DmyHis").'daos.txt');

        //$this->logging->lwrite($energy->last_query());
        
        return $infoWorkcenter->result_array();
    }
    ///

    public function getInfoWorkCenterDam($idworkcenter) {

         $energy = $this->load->database('weather', TRUE);

         if ($idworkcenter["WorkCenter"] == 1) {
        $energy->select("id_weather_dam,weather_dam_name");
        $energy->from("weather_dam");
        $infoWorkcenter = $energy->get();
         }
        else{
        $energy->select("id_weather_dam,weather_dam_name");
        $energy->from("weather_dam");
        $energy->where("cat_corp_subsidiary",  $idworkcenter["WorkCenter"]);
        
        $infoWorkcenter = $energy->get();

        }
        
        return $infoWorkcenter->result_array();
    }

    //alejandro 
    public function getInfoWorkCenterDam2($idworkcenter) {

        $energy = $this->load->database('weather', TRUE);

        if ($idworkcenter["WorkCenter"] == 1) {
       /*$energy->select("id_weather_dam,weather_dam_name");
       $energy->from("weather_dam");
       $energy->where("id_weather_dam",9);
       $energy->orWhere("id_weather_dam",11);
       $infoWorkcenter = $energy->get();*/

            
            $infoWorkcenter = $energy->query("select id_weather_dam,weather_dam_name from weather_dam where id_weather_dam in (9,11)");



        }
       else{
       /*$energy->select("id_weather_dam,weather_dam_name");
       $energy->from("weather_dam");
       $energy->where("cat_corp_subsidiary",  $idworkcenter["WorkCenter"]);
       $energy->where("id_weather_dam",9);
       //$energy->orWhere("id_weather_dam = ",11);
       
       $infoWorkcenter = $energy->get();*/

       
            $infoWorkcenter = $energy->query("select id_weather_dam,weather_dam_name from weather_dam where id_weather_dam in (9,11) and cat_corp_subsidiary = ".$idworkcenter["WorkCenter"]." ");

       }
       
       return $infoWorkcenter->result_array();
   }
    
    
    public function getInfoStation($idworkcenter) {

         $energy = $this->load->database('energy', TRUE);


         $verAdminWC = $idworkcenter["AdminWorkCenter"];
         //$verAdminWC = $idworkcenter["AdminWorkCenter"];

         if (count($verAdminWC)>0) {

        $energy->select("`sta`.`cat_corp_subsidiary`,R.id_Ener_unit,R.Ener_rel_acronym,E.Ener_unit,R.id_Ener_rel_stationunit");
        $energy->from("Ener_station sta");
        $energy->join("Ener_account_order O", "sta.id_Ener_account_order = O.id_Ener_account_order");
        $energy->join("Ener_rel_stationunit R", "sta.id_Ener_station = R.id_Ener_station");
        $energy->join("Ener_unit E", "R.id_Ener_unit = E.id_Ener_unit");
        $energy->where_in("sta.cat_corp_subsidiary",  $verAdminWC);
        //$energy->where("sta.cat_corp_subsidiary",  $idworkcenter["WorkCenter"]);
        $stationValues = $energy->get();
         }

            else
            {
         if ($idworkcenter["WorkCenter"] == 1) {
        $energy->select("sta.cat_corp_subsidiary,R.id_Ener_unit,R.Ener_rel_acronym,E.Ener_unit,R.id_Ener_rel_stationunit");
        $energy->from("Ener_station sta");
        $energy->join("Ener_account_order O", "sta.id_Ener_account_order = O.id_Ener_account_order");
        $energy->join("Ener_rel_stationunit R", "sta.id_Ener_station = R.id_Ener_station");
        $energy->join("Ener_unit E", "R.id_Ener_unit = E.id_Ener_unit");
        
        $stationValues = $energy->get();
         }
        else{
        $energy->select("R.id_Ener_unit,R.Ener_rel_acronym,E.Ener_unit,R.id_Ener_rel_stationunit");
        $energy->from("Ener_station sta");
        $energy->join("Ener_account_order O", "sta.id_Ener_account_order = O.id_Ener_account_order");
        $energy->join("Ener_rel_stationunit R", "sta.id_Ener_station = R.id_Ener_station");
        $energy->join("Ener_unit E", "R.id_Ener_unit = E.id_Ener_unit");
        $energy->where("sta.cat_corp_subsidiary",  $idworkcenter["WorkCenter"]);
        
        $stationValues = $energy->get();
         }

        }
         
         // $this->logging->lfile('application/logs/logws/'.date("DmyHis").'daos.txt');

        //echo $energy->last_query();
        return $stationValues->result_array();
    }



    ///
    public function getInfoStationLic($idworkcenter) {

         $energy = $this->load->database('energy', TRUE);


         $verAdminWC = $idworkcenter["AdminWorkCenter"];
         //$verAdminWC = $idworkcenter["AdminWorkCenter"];

         if (count($verAdminWC)>0) {

        $energy->select("`sta`.`cat_corp_subsidiary`,R.id_Ener_unit,R.Ener_rel_acronym,E.Ener_unit,R.id_Ener_rel_stationunit,sta.id_Ener_station");
        $energy->from("Ener_station sta");
        $energy->join("Ener_account_order O", "sta.id_Ener_account_order = O.id_Ener_account_order");
        $energy->join("Ener_rel_stationunit R", "sta.id_Ener_station = R.id_Ener_station");
        $energy->join("Ener_unit E", "R.id_Ener_unit = E.id_Ener_unit");
        $energy->where_in("sta.cat_corp_subsidiary",  $verAdminWC);
        //$energy->where("sta.cat_corp_subsidiary",  $idworkcenter["WorkCenter"]);
        $stationValues = $energy->get();
         }

            else
            {
         if ($idworkcenter["WorkCenter"] == 1) {
        $energy->select("sta.cat_corp_subsidiary,R.id_Ener_unit,R.Ener_rel_acronym,E.Ener_unit,R.id_Ener_rel_stationunit,sta.id_Ener_station");
        $energy->from("Ener_station sta");
        $energy->join("Ener_account_order O", "sta.id_Ener_account_order = O.id_Ener_account_order");
        $energy->join("Ener_rel_stationunit R", "sta.id_Ener_station = R.id_Ener_station");
        $energy->join("Ener_unit E", "R.id_Ener_unit = E.id_Ener_unit");
        
        $stationValues = $energy->get();
         }
        else{
        $energy->select("sta.cat_corp_subsidiary,R.id_Ener_unit,R.Ener_rel_acronym,E.Ener_unit,R.id_Ener_rel_stationunit,sta.id_Ener_station");
        $energy->from("Ener_station sta");
        $energy->join("Ener_account_order O", "sta.id_Ener_account_order = O.id_Ener_account_order");
        $energy->join("Ener_rel_stationunit R", "sta.id_Ener_station = R.id_Ener_station");
        $energy->join("Ener_unit E", "R.id_Ener_unit = E.id_Ener_unit");
        $energy->where("sta.cat_corp_subsidiary",  $idworkcenter["WorkCenter"]);
        
        $stationValues = $energy->get();
         }

        }
         
         // $this->logging->lfile('application/logs/logws/'.date("DmyHis").'daos.txt');

        //$this->logging->lwrite($energy->last_query());
        return $stationValues->result_array();
    }
    ///

    public function postInfoData($idworkcenter,$datExcel,$totDatExcel,$fechainicio,$inputCentral,$inputOrden,$arrayrelunit,$editando) {

         $energy = $this->load->database('energy', TRUE);
        
            


        //$now = date('Y-m-d');
          $now = date('Y-m-d H:i:s');
            $dateMod = str_replace('/', '-', $fechainicio);
            $datenow = strtotime($dateMod);
            $datenowwithformat = date('Y-m-d H:i:s', $datenow);
        $energy->select("count(*)");
        $energy->from("Ener_ep_form");
        $energy->where("DATE(Ener_ep_form_start_date)", $datenowwithformat);
        $energy->where("id_Ener_station",  $inputCentral);
        //$energy->where("id_Ener_ep_user ",  $idworkcenter["employee_id"]);
        $ValuesGet = $energy->get();

        //$this->logging->lfile('application/logs/logws/'.date("DmyHis").'daos.txt');

        //$this->logging->lwrite($energy->last_query());

        foreach ($ValuesGet->result_array() as $row)
       
            if (($row["count(*)"]==0) || ($editando == 1)) {
       
           // $now = date('Y-m-d H:i:s');
            //$dateMod = str_replace('/', '-', $fechainicio);
            //$datenow = strtotime($dateMod);
            //$datenowwithformat = date('Y-m-d H:i:s', $datenow);
            
        $data = array(
            'Ener_ep_form_start_date' => $datenowwithformat,
            'id_Ener_station' => $inputCentral,
            'id_Ener_ep_user' => $idworkcenter["employee_id"],
            'Ener_ep_form_last_date_mod' =>  $now
                    );
         $energy->insert('Ener_ep_form',$data);
         $lastinserts = $energy->insert_id();
        

       


       for ($unidadesc=0; $unidadesc <=$totDatExcel ; $unidadesc++) { 
           
           for ($valorhora=1; $valorhora <=count($datExcel[$unidadesc]) ; $valorhora++) { 


            $tamanovalor = $datExcel[$unidadesc][strval($valorhora)];   
            if (strlen($tamanovalor)==0) {
                 $tamanovalor = 0;

            }

            if ($tamanovalor == "-") {
                $tamanovalor = 0;
            }

               $datas = array(
            'id_Ener_ep_form' => $lastinserts,
            //'id_Ener_rel_stationunit' => $arrayrelunit[$unidadesc],
            'id_Ener_rel_stationunit' => $unidadesc + 1,
            'Ener_ep_offer_sale_hour' => $valorhora,
            'Ener_ep_offer_sale_value' =>  $tamanovalor,
            'Ener_ep_offer_sale_creationdate' => $datenowwithformat 
                    );
         $energy->insert('Ener_ep_offer_sale',$datas);
           }

           if ($valorhora == 25) {
               $datas = array(
            'id_Ener_ep_form' => $lastinserts,
            'id_Ener_rel_stationunit' => $unidadesc + 1,
            //'id_Ener_rel_stationunit' => $arrayrelunit[$unidadesc],
            'Ener_ep_offer_sale_hour' => 25,
            'Ener_ep_offer_sale_value' =>  0,
            'Ener_ep_offer_sale_creationdate' => $datenowwithformat
                    );
         $energy->insert('Ener_ep_offer_sale',$datas);
           }
       }

        
        


        return $lastinserts;


        }
        else{

            return 0;

        }
    }


    /// alejandro castro
    public function postInfoDataTank($idworkcenter,$datExcel,$totDatExcel,$fechainicio,$inputCentral,$inputOrden,$arrayrelunit,$editando) {


        $ret=0;

        $weather = $this->load->database('weather', TRUE);
        $date      = $fechainicio;
        $damID     = $inputCentral;
        $now = date('Y-m-d H:i:s');
        
        $fateQuery=str_replace('/', '-', $date);
        $fateQuerym = strtotime($fateQuery);
        $fateQuerymm = date('Y-m-d', $fateQuerym);

        $weather->select("*", FALSE);
        $result = $weather->get_where("weather_min_form", "weather_min_form_date = '$fateQuerymm' and id_weather_dam = $damID")->result_array();
        
        if (count($result)==0 or ($idworkcenter["employee_id"] == 9 or $idworkcenter["employee_id"]==14)) {
            $ret=1;
            $hr=1;
            foreach($datExcel[0] as $val){
                $dateMod='';
                if ($hr == 24 || $hr==25) {
                    $dateMod = str_replace('/', '-', $date.' 00:00:00');
                }else{
                    $dateMod = str_replace('/', '-', $date.' '.$hr.':00:00');
                }
                
                $datenow = strtotime($dateMod);
                $datenowwithformat = date('Y-m-d H:i:s', $datenow);
                $datas = array(
                    'id_weather_dam' => $damID,
                    'id_weather_min_form_user' => $idworkcenter["employee_id"],
                    'weather_min_form_date' => $datenowwithformat,
                    'weather_min_form_value' => $val,
                    'weather_min_form_month_value' =>  0,
                    'weather_min_form_creado' => $now
                            );
                
                 print_r($weather->insert('weather_min_form',$datas));
                 $hr=$hr+1;
            }
            
        }


        return $ret; 
   }    




///
    public function postInfoDataValida($idworkcenter,$fechainicio,$inputCentral,$inputOrden) {

         $energy = $this->load->database('energy', TRUE);
        
            


        //$now = date('Y-m-d');
        $now = date('Y-m-d H:i:s');
        $dateMod = str_replace('/', '-', $fechainicio);
        $datenow = strtotime($dateMod);
        $datenowwithformat = date('Y-m-d H:i:s', $datenow);
        $energy->select("count(*)");
        $energy->from("Ener_ep_form");
        $energy->where("DATE(Ener_ep_form_start_date)", $datenowwithformat);
        $energy->where("id_Ener_station",  $inputCentral);
        //$energy->where("id_Ener_ep_user ",  $idworkcenter["employee_id"]);
        $ValuesGet = $energy->get();

        //$this->logging->lfile('application/logs/logws/'.date("DmyHis").'daos.txt');

        //$this->logging->lwrite($energy->last_query());

        foreach ($ValuesGet->result_array() as $row)

       return $row["count(*)"];
    }
///  


///alejandro castro
public function postInfoDataValidaDam($idworkcenter,$fechainicio,$inputCentral,$inputOrden) {

    $energy = $this->load->database('weather', TRUE);
   
       


   //$now = date('Y-m-d');
   $now = date('Y-m-d H:i:s');
   $dateMod = str_replace('/', '-', $fechainicio);
   $datenow = strtotime($dateMod);
   $datenowwithformat = date('Y-m-d H:i:s', $datenow);
   $energy->select("count(*)");
   $energy->from("weather_min_form");
   $energy->where("DATE(weather_min_form_date)", $datenowwithformat);
   $energy->where("id_weather_dam",  $inputCentral);
   //$energy->where("id_Ener_ep_user ",  $idworkcenter["employee_id"]);
   $ValuesGet = $energy->get();

   //$this->logging->lfile('application/logs/logws/'.date("DmyHis").'daos.txt');

   //$this->logging->lwrite($energy->last_query());

   foreach ($ValuesGet->result_array() as $row)

  return $row["count(*)"];
}



public function postInfoUpdateData($idworkcenter,$datExcel,$totDatExcel,$fechainicio,$inputCentral,$inputOrden,$arrayrelunit,$resultdataid) {

        
         

          $energy = $this->load->database('energy', TRUE);
        
        $queryejec = "UPDATE Ener_ep_offer_sale SET Ener_ep_offer_sale_value = CASE";
       
            
        $tothoras = 0;
        $queryvalu = "";
        $queryid ="";

        

        //$this->logging->lwrite(json_encode($datExcel));
        //$this->logging->lwrite(json_encode($resultdata));

       for ($unidadesc=0; $unidadesc <=$totDatExcel ; $unidadesc++) { 

         
         
        
          
           for ($valorhora=1; $valorhora <=count($datExcel[$unidadesc]) ; $valorhora++) { 
              
              $tamanovalor = $datExcel[$unidadesc][strval($valorhora)]; 
              if ($tamanovalor == "-") {
                $tamanovalor = 0;
            }
              if (strlen($tamanovalor)==0) {
              //$energy->set('Ener_ep_offer_sale_value',0,false);
              //$queryvalu = $queryvalu.'("0",'.$resultdata[$tothoras]["id_Ener_ep_offer_sale"].'),';

                $queryvalu =$queryvalu. ' WHEN id_Ener_ep_offer_sale ='.$resultdataid[$tothoras].' THEN "0"';
                $queryid = $queryid.$resultdataid[$tothoras].','; 
              }
              else{
               //$energy->set('Ener_ep_offer_sale_value',$datExcel[$unidadesc][strval($valorhora)],false);

              // $queryvalu = $queryvalu.'("'.$datExcel[$unidadesc][strval($valorhora)].'","'.$resultdata[$tothoras]["id_Ener_ep_offer_sale"].'"),';
                $queryvalu = $queryvalu.' WHEN id_Ener_ep_offer_sale ='.$resultdataid[$tothoras].' THEN '.$tamanovalor.'';
                $queryid = $queryid.$resultdataid[$tothoras].',';
           }
               //$energy ->where('id_Ener_ep_offer_sale', $resultdata[$tothoras]["id_Ener_ep_offer_sale"]);
               //$energy ->update('Ener_ep_offer_sale');

            $tothoras++;
           
           
           }

           $queryid = substr($queryid, 0, -1);
        
        $queryejec =  $queryejec.$queryvalu." END "." WHERE id_Ener_ep_offer_sale  in (".$queryid.")";

//        $this->logging->lwrite($queryejec);

        $querye = $energy->query($queryejec);
        $queryvalu ="";
        $queryejec = "UPDATE Ener_ep_offer_sale SET Ener_ep_offer_sale_value = CASE";
        $queryid ="";
       }

       
        
    
       

        return  TRUE;
    }


    public function postInfoUpdateDataSorder($idworkcenter,$datExcel,$totDatExcel,$fechainicio,$inputCentral,$inputOrden,$arrayrelunit,$resultdata) {

          $energy = $this->load->database('energy', TRUE);
        
            
            
        $tothoras = 0;

       for ($unidadesc=0; $unidadesc <=$totDatExcel ; $unidadesc++) { 
           
           for ($valorhora=1; $valorhora <=count($datExcel[$unidadesc]) ; $valorhora++) { 
            $tamanovalor = $datExcel[$unidadesc][strval($valorhora)]; 

            if ($tamanovalor == "-") {
                $tamanovalor = 0;
            }  
            if (strlen($tamanovalor)==0) {
              $energy->set('Ener_ov_offer_sale_value',0,false);
              }
              else{
               $energy->set('Ener_ov_offer_sale_value',$datExcel[$unidadesc][strval($valorhora)],false);
           }
               
               $energy ->where('id_Ener_ov_offer_sale', $resultdata[$tothoras]["id_Ener_ov_offer_sale"]);
               $energy ->update('Ener_ov_offer_sale');

            $tothoras++;
           
           
           }

           
       }

        
        echo $datExcel;
       

        return TRUE;
    }





public function getInfoDatas($idworkcenter,$fechainicio,$inputCentral) {

        

         $energy = $this->load->database('energy', TRUE);

         $dateMod = str_replace('/', '-', $fechainicio);
         $time = strtotime($dateMod);

         $newformat = date('Y-m-d',$time);
        
        $energy->select("EEO.id_Ener_ep_offer_sale,EEF.id_Ener_ep_form,EEO.id_Ener_rel_stationunit,ERS.Ener_rel_acronym,EU.Ener_unit,EEO.Ener_ep_offer_sale_hour, EEO.Ener_ep_offer_sale_value");
        
        $energy->join("Ener_ep_offer_sale EEO", "EEF.id_Ener_ep_form = EEO.id_Ener_ep_form");
        $energy->join("Ener_rel_stationunit ERS", "ERS.id_Ener_rel_stationunit = EEO.id_Ener_rel_stationunit");
        $energy->join("Ener_unit EU", "EU.id_Ener_unit = ERS.id_Ener_unit");
        
        //$energy->where("id_Ener_ep_user ",  $idworkcenter["employee_id"]);

        $energy->order_by("EEO.id_Ener_rel_stationunit","asc");
        $energy->order_by("EEO.Ener_ep_offer_sale_hour","asc");

        
        

        $ValuesGet = $energy->get_where("Ener_ep_form EEF", "EEF.id_Ener_ep_form = (Select max(id_Ener_ep_form) From Ener_ep_form where DATE(Ener_ep_form_start_date) = '$newformat' and `id_Ener_station` = '$inputCentral')");

        //$this->logging->lfile('application/logs/logws/'.date("DmyHis").'daos.txt');

        //$this->logging->lwrite($energy->last_query());
         
        
        return $ValuesGet->result_array();
 
        


      
}
/// alejandro castro
public function getInfoDatasTank($idworkcenter,$fechainicio,$inputCentral) {

    $weather = $this->load->database('weather', TRUE);
    $now = date('Y-m-d H:i:s');
    $dateMod = str_replace('/', '-', $fechainicio);
    $datenow = strtotime($dateMod);
    $datenowwithformat = date('Y-m-d H:i:s', $datenow);
    $weather->select("*");
    $weather->from("weather_min_form");
    $weather->where("DATE(weather_min_form_date)", $datenowwithformat);
    $weather->where("id_weather_dam",  $inputCentral);
    $ValuesGet = $weather->get();
    return $ValuesGet->result_array();
}



    public function getInfoDatasSorder($idworkcenter,$fechainicio,$inputCentral) {

         $energy = $this->load->database('energy', TRUE);

         $dateMod = str_replace('/', '-', $fechainicio);
         $time = strtotime($dateMod);

         $newformat = date('Y-m-d',$time);
         $empadoid = $idworkcenter["employee_id"];
        
        $energy->select("EEO.id_Ener_ov_offer_sale,EEF.id_Ener_ov_form,EEO.id_Ener_rel_stationunit,ERS.Ener_rel_acronym,EU.Ener_unit,EEO.Ener_ov_offer_sale_hour, EEO.Ener_ov_offer_sale_value");
        $energy->from("Ener_ov_form EEF");
        $energy->join("Ener_ov_offer_sale EEO", "EEF.id_Ener_ov_form = EEO.id_Ener_ov_form");
        $energy->join("Ener_rel_stationunit ERS", "ERS.id_Ener_rel_stationunit = EEO.id_Ener_rel_stationunit");
        $energy->join("Ener_unit EU", "EU.id_Ener_unit = ERS.id_Ener_unit");

         $energy->where("EEF.id_Ener_ov_form = (SELECT MAX(EEF.id_Ener_ov_form) FROM Ener_ov_form EEF WHERE DATE(EEF.Ener_ov_form_start_date) <= '$newformat' AND DATE(EEF.Ener_ov_form_end_date) >= '$newformat' AND EEF.id_Ener_station = $inputCentral)");
        $energy->order_by("EEO.id_Ener_rel_stationunit","asc");
        $energy->order_by("EEO.Ener_ov_offer_sale_hour","asc");
        
       
       

        
    
        

        $ValuesGet = $energy->get();

        

        //$this->logging->lfile('application/logs/logws/'.date("DmyHis").'oas.txt');

//      $this->logging->lwrite($energy->last_query());
        
        return $ValuesGet->result_array();
 
        


      
    }


    public function getInfoDataseProduced($idworkcenter,$inputCentral) {

         $energy = $this->load->database('energy', TRUE);
         $now = date('Y-m-d');

         
        
        $energy->select("*");
        $energy->from("Ener_ep_form");
        $energy->where("DATE(Ener_ep_form_last_date_mod)", $now);
        $energy->where("id_Ener_station",  $inputCentral);
        $energy->where("id_Ener_ep_user ",  $idworkcenter["employee_id"]);
        $ValuesGet = $energy->get();

        
        return $ValuesGet->result_array();
 
        


      
    }


    

public function postInfoDataSorder($params) {

    $now          = $this->getCurrentDate();
    $dateStart    = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $params["fechainicio"])));
    $dateEnd      = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $params["fechafin"])));
    $insertValues = array();

    $data = array(
       'Ener_ov_form_start_date'    => $dateStart,
       'Ener_ov_form_end_date'      => $dateEnd,
       'id_Ener_station'            => $params["inputCentral"],
       'id_Ener_ov_user'            => $this->session->userdata("userInfo")["employee_id"],
       'Ener_ov_form_last_date_mod' => $now);
    
    $lastInserts = $this->add('Ener_ov_form',$data, FALSE, "energy");
    
    foreach($params["headerExcel"] as $kHead => $unitI){
        
        $unitId       = explode("-", $unitI);
        $unitValues   = $params["datExcel"][$kHead];
        
        if(count($unitValues) == 24){$unitValues[25] = 0;}
        
        foreach($unitValues as $hour => $val){
            $valueOffer     = (strlen($val) == 0 || $val == "-") ? 0 : floatval($val);
            $insertValues[] = array(
                'id_Ener_ov_form'                 => $lastInserts,
                'id_Ener_rel_stationunit'         => intval(str_replace("U","0",$unitId[count($unitId) - 1])),
                'Ener_ov_offer_sale_hour'         => $hour,
                'Ener_ov_offer_sale_value'        => $valueOffer,
                'Ener_ov_offer_sale_creationdate' => $now
            );
        }
    }
    
    $this->addBatch('Ener_ov_offer_sale',$insertValues, FALSE, "energy");
    
    return 0;
}



////
 public function postInfoDataElicenses($idworkcenter,$dataLicencias) {

         $energy = $this->load->database('energy', TRUE);
        
           $rangorepetido=0; 

         $jObjLic = json_decode($dataLicencias);

         if (count($jObjLic->valoreslic) == 0) 
         {
              return array(400, 0);
         }

         else
         {
            
            
            for ($recorre=0; $recorre < count($jObjLic->valoreslic); $recorre++) 
            { 
              
           $now = date('Y-m-d H:i:s');
                        $dateMod = str_replace('/', '-', $jObjLic->valoreslic[$recorre]->fechainicio);
                        $datenow = strtotime($dateMod);
                        $datenowwithformat = date('Y-m-d H:i:s', $datenow);
                        $dateMod2 = str_replace('/', '-', $jObjLic->valoreslic[$recorre]->fechafinal);
                        $datenow2 = strtotime($dateMod2);
                        $datenowwithformat2 = date('Y-m-d H:i:s', $datenow2);


                $where_date = "((date_start BETWEEN '".$datenowwithformat."' AND '".$datenowwithformat2."') OR (date_end BETWEEN '".$datenowwithformat."' AND '".$datenowwithformat2."'))";
                $energy->select("count(*)");
                $energy->from("Ener_licenses_unit");
                $energy->where($where_date);
                $energy->where("station_id", $jObjLic->valoreslic[$recorre]->estacion);
                $energy->where("unit_id",  $jObjLic->valoreslic[$recorre]->unidad);
                $energy->where("active",  "1");
                $ValuesGet = $energy->get();

               // $this->logging->lfile('application/logs/logws/'.date("DmyHis").'nomas.txt');

                //$this->logging->lwrite($energy->last_query());


                $now = date('Y-m-d H:i:s');
                        $dateMod = str_replace('/', '-', $jObjLic->valoreslic[$recorre]->fechainicio);
                        $datenow = strtotime($dateMod);
                        $datenowwithformat = date('Y-m-d H:i:s', $datenow);
                        $dateMod2 = str_replace('/', '-', $jObjLic->valoreslic[$recorre]->fechafinal);
                        $datenow2 = strtotime($dateMod2);
                        $datenowwithformat2 = date('Y-m-d H:i:s', $datenow2);

                 foreach ($ValuesGet->result_array() as $row)


               
                    if ($row["count(*)"]==0) 
                    {

                        

                        $datas = array(
                    'station_id' => $jObjLic->valoreslic[$recorre]->estacion,
                    'unit_id' => $jObjLic->valoreslic[$recorre]->unidad,
                    'date_start' => $datenowwithformat,
                    'date_end' =>   $datenowwithformat2,
                    'num_license' => $jObjLic->valoreslic[$recorre]->licencia,
                    'active' => 1,
                    'user_creation' => $idworkcenter["employee_id"],
                    'date_creation' => $now,
                    'user_modification' => $idworkcenter["employee_id"], 
                    'date_modification' => $now, 
                    'observations' => "" 
                            );
                 $energy->insert('Ener_licenses_unit',$datas);

                 

                    }

                    else
                    {
                        $rangorepetido++;
                        $jObjLic->valoreslic[$recorre]->procesado = "1";
                       //$energy->set('date_start',$datenowwithformat);
                       //$energy->set('date_end',$datenowwithformat2);
                       //$energy->set('num_license',$jObjLic->valoreslic[$recorre]->licencia);
                       //$energy->set('active',1);
                       //$energy->set('user_modification',$idworkcenter["employee_id"]);
                       //$energy->set('date_modification',$now);
                       //$energy->where("station_id", $jObjLic->valoreslic[$recorre]->estacion);
                       //$energy->where("unit_id",  $jObjLic->valoreslic[$recorre]->unidad);
                       //$energy ->update('Ener_licenses_unit');

                        //$this->logging->lfile('application/logs/logws/'.date("DmyHis").'DAos.txt');

                        //$this->logging->lwrite($energy->last_query());
                        
                    }


             }
        //$energy->select("CONCAT((ERS.Ener_rel_acronym),(EU.Ener_unit)) as unidades,DATE_FORMAT(ELU.date_start,'%d/%m/%Y') as fechainicio,DATE_FORMAT(ELU.date_end,'%d/%m/%Y') as fechafin,ELU.num_license", FALSE);
        //$energy->from("Ener_licenses_unit ELU");
        //$energy->join("Ener_unit EU", "ELU.unit_id = EU.id_Ener_unit");
        //$energy->join("Ener_station ES", "ELU.station_id = ES.cat_corp_subsidiary");
        //$energy->join("Ener_rel_stationunit ERS", "ERS.id_Ener_station = ES.id_Ener_station AND ERS.id_Ener_unit = ELU.unit_id ");
        //$energy->where_in("ELU.active", 1);
        //$energy->order_by("ERS.Ener_rel_acronym", "asc");
        //$infoWorkcenter = $energy->get();
         
        //$this->logging->lfile('application/logs/logws/'.date("DmyHis").'logos.txt');

        //$this->logging->lwrite($energy->last_query());
        //return $infoWorkcenter->result_array();
             
            return array($rangorepetido, $jObjLic);

         }

        
        //return  $jObjLic->valoreslic[0]->estacion;
         //return count($jObjLic->valoreslic);
    }


    public function postActualInfoDataElicenses($idworkcenter,$idunidadactualiar,$actualizafei,$actualizafefin,$estacionval,$unidadval) {

         $energy = $this->load->database('energy', TRUE);
        
            

/////
                        $now = date('Y-m-d H:i:s');
                        $dateMod = str_replace('/', '-', $actualizafei);
                        $datenow = strtotime($dateMod);
                        $datenowwithformat = date('Y-m-d H:i:s', $datenow);
                        $dateMod2 = str_replace('/', '-', $actualizafefin);
                        $datenow2 = strtotime($dateMod2);
                        $datenowwithformat2 = date('Y-m-d H:i:s', $datenow2);


                $where_date = "((date_start BETWEEN '".$datenowwithformat."' AND '".$datenowwithformat2."') OR (date_end BETWEEN '".$datenowwithformat."' AND '".$datenowwithformat2."'))";
                $energy->select("count(*)");
                $energy->from("Ener_licenses_unit");
                $energy->where($where_date);
                $energy->where("station_id", $estacionval);
                $energy->where("unit_id",  $unidadval);
                $energy->where("active",  "1");
                
                $ValuesGet = $energy->get();

               $this->logging->lfile('application/logs/logws/'.date("DmyHis").'nomas.txt');

                $this->logging->lwrite($energy->last_query());

                 foreach ($ValuesGet->result_array() as $row)

                    $totalcount = $row["count(*)"];
               
                    if ($totalcount == 0) 
                    {

/////


                        
                        
                       $energy->set('date_start',$datenowwithformat);
                       $energy->set('date_end',$datenowwithformat2);
                       $energy->set('user_modification',$idworkcenter["employee_id"]);
                       $energy->set('date_modification',$now);
                       $energy->where("id_Ener_licenses_unit", $idunidadactualiar);
                       $energy ->update('Ener_licenses_unit');

                       // $this->logging->lfile('application/logs/logws/'.date("DmyHis").'DAos.txt');

                        //$this->logging->lwrite($energy->last_query());
                        
                    return 1;

                }
                else
                {
                    /////
                    $now = date('Y-m-d H:i:s');
                        $dateMod = str_replace('/', '-', $actualizafei);
                        $datenow = strtotime($dateMod);
                        $datenowwithformat = date('Y-m-d H:i:s', $datenow);
                        $dateMod2 = str_replace('/', '-', $actualizafefin);
                        $datenow2 = strtotime($dateMod2);
                        $datenowwithformat2 = date('Y-m-d H:i:s', $datenow2);


                $where_date = "((date_start BETWEEN '".$datenowwithformat."' AND '".$datenowwithformat2."') OR (date_end BETWEEN '".$datenowwithformat."' AND '".$datenowwithformat2."'))";
                $energy->select("count(*)");
                $energy->from("Ener_licenses_unit");
                $energy->where($where_date);
                $energy->where("id_Ener_licenses_unit", $idunidadactualiar);
                
                
                $ValuesGet = $energy->get();

                

                 foreach ($ValuesGet->result_array() as $row)
                    ////
                    if ($totalcount == $row["count(*)"]) 
                    {
                        $energy->set('date_start',$datenowwithformat);
                       $energy->set('date_end',$datenowwithformat2);
                       $energy->set('user_modification',$idworkcenter["employee_id"]);
                       $energy->set('date_modification',$now);
                       $energy->where("id_Ener_licenses_unit", $idunidadactualiar);
                       $energy ->update('Ener_licenses_unit');

                       return 1;
                    }
                    else
                    {
                        return 0;
                    }

                }
             

        
        //return  $jObjLic->valoreslic[0]->estacion;
         //return count($jObjLic->valoreslic);
    }

    public function getInfoDataElicenses($idworkcenter) 
    {
        $energy = $this->load->database('energy', TRUE);
        $energy->select("CONCAT((ERS.Ener_rel_acronym),(EU.Ener_unit)) as unidades,DATE_FORMAT(ELU.date_start,'%d/%m/%Y %H:%i') as fechainicio,DATE_FORMAT(ELU.date_end,'%d/%m/%Y %H:%i') as fechafin,ELU.num_license", FALSE);
        $energy->from("Ener_licenses_unit ELU");
        $energy->join("Ener_unit EU", "ELU.unit_id = EU.id_Ener_unit");
        $energy->join("Ener_station ES", "ELU.station_id = ES.cat_corp_subsidiary");
        $energy->join("Ener_rel_stationunit ERS", "ERS.id_Ener_station = ES.id_Ener_station AND ERS.id_Ener_unit = ELU.unit_id ");
        $energy->where_in("ELU.active", 1);
        $energy->order_by("ERS.Ener_rel_acronym", "asc");
        $infoWorkcenter = $energy->get();
         
        $this->logging->lfile('application/logs/logws/'.date("DmyHis").'logos.txt');

        $this->logging->lwrite($energy->last_query());
        return $infoWorkcenter->result_array();
    }

    public function getInfoDataElicensesopciones($idworkcenter,$buscarpor,$inputCentralval,$inputUnidadesval,$fechainicioval,$fechafinval,$optradioval,$numlicinputval) 
    {
        

        $now = date('Y-m-d H:i:s');
                        $dateMod = str_replace('/', '-', $fechainicioval);
                        $datenow = strtotime($dateMod);
                        $datenowwithformat = date('Y-m-d H:i:s', $datenow);
                        $dateMod2 = str_replace('/', '-', $fechafinval);
                        $datenow2 = strtotime($dateMod2);
                        $datenowwithformat2 = date('Y-m-d H:i:s', $datenow2);



        $energy = $this->load->database('energy', TRUE);
        $energy->select("ELU.id_Ener_licenses_unit,CONCAT((ERS.Ener_rel_acronym),(EU.Ener_unit)) as unidades,DATE_FORMAT(ELU.date_start,'%d/%m/%Y %H:%i') as fechainicio,DATE_FORMAT(ELU.date_end,'%d/%m/%Y %H:%i') as fechafin,ELU.num_license,ELU.active,ELU.station_id,ELU.unit_id", FALSE);
        $energy->from("Ener_licenses_unit ELU");
        $energy->join("Ener_unit EU", "ELU.unit_id = EU.id_Ener_unit");
        $energy->join("Ener_station ES", "ELU.station_id = ES.id_Ener_station");
        $energy->join("Ener_rel_stationunit ERS", "ERS.id_Ener_station = ES.id_Ener_station AND ERS.id_Ener_unit = ELU.unit_id ");
        
        if ($buscarpor == 0) 
        {
            
        
        $energy->where_in("ELU.station_id", $inputCentralval);
            
        if ($inputUnidadesval!=0) {
        $energy->where_in("ELU.unit_id", $inputUnidadesval);
        }
        $energy->where("DATE(ELU.date_start) >=", $datenowwithformat);
        $energy->where("DATE(ELU.date_start) <=", $datenowwithformat2);
        $energy->where("DATE(ELU.date_end) >=", $datenowwithformat);
        $energy->where("DATE(ELU.date_end) <=", $datenowwithformat2);
        if ($optradioval!=2) {
        $energy->where_in("ELU.active", $optradioval);
        }

        }
        else
        {
         $energy->where("ELU.num_license", $numlicinputval);  
        }


        $energy->order_by("ERS.Ener_rel_acronym", "asc");
        $infoWorkcenter = $energy->get();
         
       
        return $infoWorkcenter->result_array();
    }



    public function getInfoDataElicensesopcionesTodas($idworkcenter,$buscarpor) 
    {
        

       $jsonunidades = json_decode($buscarpor);



        $energy = $this->load->database('energy', TRUE);
        $energy->select("ELU.id_Ener_licenses_unit,CONCAT((ERS.Ener_rel_acronym),(EU.Ener_unit)) as unidades,DATE_FORMAT(ELU.date_start,'%d/%m/%Y %H:%i') as fechainicio,DATE_FORMAT(ELU.date_end,'%d/%m/%Y %H:%i') as fechafin,ELU.num_license,ELU.active,ELU.station_id,ELU.unit_id", FALSE);
        $energy->from("Ener_licenses_unit ELU");
        $energy->join("Ener_unit EU", "ELU.unit_id = EU.id_Ener_unit");
        $energy->join("Ener_station ES", "ELU.station_id = ES.id_Ener_station");
        $energy->join("Ener_rel_stationunit ERS", "ERS.id_Ener_station = ES.id_Ener_station AND ERS.id_Ener_unit = ELU.unit_id ");
        for ($recorre=0; $recorre < count($jsonunidades); $recorre++) { 

            if ($recorre == 0) 
            {
           $energy->where("ELU.station_id", $jsonunidades[$recorre]->id_Ener_station);
           //$energy->where("ELU.unit_id", $jsonunidades[$recorre]->id_Ener_station);
            }

           $energy->or_where("ELU.station_id", $jsonunidades[$recorre]->id_Ener_station);
           //$energy->where("ELU.unit_id", $jsonunidades[$recorre]->id_Ener_station);

        }

        $energy->where_in("ELU.active", 1);
        $energy->order_by("ERS.Ener_rel_acronym", "asc");
        $infoWorkcenter = $energy->get();
         
        $this->logging->lfile('application/logs/logws/'.date("DmyHis").'Today.txt');

        $this->logging->lwrite($energy->last_query());
        return $infoWorkcenter->result_array();  
       
        
    }

////

public function postInfoDataWturbine($idworkcenter,$fechainicio,$inputCentral,$inputValor,$inputValorMes) {

         $energy = $this->load->database('weather', TRUE);
        
            $now = date('Y-m-d H:i:s');

            $dateMod = str_replace('/', '-', $fechainicio);
            $datenow = strtotime($dateMod);
            $datenowwithformat = date('Y-m-d H:i:s', $datenow);
            
            
        $data = array(
            
            
            'id_weather_dam' => $inputCentral,
            'id_weather_min_form_user' => $idworkcenter["employee_id"],
            'weather_min_form_date' => $datenowwithformat,
            'weather_min_form_value' =>  $inputValor,
            'weather_min_form_month_value' =>  $inputValorMes,
            'weather_min_form_creado' =>  $now
                    );
         $energy->insert('weather_min_form',$data);
         $lastinserts = $energy->insert_id();
        

       


        return $lastinserts;
    }


    public function postInfoDataWturbineupdate($idworkcenter,$fechainicio,$inputCentral,$inputValor,$inputValorMes) {

         $energy = $this->load->database('weather', TRUE);
        
            $now = date('Y-m-d');

            $dateMod = str_replace('/', '-', $fechainicio);
            $datenow = strtotime($dateMod);
            $datenowwithformat = date('Y-m-d', $datenow);
            


            $energy->set('weather_min_form_value',$inputValor,false);
            $energy->set('weather_min_form_month_value',$inputValorMes,false);
               $energy->where("id_weather_dam", $inputCentral);
               $energy->where("DATE(weather_min_form_date)", $datenowwithformat); 
               $energy->where("id_weather_min_form_user", $idworkcenter["employee_id"]);
               $energy ->update('weather_min_form');

            
        
        

       


        return 1;
    }



    public function getInfoDataWturbine($idworkcenter,$fechainicio,$inputCentral) {

         $energy = $this->load->database('weather', TRUE);
        
            $now = date('Y-m-d');

            $dateMod = str_replace('/', '-', $fechainicio);
            $datenow = strtotime($dateMod);
            $datenowwithformat = date('Y-m-d', $datenow);
            
            
        

       $infoWorkcenter = $energy->query("SELECT weather_min_form_value,weather_min_form_month_value, CASE WHEN DATE(weather_min_form_date)!= DATE(CURDATE()) THEN IF (MONTH(weather_min_form_date) = MONTH(CURDATE()),1,0) WHEN MONTH(weather_min_form_date) = MONTH(CURDATE()) THEN 1 ELSE 0 END AS weather_min_form_date FROM (`weather_min_form`) WHERE `id_weather_dam` = '".$inputCentral."' AND DATE(weather_min_form_date) = '".$datenowwithformat."' AND `id_weather_min_form_user` = '".$idworkcenter["employee_id"]."'");
        
        

       // $this->logging->lfile('application/logs/logws/'.date("DmyHis").'Today.txt');

        //$this->logging->lwrite($energy->last_query());

        $row = $infoWorkcenter->row(); 
        $resulRow = -1;

        if (count($infoWorkcenter->result_array())!=0) {

            $resultFecha =  $row->weather_min_form_date;  

            if ($resultFecha == 0) {
                $valordelmes = $row->weather_min_form_month_value;
            }

            else
            {
              $valordelmes = $row->weather_min_form_month_value;
            }

             


            $resulRow = [0,$row->weather_min_form_value,$valordelmes];


        }
        else{

            $infoWorkcenterMonth = $energy->query("SELECT weather_min_form_date AS ultima ,weather_min_form_month_value, CASE WHEN DATE( MAX(weather_min_form_date))!= DATE(CURDATE()) THEN IF (MONTH( MAX(weather_min_form_date)) = MONTH(CURDATE()),1,0) WHEN MONTH( MAX(weather_min_form_date)) = MONTH(CURDATE()) THEN 1 ELSE 0 END AS tipofecha  FROM (`weather_min_form`) WHERE id_weather_min_form = (SELECT MAX(id_weather_min_form) FROM (`weather_min_form`) WHERE `id_weather_dam` = '".$inputCentral."' AND `id_weather_min_form_user` = '".$idworkcenter["employee_id"]."'
)");

             $row = $infoWorkcenterMonth->row(); 
        //$this->logging->lfile('application/logs/logws/'.date("DmyHis").'Today.txt');

        //$this->logging->lwrite($energy->last_query());

             $resultFechaM =  $row->tipofecha;  

              if ($resultFechaM == 0) {
                $valordelmes = 0.0;
            }

            else
            {
              $valordelmes = $row->weather_min_form_month_value;
            }


             $resulRow = [1,$valordelmes];
        }

        return $resulRow;
        
        
        
    }

    public function getInfoDatesWturbine($idworkcenter,$inputCentral) {

         $energy = $this->load->database('energy', TRUE);
        
            
            
            
        $energy->select_max("Ener_ov_form_end_date");
        $energy->from("Ener_ov_form");
        $energy->where("id_Ener_station", $inputCentral);
        //$energy->where("id_Ener_ov_user", $idworkcenter["employee_id"]);

        $infoWorkcenter = $energy->get();

        $row = $infoWorkcenter->row(); 
        $resulRow = -1;

        if (strlen($row->Ener_ov_form_end_date)>=10) {
            $resulRow = $row->Ener_ov_form_end_date;
            $resulRow = date('d/m/Y', strtotime($resulRow . ' +1 day'));

        }
        else{

             $resulRow = -1;
        }

        return $resulRow;
        
        
        
    }




    
}