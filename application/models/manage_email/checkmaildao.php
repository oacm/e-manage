<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of exchangedao
 *
 * @author oscar.f.medellin
 */
class CheckmailDao extends VX_Model {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->library("DataTables", "datatables");
        $this->load->library("session");
    }
    
    public function getAreaEmployee($employeeId) {
        return parent::getAreaEmployee($employeeId);
    }
    
    public function getTableAnswered($params) {

        $userData             = $this->session->userdata("userInfo");
        $dataTable            = $this->datatables->getStructureTable("document_complete_data", "control_folio");
        
        $this->createFields(array("antecedent", "comments", "contactName", "folio_doc", "control_folio", "priority_id", "nameStatus", "nameSender", "theme_id", "subject", "priority", "expiration", "theme", "areaCode"), $dataTable);
        
        $dataTable["query"]   = <<<QUERY
FROM document_complete_data
QUERY;
        
        $dataTable["where"]   = "employee_id = $userData[employee_id] AND (status_id = 7 OR status_id = 4)";
        $dataTable["groupBy"] = "";

        return $this->datatables->getDataTable($params, $dataTable);
    }
    
    public function getAntecedents($params){
        
        $query = <<<QUERY
select 
    md.code, md.num_document, md.year_document, md.code_out, md.num_doc_out, md.year_doc_out, md.folio_doc, md.antecedent, mfu.path, mfu.name as file, mfu.extension, md.date_modification
from
    mngmail_files_uploaded mfu
join (select code, num_document, year_document, max(date_creation) as date_creation from mngmail_files_uploaded group by concat(code, '-', num_document, '/', year_document)) mfu2
    on mfu.code = mfu2.code and mfu.num_document = mfu2.num_document and mfu.year_document = mfu2.year_document and mfu.date_creation = mfu2.date_creation
join mngmail_documents md
    on mfu.code = md.code AND mfu.num_document = md.num_document AND mfu.year_document = md.year_document
where (concat(md.code_out, '-', md.num_doc_out, '/', md.year_doc_out) = '$params[documentId]' OR concat(md.code, '-', md.num_document, '/', md.year_document) = '$params[documentId]') and mfu.active = 1;
QUERY;
        
        $result = $this->db->query($query)->result_array();
        
        if(count($result) == 0){
            return FALSE;
        }elseif (@strlen($result[0]["antecedent"]) > 0) {
            $hasAntecedent = $this->getAntecedents(array("documentId" => $result[0]["antecedent"]));
            $antecedents   = $hasAntecedent === FALSE ? array() : $hasAntecedent;
        }
        
        $antecedents[] = $this->load->view("tpl_general/antecedentTimeLine", $result[0], TRUE);
        return $antecedents;
    }
    
    public function setEdit($params){
        
        $userData     = $this->session->userdata("userInfo");
        $dateRejected = date("Y-m-d H:i", strtotime($this->getCurrentDate()));
        $updatedFile  = $this->setStatusFile($params["fileId"]);
        
        if($updatedFile["error"]){return $updatedFile;}
        
        $this->db->set("status_id", 1, FALSE);
        $this->db->set("date_modification", "'$dateRejected'", FALSE);
        $this->db->set("user_modification", "$userData[employee_id]", FALSE);
        $this->db->where("CONCAT(code, '-', num_document, '/', year_document) = '$params[numDocument]'");
        $setReject = $this->db->update("mngmail_documents");
        
        return !$setReject ? array("error" => TRUE) : array("success" => TRUE);
    }
    
    public function needAnswered($folio, $folioId){
        
        $arrayFolio = array();
        
        foreach ($folio as $key => $value) {
            $arrayFolio["mat.$key"] = $value;
        }
        
        $arrayFolio["mat.returned"] = 0;
        
        $this->db->select("mat.answered, files.check");
        $this->db->join("mngmail_files_uploaded files", "files.code = mat.code AND files.year_document = mat.year_document AND files.num_document = mat.num_document AND files.files_uploaded_id = $folioId");
        $answered = $this->db->get_where("mngmail_assing_to mat", $arrayFolio)->result_array();

        return $answered[0];
    }
}
