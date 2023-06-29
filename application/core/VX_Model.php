<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VX_Model
 *
 * @author oscar.f.medellin
 */
class VX_Model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    private function loadDB($dbConfig = NULL){
        
        if(is_null($dbConfig)){return $this->db;}
        return $this->load->database($dbConfig, TRUE);
    }
        
    protected function createFields($arrayField, &$dataTable){
        foreach ($arrayField as $value) {
            $val   = "";
            $alias = "";
            if(gettype($value) == "array"){
                $val   = $value[0];
                $alias = $value[1];
            }else{
                $val   = $value;
                $alias = $value;
            }
            
            $dataTable["select"][] = array(
                "db" => "$val", "dt" => "$val", "field" => "$val", "as" => "$alias");
        }
    }
    
    protected function twfSpecial(&$dataTable, $column, $alias, $function, $icon = "fa fa-download"){
        
        $dataTable["select"][] = array(
            "db" => "$column", "dt" => "$column", "field" => "$column", "as" => "$alias", "formatter" => $function, "customData" => $icon
        );
        
    }

    protected function add($table, $data, $log = FALSE, $bd = NULL) {

        $userData = $this->session->userdata("userInfo");
        $db = $this->loadDB($bd);

        if ($log) {
            
            $date = $this->getCurrentDate();
            
            $data["date_creation"]     = $date;
            $data["user_creation"]     = $userData["employee_id"];
            $data["date_modification"] = $date;
            $data["user_modification"] = $userData["employee_id"];
        }

        $result = $db->insert($table, $data);

        if ($result) {
            $id = $db->insert_id();
        } else {
            echo json_encode(array("error" => TRUE, "type" => "insert"));
            exit();
        }

        return $id;
    }
    
    protected function addBatch($table, $data, $log = FALSE, $bd = NULL) {

        $userData = $this->session->userdata("userInfo");
        $db = $this->loadDB($bd);
        
        if ($log) {
            $date = $this->getCurrentDate();
            
            foreach($data as $key => $value){
                $value["date_creation"]     = $date;
                $value["user_creation"]     = $userData ? $userData["employee_id"] : 0;
                $value["date_modification"] = $date;
                $value["user_modification"] = $userData ? $userData["employee_id"] : 0;
                
                $data[$key] = $value;
            }
        }

        $result = $db->insert_batch($table, $data);
        
        if (!$result) {
            echo json_encode(array("error" => TRUE, "type" => "insertBatch"));
            exit;
        }

        return TRUE;
    }
    
    protected function edit($table, $condition, $data, $log = FALSE, $escape = FALSE) {

        $userData = $this->session->userdata("userInfo");

        if ($log) {
            $dateCurrent = $this->getCurrentDate();
            $data["date_modification"] = $escape ? "'$dateCurrent'" : "$dateCurrent";
            $data["user_modification"] = "$userData[employee_id]";
        }
        
        if($escape){
            foreach ($data as $key => $value) {$this->db->set($key, "$value", FALSE);}
            $this->db->where($condition);
            $result = $this->db->update($table);
        }else{
            $result = $this->db->update($table, $data, $condition);
        }

        if ($result) {
            $id = $this->db->insert_id();
        } else {
            echo json_encode(array("error" => TRUE, "type" => "edit"));
            exit();
        }

        return $id;
    }
    
    protected function searchCompleteEmployeeData($params){
        $params["active"] = 1;
        
        $this->db->select("employee_id, email");
        $employee = $this->db->get_where("users", $params)->result_array();
        
        return count($employee) == 0 ? $employee : $employee[0];
    }

    protected function getAreaEmployee($employeeId) {
        $this->db->select("a.*, c.clave");
        $this->db->join("positions p", "p.position_id = e.position_id");
        $this->db->join("areas a", "a.area_id = p.area_id");
        $this->db->join("cat_corps_subsidiary cs", "cs.corp_subsidiary_id = e.corp_subsidiary_id");
        $this->db->join("cat_corps c", "c.corp_id = cs.corp_id");
        $area = $this->db->get_where("employees e", "e.employees_id = $employeeId and e.active = 1");

        return $area->result_array()[0];
    }
    
    protected function getCurrentDate($timezone = "America/Mexico_City") {
        
        $fecha = new DateTime("now", new DateTimeZone($timezone));
        return $fecha->format("Y-m-d H:i:s");
        
    }
    
    public function getTypeFile($ext){
        
        $typeFile = "";
        
        switch ($ext){
            case "xls": case "xlsx":
                $typeFile = "fa fa-file-excel-o";
                break;
            case "doc": case "docx":
                $typeFile = "fa fa-file-word-o";
                break;
            case "pdf":
                $typeFile = "fa fa-file-pdf-o";
                break;
            default:
                $typeFile = "fa fa-file-image-o";
        }
        
    }
    
    public function checkURL($arrayFolders, $sameLevel = TRUE, $rootFolder = "uploads"){
        
        $folderUri   = "";
        $folderArray = array();
        
        foreach($arrayFolders as $folder ){
            
            if($sameLevel){
                $folderUri     = $folder;
                $folderArray[] = "$rootFolder/$folderUri";
            }else{
                $folderUri .= strlen($folderUri) == 0 ? $folder : "/$folder";
            }
            
            if(!file_exists("$rootFolder/$folderUri")){
                mkdir("$rootFolder/$folderUri", 0777, true) or die("Fallo al crear carpeta");
            }
            
        }
        
        return $sameLevel ? $folderArray : "$rootFolder/$folderUri";
        
    }
    
    protected function getDocumentInfo($params) {
        
        $docData = $this->db->get_where("document_complete_data", $params)->result_array();
        
        return $docData;
    }
    
    protected function getIdDoc($folioDoc){
        $this->db->select("code, num_document, year_document");
        $this->db->where("CONCAT(code, '-', num_document, '/', year_document) = '$folioDoc'");
        
        $infoDoc = $this->db->get("mngmail_documents")->result_array();
        
        return $infoDoc[0];
        
    }

}
