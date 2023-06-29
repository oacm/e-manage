<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of level_tankdao
 *
 * @author ÓscarFloresMedellín
 */
class level_TankDao extends VX_Model{
    //put your code here
    public function __construct() {
        parent::__construct();
        
        $this->load->library("Curl", array("time_out" => 20),"curl");
        
    }
    
    public function getDamInfo(){
        
        $weather = $this->load->database('weather', TRUE);
        
        $weather->select("id_weather_dam, id_weather_igs");
        $infoWorkcenter = $weather->get_where("weather_dam", "name_file_tpl != 'n/a'");
        
        return $infoWorkcenter->result_array();
    }
    
    public function getDateDam($idDam, $interval = "last"){
        
        $weather = $this->load->database('weather', TRUE);
        
        $select  = "STR_TO_DATE(CONCAT(weather_form_date, ' ', weather_form_time), '%d/%m/%Y %H:%i:%s') as weather_date";

        $weather->select($select, FALSE);

        switch ($interval) {
            case "last":
                $weather->limit(1, 0);
                $weather->order_by("weather_date", "desc");
                break;
            case "first":
                $weather->limit(1, 0);
                $weather->order_by("weather_date", "asc");
                break;
            case "all":
                break;
            default:
                break;
        }
        
        $result = $weather->get_where("weather_form", "id_weather_dam = $idDam"); 
        return $result->result_array();
    }
    
    public function getLevelDamIGS($idWeatherDam, $idWeatherIGS, $lastLevelDateDam, $hours) {
        
        
        $url         = "http://igscloud-mx.ddns.net/IgsServicios/DatosSensorEx?idAsignado=$idWeatherIGS&numeroSensor=0002&horas=$hours&idC=CC5254C6-1E86-4BBD-8D43-65C6DA6550AB";
        $newData     = array();
        $lostData    = array();
        $dataNull    = 0;
        //revisamos si durante la llamada esta no manda un NULL como resultado por presa
        if(is_null($result = $this->curl->callApiRequest($url, "GET")["data"])){
            $lostData["idDamIGS"]     = $idWeatherIGS;
            $lostData["missingHours"] = $hours;
            $lostData["webService"]   = TRUE;
            return array("dataInsert" => count($newData), "dam" => $idWeatherIGS, "problemStation" => $lostData);
        }
        
        $lastDateIGS = date_create_from_format("d/m/Y h:i:s a", str_replace(". m.", ".m.", end($result)["FechaHoraStr"]));
        
        //Se revisa que los datos que hagan falta no sean mayores a 24HRS. con respecto a la hora actual y el último registro guardado por Presa 
        if(intval((strtotime($this->getCurrentDate()) - strtotime(date_format($lastDateIGS, "Y-m-d H:i:s")))/60/60) >= 24){
            $lostData["idDamIGS"]     = $idWeatherIGS;
            $lostData["missingHours"] = intval((strtotime($this->getCurrentDate()) - strtotime(date_format($lastDateIGS, "Y-m-d H:i:s")))/60/60);
            $lostData["webService"]   = FALSE;
        }
        
        foreach ($result as $value) {
            $dateIGS = date_create_from_format("d/m/Y h:i:s a", str_replace(". m.", ".m.", $value["FechaHoraStr"]));
            
            //En caso de regresar datos, se verifica que no se traigan valores 0 o Nulos en el registro
            
            if((strtotime(date_format($dateIGS, "Y-m-d H:i:s")) > strtotime($lastLevelDateDam)) && (!is_null($value["Valor"]) || $value["Valor"] = 0)){
                $newData[] = array(
                    "weather_form_date"   => date_format($dateIGS, "d/m/Y"),
                    "weather_form_time"   => date_format($dateIGS, "H:i:s"),
                    "id_weather_dam"      => $idWeatherDam,
                    "weather_form_value"  => $value["Valor"],
                    "weather_form_sensor" => $idWeatherIGS
                );
            }else{
                $dataNull++;
            }
        }
        
        if( $dataNull/count($result)*100 > 25){
            $lostData["idDamIGS"]     = $idWeatherIGS;
            $lostData["webService"]   = FALSE;
            $lostData["dataNull"]     = $dataNull/count($result)*100;
        }
        
        if(count($newData) > 0){
            return $this->addBatch("weather_form", $newData, FALSE, "weather") ? array("dataInsert" => count($newData), "dam" => $idWeatherIGS, "problemStation" => $lostData) : FALSE;
        }
        
        return array("dataInsert" => count($newData), "dam" => $idWeatherIGS, "problemStation" => $lostData);
        
    }
    
    public function setLevelDam($params){
        
        return $this->add("weather_form", $params, FALSE, "weather") ? array("success" => TRUE) : FALSE;
        
    }
}
