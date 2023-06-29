<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of systemdao
 *
 * @author oscar.f.medellin
 */
class SystemDao extends VX_Model {
        
    public function __construct() {
        parent::__construct();
//        $this->db2 = $this->load->database('energy', TRUE);
    }
    
    public function activeCurrentLicenses(){  
        
        $this->db2 = $this->load->database('energy', TRUE);
        
        $this->db2->select("station_id as id_Ener_station, unit_id as id_Ener_unit", FALSE);
        $this->db2->where("now() between date_start and date_end", NULL, FALSE);
        
        $statement = $this->db2->get("Ener_licenses_unit");
        
        return $statement ? $statement->result_array() : array("error" => TRUE);
    }
    
    public function updateCurrentLicenses($licenses){
        
        $this->db2 = $this->load->database('energy', TRUE);
        
        if(count($licenses) == 0){
            echo "\n\nNo existen licencias activas -> " . $this->getCurrentDate();
        }
                
        $this->db2->update("Ener_rel_stationunit", array("Available_now" => 1));
        
        foreach ($licenses as $value) {
            $where = $value;
            $this->db2->update("Ener_rel_stationunit", array("Available_now" => 0), $where);
        }
        
        echo "\n\nSe registrarón " . count($licenses) . " licencias activas -> " . $this->getCurrentDate();
        return;
    }
    
    public function updateLicensesExpired(){
        
        $this->db2 = $this->load->database('energy', TRUE);
        
        $data = array(
            "user_modification" => 0,
            "date_modification" => $this->getCurrentDate(),
            "active"            => 0);
        
        $this->db2->where("date_end < now() and active = 1", NULL, FALSE);
        $this->db2->update("Ener_licenses_unit", $data);
        
        echo "\n\nSe encontrarón " . $this->db2->affected_rows() . " licencias que ya expirarón " . $this->getCurrentDate();
    }
    
    public function updateUnitLicenses(){
        
        $this->db2 = $this->load->database('energy', TRUE);
        
        $this->db2->select("id_Ener_rel_stationunit, Available_now");
        $units = $this->db2->get("Ener_rel_stationunit");
        
        foreach ($units->result_array() as $unit) {
            $this->db2->update("Ener_rel_stationunit", 
                    array("Available_yesterday" => $unit["Available_now"]), 
                    array("id_Ener_rel_stationunit" => $unit["id_Ener_rel_stationunit"]));
        }
        
        echo "\n\n Se realizo la actualización de las maquinas con licencia";
    }
    
    public function getSalesOfferInfo($dateArray){
        
        $this->db2 = $this->load->database('energy', TRUE);
        
        $res = array();
        
        foreach ($dateArray as $date) {
            
            $date1 = $date->format("Y-m-d 12:00:00");$d1 = $date->format("Y-m-d");
            $date2 = $date->sub(new DateInterval("P1D"))->format("Y-m-d 12:00:00"); $d2 = $date->format("Y-m-d");
            
            $join = <<<JOIN
(select 
    max(of.id_Ener_ov_form) AS id_Ener_ov_form,
    of.id_Ener_station
from Ener_station es
    join Ener_ov_form of ON of.id_Ener_station = es.id_Ener_station
where '$date2' between of.Ener_ov_form_start_date and of.Ener_ov_form_end_date + interval 1 day
group by es.Ener_station) oi
JOIN;
            $join2 = <<<JOIN
(select 
    max(of.id_Ener_ov_form) AS id_Ener_ov_form,
    of.id_Ener_station
from Ener_station es
    join Ener_ov_form of ON of.id_Ener_station = es.id_Ener_station
where '$date1' between of.Ener_ov_form_start_date and of.Ener_ov_form_end_date + interval 1 day
group by es.Ener_station) oo
JOIN;
            
            $this->db2->select("es.Ener_station, coalesce(oi.id_Ener_station, false) as '$d2', coalesce(oo.id_Ener_station, false) as '$d1'", FALSE);
            $this->db2->join($join, "oi.id_Ener_station = es.id_Ener_station", "left");
            $this->db2->join($join2, "oo.id_Ener_station = es.id_Ener_station", "left");
            
            $resultSet = $this->db2->get("Ener_station es");
            
            $res[] = array(
                "ResultSet" => $resultSet->result_array(), 
                "Columns"   => $resultSet->list_fields());
            
        }
        
        return $res;
        
    }
    
    public function getAveragePriceDay($monthStart, $dayStart, $monthEnd, $dayEnd){
        $getAvgPriceDay = $this->db->query("call get_average_price_day('$monthStart', '$dayStart', '$monthEnd', '$dayEnd');");
        return $getAvgPriceDay->result_array();
    }
    
    public function getMonthlyBudget(){
        $getMonthlyBudget = $this->db->query("call get_monthly_budget()");
        return $getMonthlyBudget->result_array();
    }
    
    public function getPriceDay($month, $day){
        $getPriceDay = $this->db->query("call get_price_day('$month', '$day')");
        return $getPriceDay->result_array();
    }
    
    public function getDailyReportDamInfo(){
        
        $this->db2 = $this->load->database('weather', TRUE);
        
        $getDailyReportDamInfo = $this->db2->get("daily_report_dam_info");        
        return $getDailyReportDamInfo->result_array();
    }
    
    public function getCurrentEnergyProduced(){
        $this->db2 = $this->load->database('energy', TRUE);
        
        $this->db2->select("'OPH-' AS Aux1, es.acronim AS 'Aux2', date_format(ef.Ener_ep_form_start_date, '%d') AS Dia,	"
                . "date_format(ef.Ener_ep_form_start_date, '%m') AS Mes, ef.Ener_ep_form_start_date AS Fecha, "
                . "eo.Ener_ep_offer_sale_hour AS Hora, es.Ener_station AS Planta, ers.id_Ener_unit AS Unidad, "
                . "eo.Ener_ep_offer_sale_value AS EnergiaProducida", FALSE);
        
        $this->db2->join("Ener_ep_form ef", "ef.id_Ener_station = es.id_Ener_station");
        $this->db2->join("last_date_ep_ov ld2", "ld2.LastDateEP = ef.id_Ener_ep_form");
        $this->db2->join("Ener_ep_offer_sale eo", "eo.id_Ener_ep_form = ef.id_Ener_ep_form");
        $this->db2->join("Ener_rel_stationunit ers", "ers.id_Ener_unit = eo.id_Ener_rel_stationunit and ers.id_Ener_unit = eo.id_Ener_rel_stationunit and es.id_Ener_station = ers.id_Ener_station");
        
        $this->db2->order_by("es.Ener_station", "ASC"); $this->db2->order_by("ers.id_Ener_unit", "ASC"); $this->db2->order_by("eo.Ener_ep_offer_sale_hour", "ASC");
        
        $producedEnergy = $this->db2->get("Ener_station es")->result_array();
        
        return $producedEnergy;
    }
    
    public function getHistoryEnergyProduced($dateInfo, $station, $unit){
        
        $this->db2      = $this->load->database('energy', TRUE);
        
        $getDataHistory = $this->db2->query("call history_produced_offer_energy('produced', '$dateInfo', $station, $unit)");
        return $getDataHistory->result_array();
    }
    
    public function getCurrentOfferSale(){
        $this->db2 = $this->load->database('energy', TRUE);
        
        $this->db2->select("oos.Ener_ov_offer_sale_hour AS Hora, es.Ener_station AS Planta, ers.id_Ener_unit AS Unidad, "
                . "oos.Ener_ov_offer_sale_value AS OfertaVenta", FALSE);
        
        $this->db2->join("Ener_ov_form eofv", "eofv.id_Ener_station = es.id_Ener_station");
        $this->db2->join("last_date_ep_ov ld", "ld.LastDateOV = eofv.id_Ener_ov_form");
        $this->db2->join("Ener_ov_offer_sale oos", "oos.id_Ener_ov_form = eofv.id_Ener_ov_form");
        $this->db2->join("Ener_rel_stationunit ers", "ers.id_Ener_unit = oos.id_Ener_rel_stationunit and "
                . "ers.id_Ener_unit = oos.id_Ener_rel_stationunit and es.id_Ener_station = ers.id_Ener_station");
        
        $this->db2->order_by("es.Ener_station", "ASC"); $this->db2->order_by("ers.id_Ener_unit", "ASC"); 
        $this->db2->order_by("oos.Ener_ov_offer_sale_hour", "ASC");
        
        $offerSale = $this->db2->get("Ener_station es")->result_array();
        
        return $offerSale;
    }
    
    public function getHistoryOfferSale($dateInfo, $station, $unit){
        
        $this->db2      = $this->load->database('energy', TRUE);
        $getDataHistory = $this->db2->query("call history_produced_offer_energy('offer', '$dateInfo', $station, $unit)");
        
        return $getDataHistory->result_array();
    }

    public function getGenerationBase($dateInfo, $station, $unit){
        $producedEnergy = is_null($dateInfo) ? $this->getCurrentEnergyProduced() : $this->getHistoryEnergyProduced($dateInfo, $station, $unit);
        $offerSale      = is_null($dateInfo) ? $this->getCurrentOfferSale() : $this->getHistoryOfferSale($dateInfo, $station, $unit);
        
        foreach ($producedEnergy as $idx => $rowPE) {
            foreach ($offerSale as $rowOS) {
                if($rowOS["Hora"] == $rowPE["Hora"] && $rowOS["Unidad"] == $rowPE["Unidad"] 
                        && $rowOS["Planta"] == $rowPE["Planta"]){
                    $producedEnergy[$idx]["OfertaVenta"] = $rowOS["OfertaVenta"];
                    end($offerSale);
                }
            }
        }
        
        return $producedEnergy;
    }
    
    public function setPricesMTR($data){
        
        $date = $data[0]["date"];
        
        $this->db->select("count(*) as exist", FALSE);
        $result = $this->db->get_where("prices_pml_mtr", "date = '$date'")->result_array();
        
        if($result[0]["exist"] > 0){return array("data" => TRUE, "textStatus" => "data already exist!");}
        
        return $this->addBatch("prices_pml_mtr", $data, TRUE) ? array("success" => TRUE) : FALSE;
    }
    
    public function setLevelWater($data){
        
        $this->db2 = $this->load->database('weather', TRUE);
        $date      = $data[0]["weather_min_form_date"];
        $damID     = $data[0]["id_weather_dam"];
        
        $this->db2->select("count(*) as exist", FALSE);
        $result = $this->db2->get_where("weather_min_form", "weather_min_form_date = '$date' and id_weather_dam = $damID")->result_array();
        
        if($result[0]["exist"] > 0){return array("fileFrom" => $date, "textStatus" => "data already exist!");}
        
        return $this->db2->insert_batch("weather_min_form", $data) ? array("success" => TRUE, "fileFrom" => $date) : FALSE;
        
    }
    
    public function getLevelTank($dateStart){
        
        $this->db2 = $this->load->database('weather', TRUE);
        
        $this->db2->select("wd.weather_dam_name, wmf.weather_min_form_date, wmf.weather_min_form_value", FALSE);
        $this->db2->join("weather_dam wd", "wmf.id_weather_dam = wd.id_weather_dam");
        
        $this->db2->where("wmf.weather_min_form_date LIKE '$dateStart%' and wd.id_weather_dam = 9");
        $this->db2->order_by("wmf.weather_min_form_date", "ASC");
        
        $levels = $this->db2->get("weather_min_form wmf")->result_array();
        
        return $levels;
        
    }
    
    public function currentEnergyProducedHS(){
        
        $this->db2 = $this->load->database('energy', TRUE);
        
        $query = <<<QUERY
select 
    `es`.`Ener_station` AS `Station`,
    `os`.`Ener_ep_offer_sale_hour` AS `HourOffer`,
    sum(`os`.`Ener_ep_offer_sale_value`) AS `Value`,
    date_format(now() - interval 1 day, '%Y-%m-%d 00:00:00') AS `DateStart`
from `Ener_station` `es`
    join `Ener_ep_form` `ep` ON `ep`.`id_Ener_station` = `es`.`id_Ener_station`
    join (
        select `es`.`Ener_station` AS `Ener_station`, max(`ep`.`id_Ener_ep_form`) AS `id_Ener_ep_form`
        from `Ener_station` `es` join `Ener_ep_form` `ep` ON `ep`.`id_Ener_station` = `es`.`id_Ener_station`
        where `ep`.`Ener_ep_form_start_date` between (now() - interval 2 day) and (now() - interval 1 day)
        group by `es`.`Ener_station`
    ) `tmp` ON `tmp`.`id_Ener_ep_form` = `ep`.`id_Ener_ep_form`
    join `Ener_ep_offer_sale` `os` ON `os`.`id_Ener_ep_form` = `ep`.`id_Ener_ep_form`
group by `es`.`Ener_station` , `os`.`Ener_ep_offer_sale_hour` order by `es`.`id_Ener_station`;
QUERY;
        
        $energyProducedHS = $this->db2->query($query)->result_array();
        
        return $energyProducedHS;
        
    }
    
    public function currentOfferSaleHS(){
        
        $this->db2 = $this->load->database('energy', TRUE);
        
        $query = <<<QUERY
select 
    `es`.`Ener_station` AS `Station`,
    `oos`.`Ener_ov_offer_sale_hour` AS `HourOffer`,
    sum(`oos`.`Ener_ov_offer_sale_value`) AS `Value`,
    date_format(now(), '%Y-%m-%d 00:00:00') AS `DateStart`
from `Ener_station` `es`
    join `Ener_ov_form` `of` ON `of`.`id_Ener_station` = `es`.`id_Ener_station`
    join (
        select `es`.`Ener_station` AS `Ener_station`, max(`of`.`id_Ener_ov_form`) AS `id_Ener_ov_form`
        from `Ener_station` `es` join `Ener_ov_form` `of` ON `of`.`id_Ener_station` = `es`.`id_Ener_station`
        where (now() between `of`.`Ener_ov_form_start_date` and (`of`.`Ener_ov_form_end_date` + interval 1 day))
        group by `es`.`Ener_station`
    ) `tmp` ON `tmp`.`id_Ener_ov_form` = `of`.`id_Ener_ov_form`
    join `Ener_ov_offer_sale` `oos` ON `oos`.`id_Ener_ov_form` = `of`.`id_Ener_ov_form`
group by `es`.`Ener_station` , `oos`.`Ener_ov_offer_sale_hour`;
QUERY;
        
        $offerSaleHS = $this->db2->query($query)->result_array();
        
        return $offerSaleHS;
        
    }
    
    public function setFormEnergyBD($data){
        
        $this->db2 = $this->load->database('energy', TRUE);
        $response  = array();
        
        foreach ($data as $tableAcronim => $infoForm) {
            
            foreach ($infoForm as $formData){
            
                $formNew   = array("id_ener_station" => $formData["id_ener_station"], "ener_" . $tableAcronim . "_form_start_date" => $formData["ener_" . $tableAcronim . "_form_start_date"]);
                if(isset($formData["ener_" . $tableAcronim . "_form_end_date"])){$formNew["ener_" . $tableAcronim . "_form_end_date"] = $formData["ener_" . $tableAcronim . "_form_end_date"];}
                $formExist = $this->db2->get_where("ener_" . $tableAcronim . "_form", $formNew)->result_array();
                
                if(count($formExist) == 0){
                    
                    $formNew["id_Ener_" . $tableAcronim . "_user"]            = $this->session->userdata("userInfo") ? 
                        $this->session->userdata("userInfo")["employee_id"] : 0;
                    $formNew["Ener_" . $tableAcronim . "_form_last_date_mod"] = $this->getCurrentDate();
                    
                    $idx        = $this->add("ener_" . $tableAcronim . "_form", $formNew, FALSE, "energy");
                    $valuesForm = $formData["values"];
                    
                    for ( $i = 0 ; $i < count( $valuesForm ) ; $i++){
                        $valuesForm[$i]["id_Ener_" . $tableAcronim . "_form"]                 = $idx;
                        $valuesForm[$i]["Ener_" . $tableAcronim . "_offer_sale_creationdate"] = $formNew["Ener_" . $tableAcronim . "_form_last_date_mod"];
                    }
                    
                    $this->addBatch("ener_" . $tableAcronim . "_offer_sale", $valuesForm, FALSE, "energy");
                    
                    $response[] = array("success" => TRUE, "station_name" => $formData["station_name"], "data_date" => $formData["ener_" . $tableAcronim . "_form_start_date"], "formAdd" => "Form station $formData[station_name] add to table $tableAcronim (date " . $formData["ener_" . $tableAcronim . "_form_start_date"] . ")");
                }else{
                    $response[] = array("error" => TRUE, "textStatus" => "Data form station $formData[station_name] - " . $formData["ener_" . $tableAcronim . "_form_start_date"] . " already exist!");
                }
            }
        }
        
        return $response;
    }
    
    public function getStation($stationName){
        $this->db2 = $this->load->database('energy', TRUE);
        
        $this->db2->select("id_ener_station");
        $stationId = $this->db2->get_where("ener_station", "ener_station like '%$stationName%'")->result_array()[0];
        
        return $stationId["id_ener_station"];
    }
}
