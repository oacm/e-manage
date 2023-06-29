<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of inmail
 *
 * @author oscar.f.medellin
 */
class outMailDao extends VX_Model {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->library("DataTables", "datatables");
        $this->load->library("session");
    }
    
    public function getAreaEmployee($employeeId) {
        return parent::getAreaEmployee($employeeId);
    }
    
    public function getDocumentInfo($params){
        return parent::getDocumentInfo($params);
    }
    
    public function getTableWaiting($params) {
        
        $employeeId = $this->session->userdata("userInfo")["employee_id"];
        $dataTable  = $this->datatables->getStructureTable("document_complete_data", "control_folio");
        
        $this->createFields(array(array("control_folio_out", "docOut"), "subject", "theme", "comments"), $dataTable);
        $this->twfSpecial($dataTable, "control_folio", "download", function($d) {return "<a data-document='$d' href='javascript:void(0);'><i class='fa fa-download'></i></a>"; });
      
        $dataTable["query"] = <<<QUERY
FROM document_complete_data
QUERY;
        
        $dataTable["where"]   = "employee_id = $employeeId AND status_id = 5";
        $dataTable["groupBy"] = "";

        return $this->datatables->getDataTable($params, $dataTable);
    }
    
    public function historyMain(&$dataTable){
        
        $employeeData = $this->session->userdata("userInfo");        
        $areaId       = $this->getAreaEmployee($employeeData["employee_id"])["area_id"];
        
        $areas    = array_column($this->db->query("SELECT area_id FROM areas WHERE parent_area_id = $areaId;")->result_array(), "area_id");
        $foliosCC = array_column($this->db->query("SELECT DISTINCT rcd.control_folio FROM rel_cc_document_employees rcd JOIN document_complete_data dcd ON dcd.control_folio = rcd.control_folio WHERE rcd.employee_id = $employeeData[employee_id];")->result_array(), "control_folio");
        $areas[]  = $areaId;
        $folios   = array_column($this->db->query("SELECT control_folio FROM document_complete_data WHERE area_id IN (" . implode(",", $areas) . ");")->result_array(), "control_folio");
        $foliosR  = array_column($this->db->query("SELECT DISTINCT dcd.control_folio FROM mngmail_assing_to mat JOIN document_complete_data dcd ON dcd.control_folio = concat(mat.code, '-', mat.num_document, '/', mat.year_document) WHERE mat.area_id = $areaId AND dcd.onlyRead = 1;")->result_array(), "control_folio");
        
        $foliosComplete = array_unique(array_merge($folios, $foliosCC, $foliosR));
        
        foreach ($foliosComplete as $key => $value) {$foliosComplete[$key] = "'$value'";}
        
        $this->createFields(array(array("control_folio", "control_folio_out"), "folio_doc", "subject", "nameSender", "contactName", "theme_id", "priority_id", "comments", "antecedent", "theme", "nameStatus", "onlyRead", "nameAreas", "employee"), $dataTable);
        $this->twfSpecial($dataTable, "control_folio_out", "control_folio", function($d, $row){
            return $row["onlyRead"] == 1 ? "Doc. de Conocimiento" : $d;
        });
        $this->twfSpecial($dataTable, "expiration", "expiration", function($d) {
            $dateExpire = explode("/", $d);return intval($dateExpire[2]) != 0 ? 
            date("d / m / Y", strtotime("$dateExpire[2]-$dateExpire[1]-$dateExpire[0]")) : "-----------"; });
        
        $dataTable["where"]   = count($foliosComplete) == 0 ? "area_id = $areaId AND status_id = 2" : "control_folio IN (" . implode(",", $foliosComplete) . ")";
        $dataTable["groupBy"] = "";
    }
    
    public function historyTurned(&$dataTable){
        
        $this->createFields(array("control_folio", "folio_doc", "subject", "nameSender", "nameStatus", "acknowledgment", "defeated", "answered", "onlyRead", "status_id", "from_inbox", "nameAreas", "employee", "dateReception", "not_initial_doc"), $dataTable);
        $this->twfSpecial($dataTable, "control_folio_out", "control_folio_out", function($d, $row){
            return $row["onlyRead"] == 1 ? "Doc. de Conocimiento" : $d;
        });
        $this->twfSpecial($dataTable, "control_folio", "alert_doc", function($d, $row) {
            
            $icons = "";
            
            if($row["not_initial_doc"] == 0 && $row["onlyRead"] == 0){$icons .= "<a data-initial data-document='$d' href='javascript:void(0);' class='icon aero' title='Documento Inicial'><i class='fa fa-file'></i></a>";}
            if($row["answered"] == 1 && $row["status_id"] == 2 && $row["acknowledgment"] == 0){$icons .= "<a data-response data-document='$d' href='javascript:void(0);' class='icon' title='Documento de Salida'><i class='fa fa-file-text-o'></i></a>";}
            if($row["acknowledgment"] == 1){$icons .= "<a data-acknowledgment data-document='$d' href='javascript:void(0);' class='icon green' title='Acuse'><i class='fa fa-file-text'></i></a>";}
            if($row["defeated"] == 1){$icons .= "<a data-defeated data-document='$d' href='javascript:void(0);' class='icon red' title='Vencido'><i class='fa fa-envelope'></i></a>";}
            if($row["acknowledgment"] == 0 && $row["answered"] == 1 && $row["onlyRead"] == 0 && $row["status_id"] == 2){$icons .= "<a data-download data-document='$d' href='javascript:void(0);' class='icon' title='Cargar Acuse'><i class='fa fa-upload'></i></a>";}
            
            return $icons;
            
        });
    }
    
    public function getTableHistory($params, $table){
        
        $dataTable = $this->datatables->getStructureTable("document_complete_data", "control_folio");
        
        eval("\$this->\$table(\$dataTable);");
        
        $dataTable["query"] = <<<QUERY
FROM document_complete_data
QUERY;
        
        return $this->datatables->getDataTable($params, $dataTable);
        
    }
    
    public function getDocumentData($params){
        
        $this->db->select("code, num_document, year_document");
        $this->db->where("CONCAT(code_out, '-', num_doc_out, '/', year_doc_out) = '$params[folio]'");
        
        $documentData = $this->db->get("mngmail_documents")->result_array();
        
        return $documentData[0];
        
    }
    
    public function sendResponse($folioDoc, $dataResponse) {
        
        $this->edit("mngmail_documents", $folioDoc, $dataResponse, TRUE);
        
    }
    
}