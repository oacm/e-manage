<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of systemctr
 *
 * @author oscar.f.medellin
 */
class SystemCtr extends VX_Controller {
    
    
    public function __construct() {        
        parent::__construct(TRUE);
        
        $this->load->model("energy_management/systemdao" , "dao");
        $this->load->library("PHPMailerObj", "phpmailerobj");
    }
    
    public function activeCurrentLicenses() {
        
        $licensesActive = $this->dao->activeCurrentLicenses();
        
        if(isset($licensesActive["error"])){
            echo "\n\nOcurrio un error durante consultando la licencias activas -> " . $this->getCurrentDate(TRUE);
        }
        
        $this->dao->updateCurrentLicenses($licensesActive);
        $this->dao->updateLicensesExpired();
        
        echo "\n\nFin de proceso de actualización";
    }
    
    public function updateUnitLicenses() {        
        $this->dao->updateUnitLicenses();
    }
    
    public function salesOfferReminder(){
        
        $dateArray = array();
        
        switch(intval($this->getCurrentDate()->format("N"))){
            case 5:
                $dateArray[] = $this->getCurrentDate()->add(new DateInterval("P1D"));
                $dateArray[] = $this->getCurrentDate()->add(new DateInterval("P2D"));
                $dateArray[] = $this->getCurrentDate()->add(new DateInterval("P3D"));
                break;
            case 1:case 2:case 3:case 4:
                $dateArray[] = $this->getCurrentDate()->add(new DateInterval("P1D"));
                break;
        }
        
        if(count($dateArray) == 0){return;}
        
        $salesOfferData = $this->dao->getSalesOfferInfo($dateArray);
        
        $dataMail               = array(
            "subject" => "Estatus de Ofertas de Ventas (Informe Diario)",
            "html"    => TRUE,
            "from"    => "Informes Fénix"
        );
                                       
        $this->phpmailerobj->setDebugMailer();
        $this->phpmailerobj->configMailer();
        $this->phpmailerobj->setSharedMail("informes.fenix@fenixenergia.com.mx");
        
        $dataMail["msg"] = $this->load->view("energy_management/mails/salesOfferReminder", array(
                                                                        "salesOffer" => $salesOfferData), TRUE);
        $this->phpmailerobj->setAddress("monserrat.davila@fenixenergia.com.mx");
        $this->phpmailerobj->setCC("rui.desousa@fenixenergia.com.mx");
        $this->phpmailerobj->sendMailer($dataMail);

        $this->phpmailerobj->clearAddress();
    }
    
    public function getAveragePriceDay($monthStart, $dayStart, $monthEnd, $dayEnd){
        $getAvgPriceDay = $this->dao->getAveragePriceDay($monthStart, $dayStart, $monthEnd, $dayEnd);
        echo json_encode($getAvgPriceDay);
    }
    
    public function getMonthlyBudget(){
        $getMonthlyBudget = $this->dao->getMonthlyBudget();
        echo json_encode($getMonthlyBudget);
    }
    
    public function getPriceDay($month, $day){
        $getPriceDay = $this->dao->getPriceDay($month, $day);
        echo json_encode($getPriceDay);
    }
    
    public function getDailyReportDamInfo(){
        $getDailyReportDamInfo = $this->dao->getDailyReportDamInfo();
        echo json_encode($getDailyReportDamInfo);
    }
    
    public function getGenerationBase($dateInfo = NULL, $station = 0, $unit = 0){
        $getGenerationBase = $this->dao->getGenerationBase($dateInfo, $station, $unit);
        echo json_encode($getGenerationBase);
    }
    
    public function setLevelWater(){
        
        $this->load->library("CSVManager");

        if(!isset($_FILES["file"])){echo json_encode(array("error" => TRUE, "textStatus" => "File not found"));return;}
        $response = array();

        foreach ($_FILES["file"]["tmp_name"] as $tmpName){

            $this->csvmanager->setFileCSV($tmpName);
            $csvArray = array();
            
            foreach($this->csvmanager->getDataCSV() as $key => $value){
                if($key == 0){$csvArray[] = array("weather_min_form_date", "weather_min_form_value", "id_weather_dam", "id_weather_min_form_user", "weather_min_form_creado");continue;}
                $dFormat = explode("/", $value[2]);
                $value[0] = intval($value[0]) - 1;
                if(count($dFormat) > 0){
                    $dFormat = "$dFormat[2]-$dFormat[1]-$dFormat[0]";
                }else{
                    $dFormat = $value[2];
                }
                
                $csvArray[] = array(
                    $dFormat . " " . (intval($value[0]) < 10 ? "0$value[0]:00:00" : "$value[0]:00:00"), 
                    $value[1],
                    9,0,$this->getCurrentDate(TRUE));
            }

            $this->csvmanager->setDataCSV($csvArray);
            $csvData = $this->csvmanager->getArrayCSV();            
            $response[] = $this->dao->setLevelWater($csvData);
            
            $this->csvmanager->resetDataCSV();
        }
        
        echo json_encode($response);
        
    }
    
    public function getLevelTank($year, $month, $day){
        
        if(!checkdate(intval($month), intval($day), intval($year))){
            echo json_encode(array("error" => TRUE, "textStatus" => "Invalid Date Format"));
            return;
        }
        
        $levelTank = $this->dao->getLevelTank("$year-$month-$day");
        
        if(count($levelTank) == 0){
            echo json_encode(array("error" => TRUE, "textStatus" => "No Data Found"));
            return;
        }
        
        echo json_encode($levelTank);
    }
    
    public function currentEnergyProducedHS(){
        $hourStation = $this->dao->currentEnergyProducedHS();
        
        echo json_encode($hourStation);
    }
    
    public function currentOfferSaleHS(){
        $hourStation = $this->dao->currentOfferSaleHS();
        
        echo json_encode($hourStation);
    }

    public function setPricesMtr($fileType) {
        
        $response = NULL;
        
        if(!isset($_FILES["file"])){
            echo json_encode(array("error" => TRUE, "textStatus" => "File not found"));
            return;
        }
        
        switch ($fileType){
            case "json":
                $response = $this->mtrJsonPrice();
                break;
            case "csv":
                $response = $this->mtrCsvPrice();
                break;
            default :
                $response = json_encode(array("error" => TRUE, "textStatus" => "File not found"));
        }
        
        echo $response;
    }
    
    private function mtrJsonPrice(){
        
        $this->load->library("ReadFiles/FileManager", array("fileUri" => $_FILES["file"]["name"], "openFile" => FALSE), "file");
        
        if($this->file->getExtension() !== "json"){return json_encode(array("error" => TRUE, "textStatus" => "Not JSON File"));}
        
        $file = fopen($_FILES["file"]["tmp_name"], "r");
        $json = "";        
        
        while ($line = fgets($file)){
            $json .= $line;
        }
        
        $process = $this->dao->setPricesMTR(json_decode($json, TRUE));
        
        return json_encode($process);
    }
    
    private function mtrCsvPrice(){
        
        if(substr($_FILES["file"]["name"], strrpos($_FILES["file"]["name"], ".", -1) + 1) !== "csv"){return json_encode(array("error" => TRUE, "textStatus" => "Not CSV File"));}
        
        $this->load->library("CSVManager", array(
            "fileCSV" => $_FILES["file"]["tmp_name"],
            "mode"    => "r"), "csv");
        
        $csvData = $this->csv->getArrayCSV();
        $process = $this->dao->setPricesMTR($csvData);
        
        return json_encode($process);
    }
    
    public function loadSOEP($fileType){
        
        $this->checkFiles($_FILES["file"]);
        
        $fileExt  = strtoupper(substr($_FILES["file"]["name"], strrpos($_FILES["file"]["name"], ".", -1) + 1));
        $response = NULL;
        
        if($fileExt !== strtoupper($fileType)){return json_encode(array("error" => TRUE, "textStatus" => "Not $fileExt File"));}
        
        eval('$process = $this->read' . $fileExt . '($_FILES["file"]["tmp_name"], "r");');

        switch($fileExt){
            case "CSV":
                $response = $this->loadSOEPCSV($process);
                break;
            case "JSON":
                $response = $this->loadSOEPJSON($process);
                break;
        }
        
        echo json_encode($response);
    }
    
    private function loadSOEPCSV($data){
        
        $formData = array("ep" => array(), "ov" => array());
        $stations = array_unique(array_column($data, "station"));
        
        foreach ($stations as $station) {
            $stationId = $this->dao->getStation($station);
        
            foreach ($data as $info){
                if($station != $info["station"]){continue;}
                $epIndex   = $this->multiple_column_search($formData["ep"], array("id_ener_station" => $stationId, "ener_ep_form_start_date" => $info["date_start"]));
                $oeIndex   = $this->multiple_column_search($formData["ov"], array("id_ener_station" => $stationId, "ener_ov_form_start_date" => $info["date_start"]));
                
                if($epIndex === FALSE && $oeIndex === FALSE){
                    $formData["ep"][] = array("id_ener_station" => $stationId, 
                        "ener_ep_form_start_date" => $info["date_start"],
                        "station_name"            => $info["station"],
                        "values" => array(
                            array("ener_ep_offer_sale_hour"  => $info["hour"], 
                                "id_ener_rel_stationunit" => $info["unit"], 
                                "ener_ep_offer_sale_value" => $info["ep"])
                            )
                        );

                    $formData["ov"][] = array("id_ener_station" => $stationId, 
                        "ener_ov_form_start_date" => $info["date_start"], "ener_ov_form_end_date" => $info["date_start"],
                        "station_name"            => $info["station"],
                        "values" => array(
                            array("ener_ov_offer_sale_hour"  => $info["hour"], 
                                "id_ener_rel_stationunit" => $info["unit"], 
                                "ener_ov_offer_sale_value" => $info["ep"])
                            )
                        );    
                }else{
                    $formData["ep"][$epIndex]["values"][] = array("ener_ep_offer_sale_hour"  => $info["hour"], "id_ener_rel_stationunit"  => $info["unit"], "ener_ep_offer_sale_value" => $info["ep"]);
                    $formData["ov"][$oeIndex]["values"][] = array("ener_ov_offer_sale_hour"  => $info["hour"], "id_ener_rel_stationunit"  => $info["unit"], "ener_ov_offer_sale_value" => $info["ov"]);
                }
            }
        }
        
        return json_encode($this->dao->setFormEnergyBD($formData));
    }
}