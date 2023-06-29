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
class inMailDao extends VX_Model {
    //put your code here
    public function __construct() {
        parent::__construct();
        
        $this->load->library("DataTables", "datatables");
        $this->load->library("session");
    }
    
    public function getAreaEmployee($employeeId) {
        return parent::getAreaEmployee($employeeId);
    }
    
    public function searchCompleteEmployeeData($params){
        return parent::searchCompleteEmployeeData($params);
    }
    
    public function getEmail($params) {
        
        $this->db->select("a.area_id as id, concat(a.name, ' - ', cc.name) as text", FALSE);
        $this->db->join("positions p", "p.position_id = e.position_id");
        $this->db->join("areas a", "a.area_id = p.area_id");
        $this->db->join("cat_corps_subsidiary ccs", "ccs.corp_subsidiary_id = e.corp_subsidiary_id");
        $this->db->join("cat_corps cc", "cc.corp_id = ccs.corp_id");
        $this->db->like("concat(a.name, ' - ', cc.name)", $params["term"]);
        
        if(isset($params["area_id"])){
            $this->db->where("a.area_id != $params[area_id]");
        }
        
        $this->db->group_by("text");
        $this->db->order_by("text", "asc");
        
        $contacts = $this->db->get_where("employees e", "a.active = 1");
        
        return $contacts->result_array();
    }
    
    public function getSender($params) {

        $query = <<<QUERY
SELECT
    sender_id as id,
    name as text
FROM cat_sender
WHERE name LIKE '%$params[term]%' AND active = 1;
QUERY;

        $sender = $this->db->query($query);

        return $sender->result_array();
    }
    
    public function getSignatoryContact($params) {

        $query = <<<QUERY
SELECT
    contact_senders_id as id, 
    name as text
FROM cat_contact
WHERE name LIKE '%$params[term]%' AND active = 1;
QUERY;

        $signatory = $this->db->query($query);

        return $signatory->result_array();
    }
    
    public function getIdSender($sender) {

        $id    = NULL;
        $exist = intval($sender);

        $this->db->select("sender_id");

        if ($exist > 0) {
            $result = $this->db->get_where("cat_sender", "sender_id = $sender AND active = 1")->result_array();

            if (count($result) == 0) {
                echo json_encode(array("error" => TRUE, "type" => "sender"));
                exit;
            }

            $id = $result[0]["sender_id"];
        } else {
            $result = $this->db->get_where("cat_sender", "name LIKE '$sender' AND active = 1")->result_array();

            if (count($result) == 0) {
                $insert = $this->add("cat_sender", array("name" => $sender), TRUE);
                if ($insert["error"]) {
                    echo json_encode($insert);
                    exit;
                }

                $id = $insert;
            } else {
                $id = $result[0]["sender_id"];
            }
        }

        return $id;
    }

    public function getIdContact($contact) {

        $id = NULL;
        $exist = intval($contact);

        $this->db->select("contact_senders_id");

        if ($exist > 0) {
            $result = $this->db->get_where("cat_contact", "contact_senders_id = $contact AND active = 1")->result_array();

            if (count($result) == 0) {
                echo json_encode(array("error" => TRUE, "type" => "sender"));
                exit;
            }

            $id = $result[0]["contact_senders_id"];
        } else {
            $result = $this->db->get_where("cat_contact", "name LIKE '$contact' AND active = 1")->result_array();

            if (count($result) == 0) {
                $insert = $this->add("cat_contact", array("name" => $contact), TRUE);
                if ($insert["error"]) {
                    echo json_encode($insert);
                    exit;
                }

                $id = $insert;
            } else {
                $id = $result[0]["contact_senders_id"];
            }
        }

        return $id;
    }
    
    public function getIdDoc($folioDoc){
        
        return parent::getIdDoc($folioDoc);
    }
    
    public function getDocumentFolio($fields = FALSE) {
        
        $currentYear = date("Y");

        $this->db->select("(count(code) + 1) as numDocument", FALSE);
        $countDocument = $this->db->get_where("mngmail_documents", "code = 'FNX-Doc-ECRR' AND year_document = '$currentYear'")->result_array();

        $numDocument   = $countDocument[0]["numDocument"];

        return array(
            !$fields ? "code"           : "code"           => "FNX-Doc-ECRR",
            !$fields ? "documentNumber" : "num_document"   => $numDocument < 10 ? "0$numDocument" : $numDocument,
            !$fields ? "documentYear"   : "year_document"  => $currentYear
        );
    }
    
    public function saveAssingTo($assingTo) {
        
        $id = $this->add("mngmail_assing_to", $assingTo);

        if (isset($id["error"])) {
            return $id;
        }
    }
    
    public function setCC($params){
        
        foreach($params["cc"] as $employee_id){
            
            $this->add("rel_cc_document_employees", array(
                "employee_id" => $employee_id, 
                "control_folio" => $params["numDocument"]));            
        }
        
        return array(
            "success" => TRUE
        );
    }
    
    public function saveNewDoc($params) {

        $documentFolio = $this->getIdDoc($params["numDocument"]);
        
        $documentArray = array(
            "folio_doc"     => $params["folio_document"],
            "subject"       => $params["subject"],
            "comments"      => $params["comments"],
            "antecedent"    => $params["antecedent"],
            "date_document" => $params["date_document"],
            "sender_id"     => $this->getIdSender($params["sender"]),
            "contact_id"    => $this->getIdContact($params["signatory"]),
            "status_id"     => 8
        );
        
        $docId      = array_merge($documentFolio, array("area_id" => $params["area"]));
        $documentId = $this->edit("mngmail_documents", $documentFolio, $documentArray, TRUE);
        
        if (isset($documentId["error"])) {return $documentId;}
        
        if(isset($params["cc"])){$this->setCC($params);}
        $response = $this->saveAssingTo($docId);
        
        if($response["error"]){return $response;}
        
        return array(
            "success"    => TRUE,
            "folioInDoc" => $params["numDocument"]);
    }
    
    public function addNewDoc($params, $logs = TRUE) {

        $documentId = $this->add("mngmail_documents", $params, $logs);

        if (isset($documentId["error"])) {
            echo json_encode($documentId);
            exit();
        }
        
        return array("success" => TRUE);
    }
    
    public function saveImagesFromDocument($idDocument, $files, $logs = TRUE) {
        
        foreach ($files as $file) {
            $fileData = array_merge($idDocument, $file);
            $this->add("mngmail_files_uploaded", $fileData, $logs);
        }
        
        return array("success" => TRUE);
    }
    
    public function getTable($params) {

        $dataTable = $this->datatables->getStructureTable("document_complete_data", "control_folio");
        
        $this->createFields(array("control_folio", "nameStatus", "from_inbox"), $dataTable);
        $this->twfSpecial($dataTable, "control_folio", "viewDocs",function($d, $row, $custom){
            $icons = "<a data-preview data-document='$d' class='viewDoc' href='javascript:void(0);'><i class='icon " . $custom . "'></i></a>";
            if($row["from_inbox"] == 0){$icons .= "<a data-delete data-document='$d' href='javascript:void(0);' class='icon red' title='Reemplazar Archivos'><i class='glyphicon glyphicon-transfer'></i></a>";}
            
            return $icons;
        }, "glyphicon glyphicon-eye-open");
        
        $dataTable["query"] = <<<QUERY
FROM document_complete_data
QUERY;

        $dataTable["where"]   = "status_id = 1";
        $dataTable["groupBy"] = "";
        
        return $this->datatables->getDataTable($params, $dataTable);
    }
    
    public function getDocumentData($params, $withResponseFolio = FALSE){
        
        $select = "code, num_document, year_document";
        
        if($withResponseFolio){
            $select   .= ", code_out, num_doc_out, year_doc_out";
            $mainFolio = NULL;
            $outFolio  = NULL;
        }
        
        $this->db->select($select);
        $this->db->where("CONCAT(code, '-', num_document, '/', year_document) = '$params[folio]'");
        
        $documentData = $this->db->get("mngmail_documents")->result_array();
        
        if($withResponseFolio){
            $mainFolio = array("code" => $documentData[0]["code"], "num_document" => $documentData[0]["num_document"], "year_document" => $documentData[0]["year_document"]);
            $outFolio  = array("code_out" => $documentData[0]["code_out"], "num_doc_out" => $documentData[0]["num_doc_out"], "year_doc_out" => $documentData[0]["year_doc_out"]);
        }
        
        return $withResponseFolio ? array("mainFolio" => $mainFolio, "outFolio" => $outFolio) :  $documentData[0];
        
    }
    
    public function updateDocInWait($folio){
        
        $this->db->set("wait_doc", 1, FALSE);
        $this->db->where("CONCAT(code, '-', num_document, '/', year_document) = '$folio'");
        $response = $this->db->update("mngmail_documents");
        
        if(!$response){
            return array("error" => TRUE);
        }
        
    }
    
    public function getInfoDoc($folioDoc){
        
        $this->db->select("md.folio_doc as folio, md.subject, cs.name as sender");
        $this->db->join("cat_sender cs", "cs.sender_id = md.sender_id");
        $this->db->where("CONCAT(md.code, '-', md.num_document, '/', md.year_document) = '$folioDoc'");
        
        $infoDoc                = $this->db->get("mngmail_documents md")->result_array();
        $infoDoc[0]["folioDoc"] = $folioDoc;
        
        return $infoDoc[0];
        
    }
    
    public function getFileToView($params){
        
        if(!isset($params["final_document"])){$params["final_document"] = 1;}
        
        $this->db->select("path, name as fileName, extension");
        $documentData = $this->db->get_where("mngmail_files_uploaded", $params)->result_array();
        
        return $documentData[0];
    }
    
    public function getDataDocumentComplete($params = array()){
        
        $completeData = $this->db->get_where("document_complete_data", $params)->result_array();
        $responseData = NULL;
        
        switch(count($completeData)){
            case 0:
                $responseData = array();
                break;
            case 1:
                $responseData = $completeData[0];
                break;
            default :
                $responseData = $completeData;
        }
        
        return $responseData;
    }
    
    public function initDocumentArea($status){
        
        $status_id = is_null($status) ? 9 : $status;
        
        $userData = $this->session->userdata("userInfo");
        $docInfo  = parent::getDocumentInfo(array("user_creation" => $userData["employee_id"], "status_id" => "$status_id", "answered" => 0));
        
        return count($docInfo) === 0 ? FALSE : $docInfo[0];
        
    }
}