<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pendingdoc
 *
 * @author oscar.f.medellin
 */
class pendingDocDao extends VX_Model {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->library("DataTables", "datatables");
        $this->load->library("session");
    }
    
    private function getAnswered($documentFolio, $currentArea){
        $dataDoc            = $this->getDocumentData(array("folio" => $documentFolio));
        $dataDoc["area_id"] = $currentArea;
        
        $this->db->select("answered + 1 as answered", FALSE);
        $answer = $this->db->get_where("mngmail_assing_to", $dataDoc)->result_array();
        
        return $answer[0]["answered"];
    }
    
    private function setStatusFile($fileId){
        
        $fileData = $this->db->get_where("mngmail_files_uploaded", "files_uploaded_id = $fileId")->result_array();
        $data     = array();
        
        if($fileData[0]["in"] == 1){
            $data["in"]     = 2;
            $data["review"] = 0;
        }elseif ($fileData[0]["check"] == 1) {
            $data["check"]  = 2;
            $data["review"] = 0;
            $data["accept"] = 0;
        }
        
        return $this->edit("mngmail_files_uploaded", "files_uploaded_id = $fileId", $data, TRUE);
        
    }
    
    public function getCC($params){
        
        $this->db->select("e.employees_id as employee_id, e.name as employee, u.email");
        $this->db->join("employees e", "e.employees_id = rel.employee_id");
        $this->db->join("users u", "u.employee_id = e.employees_id");
        
        $cc = $this->db->get_where("rel_cc_document_employees rel", $params)->result_array();
        
        return $cc;
        
    }
    
    public function setCC($params){
        
        $this->db->delete("rel_cc_document_employees", array("control_folio" => $params["numDocument"]));
        
        foreach($params["cc"] as $employee_id){
            
            $this->add("rel_cc_document_employees", array(
                "employee_id" => $employee_id, 
                "control_folio" => $params["numDocument"]));
        }
        
        return array(
            "success" => TRUE
        );
    }
    
    public function returnedDoc($params){
        
        $reAssing = array();
        $areaData = $this->getAreaEmployee($this->session->userdata("userInfo")["employee_id"]);
        $docData  = $this->getDocumentData(array("folio" => $params["numDocument"]));
//Esto no lo borres es por sí quieren el aceptado de todas las áreas que fue returnado.                
//        if(isset($params["answered"])){
//            $reAssing["answered"] = $this->getAnswered($params["numDocument"], $areaData["area_id"]);
//            $this->setStatusFile($params["fileId"]);            
//        }
        
        if(isset($params["cc"])){
            $this->setCC($params);
            unset($params["cc"]);
        }
        
        $reAssing["area_id"] = $params["area_id"];                       
        $this->add("mngmail_assing_to", array_merge($docData, $reAssing));
        
        $docData["area_id"] = $areaData["area_id"];
        $this->edit("mngmail_assing_to", $docData, array( "returned" => 1));
        
        unset($docData["area_id"]);
        unset($params["area_id"]);
        unset($params["numDocument"]);
        $params["status_id"] = 6;
        $this->edit("mngmail_documents", $docData, $params, TRUE, TRUE);
        
        return array(
            "success" => TRUE
        );
        
    }

    public function getDocumentData($params){
        
        $this->db->select("code, num_document, year_document");
        $this->db->where("CONCAT(code, '-', num_document, '/', year_document) = '$params[folio]'");
        
        $documentData = $this->db->get("mngmail_documents")->result_array();
        
        return $documentData[0];
        
    }
    
    public function getTable($params) {

        $areaId    = $this->getAreaEmployee($this->session->userdata("userInfo")["employee_id"])["area_id"];        
        $dataTable = $this->datatables->getStructureTable("document_complete_data", "control_folio");
        
        $this->createFields(array("antecedent", "comments", "contactName", "folio_doc", "control_folio", "priority_id", "nameStatus", "nameSender", "theme_id", "subject"), $dataTable);
        $this->twfSpecial($dataTable, "view", "view", function($d) {                    
            if($d == 1){$icon = "fa fa-eye info-progress";}else{$icon = "fa fa-eye-slash";}                    
            $links = <<<EOT
<i class="$icon" title="Visto"></i>
EOT;
            
            return $links;
        });
        $this->twfSpecial($dataTable, "expiration", "expiration", function($d) {$year = explode("/", $d)[2]; return intval($year) != 0 ? date("d / m / Y", strtotime($d)) : "-----------";});
                
        $dataTable["query"] = <<<QUERY
FROM document_complete_data
QUERY;

        $dataTable["where"]   = "area_id = $areaId AND (status_id = 8 OR status_id = 6)";
        $dataTable["groupBy"] = "";

        return $this->datatables->getDataTable($params, $dataTable);
    }
    
    public function getTableReview($params) {
        
        $userData  = $this->session->userdata("userInfo");
        $areaId    = $this->getAreaEmployee($userData["employee_id"])["area_id"];
        
        $dataTable = $this->datatables->getStructureTable("document_complete_data", "control_folio");
        
        $this->createFields(array("antecedent", "comments", "contactName", "folio_doc", "control_folio", "priority_id", "nameStatus", "nameSender", "theme_id", "subject"), $dataTable);
        $this->twfSpecial($dataTable, "view", "view", function($d) {                    
            if($d == 1){$icon = "fa fa-eye info-progress";}else{$icon = "fa fa-eye-slash";}                    
            $links = <<<EOT
<i class="$icon" title="Visto"></i>
EOT;
            
            return $links;
        });
        $this->twfSpecial($dataTable, "expiration", "expiration", function($d) {$year = explode("/", $d)[2]; return intval($year) != 0 ? date("d / m / Y", strtotime($d)) : "-----------";});
                
        $dataTable["query"] = <<<QUERY
FROM document_complete_data
QUERY;

        $dataTable["where"]   = "area_id = $areaId AND status_id = 3";
        $dataTable["groupBy"] = "";

        return $this->datatables->getDataTable($params, $dataTable);
}
    
    public function getTheme($params) {
        
        $selected = isset($params["id"]) ? "AND theme_id = $params[id] " : "";

        $query = <<<QUERY
SELECT
    theme_id as id, 
    name as text
FROM cat_theme
WHERE name LIKE '%$params[term]%' $selected AND active = 1;
QUERY;

        $theme = $this->db->query($query);

        return $theme->result_array();
    }
    
    public function getIdThemeDoc($theme) {

        $id    = NULL;
        $exist = intval($theme);

        $this->db->select("theme_id");

        if ($exist > 0) {
            $result = $this->db->get_where("cat_theme", "theme_id = $theme AND active = 1")->result_array();

            if (count($result) == 0) {
                echo json_encode(array("error" => TRUE, "type" => "theme"));
                exit;
            }

            $id = $result[0]["theme_id"];
        } else {
            $result = $this->db->get_where("cat_theme", "name LIKE '$theme' AND active = 1")->result_array();

            if (count($result) == 0) {
                $insert = $this->add("cat_theme", array("name" => $theme), TRUE);
                if ($insert["error"]) {
                    echo json_encode($insert);
                    exit;
                }

                $id = $insert;
            } else {
                $id = $result[0]["theme_id"];
            }
        }

        return $id;
    }
    
    public function getPriority($params) {
        
        $selected = isset($params["id"]) ? "AND priority_id = $params[id] " : "";

        $query = <<<QUERY
SELECT
    priority_id as id, 
    name as text
FROM cat_priority
WHERE name LIKE '%$params[term]%' $selected AND active = 1;
QUERY;

        $priority = $this->db->query($query);

        return $priority->result_array();
    }
    
    public function getAntecedent($params){
        
        $areaId    = $this->getAreaEmployee($this->session->userdata("userInfo")["employee_id"])["area_id"];
        $fieldLike = "";
        
        if(isset($params["search"])){
            $fieldLike = "AND (ct.name like '%$params[search]%' OR md.code_out like '%$params[search]%' OR md.num_doc_out like '%$params[search]%' OR md.year_doc_out like '%$params[search]%' OR md.folio_doc like '%$params[search]%' OR cs.name like '%$params[search]%' OR cc.name like '%$params[search]%' OR md.comments like '%$params[search]%')";
        }
        
        $query  = <<<EOT
select md.code_out as codeOut, md.num_doc_out as numDocOut, md.year_doc_out as yearDocOut, md.folio_doc as folioDoc, md.subject as subject, cs.name as sender,
cc.name as contact, ct.name as theme, concat(files.path, '/', files.name, files.extension) as docOut, files.name as fileNameOut, md.comments, mat.view, md.antecedent 
from mngmail_documents md
join cat_sender cs on cs.sender_id = md.sender_id
join cat_contact cc on cc.contact_senders_id = md.contact_id
join mngmail_assing_to mat on mat.code = md.code AND mat.num_document = md.num_document AND mat.year_document = md.year_document
join mngmail_files_uploaded files on files.code = md.code AND files.num_document = md.num_document AND files.year_document = md.year_document
join (select max(date_creation) as date_creation from mngmail_files_uploaded group by concat(code, '-', num_document, '/', year_document)) files2 on files.date_creation = files2.date_creation
join areas a on a.area_id = mat.area_id
join cat_status st on st.status_id = md.status_id
join cat_theme ct on ct.theme_id = md.theme_id
where mat.area_id = $areaId and mat.returned = 0 and md.status_id = 2 and md.active = 1 $fieldLike order by codeOut asc, numDocOut asc, yearDocOut asc;
EOT;
        
        return $this->db->query($query)->result_array();
        
    }
    
    public function setView($params) {
        
        $userData = $this->session->userdata("userInfo");
        $areaId   = $this->getAreaEmployee($userData["employee_id"])["area_id"];
        
        $this->db->set("view", 1, FALSE);
        $this->db->set("date_reception", "'" . $this->getCurrentDate() . "'", FALSE);
        $this->db->where("CONCAT(code, '-', num_document, '/', year_document) = '$params[numDocument]' AND area_id = $areaId AND returned = 0 AND view = 0");
        $response = $this->db->update("mngmail_assing_to");
        
        if(!$response){
            return array("error" => TRUE);
        }
        
        return array(
            "success" => TRUE
        );
    }
    
    public function getResponseFolio($scape = FALSE) {
        
        $documentCode = $this->getAreaEmployee($this->session->userdata("userInfo")["employee_id"]);        
        
        $currentYear  = date("Y");
        $docOut       = strlen($documentCode["main_code_doc"]) == 0 
                ? "$documentCode[clave]-$documentCode[document_code]" 
                : "$documentCode[clave]-$documentCode[main_code_doc]-$documentCode[document_code]";
        
        $this->db->select("if(max(num_doc_out) is null, 1, max(num_doc_out) + 1) as numDocument", FALSE);
        $countDocument = $this->db->get_where("mngmail_documents", "code_out = '$docOut' AND year_doc_out = '$currentYear'")->result_array();
        $numDocument   = $countDocument[0]["numDocument"];

        return $scape ? array(
            "code_out"     => "'$docOut'",
            "num_doc_out"  => $numDocument < 10 ? "'0$numDocument'" : "'$numDocument'",
            "year_doc_out" => "'$currentYear'"
        ) : array(
            "code_out"     => "$docOut",
            "num_doc_out"  => $numDocument < 10 ? "0$numDocument" : $numDocument,
            "year_doc_out" => $currentYear
        );
    }
    
    public function sendResponse($folioDoc, $dataResponse, $docWResponse = FALSE, $scape = FALSE) {
        
        $response = $this->edit("mngmail_documents", $folioDoc, $dataResponse, TRUE, $scape);
        
        if($docWResponse){
            $this->edit("mngmail_files_uploaded", $folioDoc, array("final_document" => 1), TRUE);
        }
        
        $this->edit("mngmail_assing_to", $folioDoc, array("view" => 0));
        
        return $response;
        
    }
    
    public function getVersionDoc($folio){
        
        $folio["check_document"] = 1;
        
        $this->db->select("COUNT(files_uploaded_id) as version");
        $version = $this->db->get_where("mngmail_files_uploaded", $folio)->result_array();
        
        return $version[0]["version"] < 10 ? "0" . $version[0]["version"] : $version[0]["version"];
        
    }
    
    public function getAreaEmployee($employeeId) {
        return parent::getAreaEmployee($employeeId);
    }
    
    public function getEmployeeData($params){
        $this->db->select("employees_id as id, name as text", FALSE);
        $this->db->like("name", $params["term"]);
        
        if(isset($params["id"])){
            $this->db->where_in("employees_id", $params["id"]);
        }
        
        if(isset($params["employee_id"])){
            $this->db->where("employees_id != $params[employee_id]");
        }
        $this->db->order_by("name", "asc");
        $contacts = $this->db->get_where("employees", "active = 1");
        
        return $contacts->result_array();
    }
    
    public function answeredDoc($params){
        
        $reAssing                = array();
        $docData                 = $this->getDocumentData(array("folio" => $params["numDocument"]));
        $reAssing["employee_id"] = $params["employee_id"];
        $reAssing["view"]        = 0;
        
        if(isset($params["cc"])){
            $this->setCC($params);
            unset($params["cc"]);
        }
        
        $this->edit("mngmail_assing_to", array_merge($docData, array("returned" => 0)), $reAssing);
        
        unset($params["employee_id"]);
        unset($params["numDocument"]);
        $params["status_id"] = 7;
        $this->edit("mngmail_documents", $docData, $params, TRUE, TRUE);
        
        return array(
            "success" => TRUE
        );        
    }
    
    public function setAccepted($params){
        
        $docFolio     = $this->getDocumentData(array("folio" => $params["numDocument"]));
        $dateAccepted = date("Y-m-d H:i", strtotime($this->getCurrentDate()));
        
        $responseFolio              = $this->getResponseFolio(TRUE);
        $responseFolio["comments"]  = "CONCAT('-----Respuesta aceptada por " . $this->session->userdata("userInfo")["employee"]  . " a las $dateAccepted-----\n', comments)";
        $responseFolio["status_id"] = 5;$responseFolio["answered"] = 1;
        
        $lastFile = $this->getFilesData(array("control_folio" => $params["numDocument"]))[0];unset($params["numDocument"]);
        
        if(strtolower($lastFile["extension"]) == ".pdf" && $lastFile["check_document"] == 0){
            $updateDoc["status_id"] = 2;
            $updateDoc["only_read"] = 1;
            $updateDoc["defeated"]  = 0;
            $this->edit("mngmail_files_uploaded", $docFolio, array("final_document" => 1), TRUE);
            $this->edit("mngmail_documents", $docFolio, $updateDoc, TRUE, TRUE);
        }else{
            $this->edit("mngmail_documents", $docFolio, $responseFolio, TRUE, TRUE);
        }
        
        
        $this->edit("mngmail_assing_to", array_merge($docFolio, array("returned" => 0)), array("view" => 0));
        
        return array(
            "success" => TRUE, "folioResponse" => (strtolower($lastFile["extension"]) == ".pdf" && $lastFile["check_document"] == 0) ? "$docFolio[code]-$docFolio[num_document]/$docFolio[year_document]" : "$responseFolio[code_out]-$responseFolio[num_doc_out]/$responseFolio[year_doc_out]"
        );   
    }
    
    public function setRejected($params){
        
        $docFolio     = $this->getDocumentData(array("folio" => $params["numDocument"]));
        $dateReturned = $this->getCurrentDate();
        $docData      = array(
            "comments"  => "CONCAT('$params[comments]', '\n-----Respuesta fue rechazada el $dateReturned correción en espera-----\n', comments)",
            "status_id" => 4
        );
        
        unset($params["numDocument"]);
        unset($params["comment"]);
        
        $this->edit("mngmail_assing_to", array_merge($docFolio, array("returned" => 0)), array("view" => 0));
        $this->edit("mngmail_documents", $docFolio, $docData, TRUE, TRUE);
        
        return array("success" => TRUE);
    }
    
    public function setViewDocument($params){
        
        $this->edit("mngmail_assing_to", "concat(code, '-', num_document, '/', year_document) = '$params[control_folio]'", array("view" => 1));
        $this->edit("mngmail_documents", "concat(code, '-', num_document, '/', year_document) = '$params[control_folio]'", array(), TRUE);
        return array("success" => TRUE);
    }
    
    public function getFilesData($params){
        
        $query = <<<QUERY
select 
    mfu.path, mfu.name as fileName, mfu.extension, mfu.check_document
from
    mngmail_files_uploaded mfu
join (select code, num_document, year_document, max(date_creation) as date_creation from mngmail_files_uploaded group by concat(code, '-', num_document, '/', year_document)) mfu2
	on mfu.code = mfu2.code and mfu.num_document = mfu2.num_document and mfu.year_document = mfu2.year_document and mfu.date_creation = mfu2.date_creation
where concat(mfu.code, '-', mfu.num_document, '/', mfu.year_document) = '$params[control_folio]' and mfu.active = 1;
QUERY;
        
        return $this->db->query($query)->result_array();
        
    }
    
    public function setComment($params) {
        $docFolio     = $this->getDocumentData(array("folio" => $params["numDocument"]));
        $dateReturned = $this->getCurrentDate();
        $docData      = array(
            "comments"  => "CONCAT('$params[comments]', '\n-----Comentario realizado por " . $this->session->userdata("userInfo")["employee"] . " el $dateReturned -----\n', comments)"
        );
        
        unset($params["numDocument"]);
        unset($params["comments"]);
        
        $this->edit("mngmail_documents", $docFolio, $docData, TRUE, TRUE);
        
        return array("success" => TRUE);
    }
    
}