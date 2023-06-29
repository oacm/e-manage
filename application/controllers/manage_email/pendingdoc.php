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
class pendingDoc extends VX_Controller {
    
    public function __construct() {

        parent::__construct();

        $this->load->library("session");
        $this->load->model("manage_email/inmaildao", "inmail");
        $this->load->model("manage_email/pendingdocdao", "dao");
        $this->load->model("manage_email/outmaildao", "outmail");
    }
    
    private function createThumb($imgRoot, $typeFile, $filePath){
        switch ($typeFile) {
            case "pdf":                    
                $imagen    = new Imagick("{$imgRoot}[0]");

                $imagen->thumbnailImage(100, 0);
                $imagen->writeimage($_SERVER['DOCUMENT_ROOT'] . FOLDER_DEFAULT . "$filePath");
                break;
            default:
                $imagen    = new Imagick("$imgRoot");

                $imagen->thumbnailImage(100, 0);
                $imagen->writeimage($_SERVER['DOCUMENT_ROOT'] . FOLDER_DEFAULT . "$filePath");
        }
    }

    public function getTable() {

        $params = $this->input->post();
        $tableResult = $this->dao->getTable($params);

        echo json_encode($tableResult);
    }
    
    public function getTableReview() {

        $params = $this->input->post();
        $tableResult = $this->dao->getTableReview($params);

        echo json_encode($tableResult);
    }

    public function getTheme() {
        $data = $this->input->get();
        echo json_encode($this->dao->getTheme($data));
    }

    public function getPriority() {
        $data = $this->input->get();
        echo json_encode($this->dao->getPriority($data));
    }

    public function getAntecedent() {

        $params     = $this->input->post();
        $antecedent = $this->dao->getAntecedent($params);

        foreach ($antecedent as $key => $docData) {
            $urlFile   = $docData["docOut"];
            $typeFile  = substr($urlFile, strrpos($urlFile, ".", -1) + 1);
            $imgRoot   = $_SERVER["DOCUMENT_ROOT"] . FOLDER_DEFAULT . "$urlFile";
            $filePath  = "uploads/managemail/thumb/$docData[codeOut]-$docData[numDocOut]-$docData[yearDocOut].jpg";
            
            $thumData = array(
                "subject"  => $docData["subject"],
                "theme"    => $docData["theme"],
                "folioDoc" => "$docData[codeOut]-$docData[numDocOut]/$docData[yearDocOut]",
                "docOut"   => $docData["docOut"]
            );
            
            if(!file_exists($filePath)){
                $this->createThumb($imgRoot, $typeFile, $filePath);
            }
            
            $thumData["thumbUrl"]      = base_url() . $filePath;
            $antecedent[$key]["thumb"] = $this->load->view("/tpl_general/thumb", $thumData, TRUE);
        }

        echo json_encode($antecedent);
    }

    public function setView() {

        $params = $this->input->post();
        echo json_encode($this->dao->setView($params));
    }
    
    public function getCC(){
        $params = $this->input->post();
        echo json_encode($this->dao->getCC($params));
    }

    public function returnedDoc() {
        
        $params                    = $this->input->post();
        
        $areaData                  = $this->dao->getAreaEmployee($this->session->userdata("userInfo")["employee_id"])["name"];
        $dateReturned              = $this->getCurrentDate()->format("Y-m-d H:i:s"); 
        $params["expiration_date"] = isset($params["priority_id"]) ? 
                "'" . $this->calculateExpiration($params["priority_id"]) . "'" : "'0000-00-00 00:00:00'";
        $params["comments"]        = "CONCAT('$params[comments]', '\n-----Returnado a las $dateReturned por el área $areaData-----\n', comments)";
        
        if(isset($params["priority_id"])){$params["priority_id"] = strlen($params["priority_id"]) == 0 ? 4 : $params["priority_id"];}
        if(isset($params["theme_id"])){$params["theme_id"] = $this->dao->getIdThemeDoc($params["theme_id"]);}
        
        if(isset($params["antecedent"])){$params["antecedent"] = "'$params[antecedent]'";}
        
        echo json_encode($this->dao->returnedDoc($params));
    }

    private function calculateExpiration($priority) {

        $dateExpiration = $this->getCurrentDate();
        $notApply       = FALSE;

        switch ($priority) {
            case 1:
                $dateExpiration->modify("+2 day");
                break;
            case 2:
                $dateExpiration->modify("+5 day");
                break;
            case 3:
                $dateExpiration->modify("+15 day");
                break;
            default :
                $notApply = TRUE;
        }

        return $notApply ? "0000-00-00 00:00:00" : $dateExpiration->format("Y-m-d H:i:s");
    }

    public function setDocKnownledge(){
        
        $params    = $this->input->post();
        $mainFolio = $this->inmail->getDocumentData(array("folio" => $params["numDocument"]));
        
        if(!isset($params["priority_id"])){
            $params["priority_id"] = 4;
        }
        
        $params["theme_id"]        = $this->dao->getIdThemeDoc(isset($params["theme_id"]) ? $params["theme_id"] : "No Aplica");
        $params["expiration_date"] = $this->calculateExpiration($params["priority_id"]);
        $params["answered"]        = 1;
        $params["only_read"]       = 1;
        $params["status_id"]       = 2;
        $params["defeated"]        = 0;
        
        unset($params["numDocument"]);
        
        $this->dao->sendResponse($mainFolio, $params, TRUE);
        
        echo json_encode(array(
            "success" => TRUE,
            "folioResponse" => "$mainFolio[code]-$mainFolio[num_document]/$mainFolio[year_document]"
        ));
    }
    
    public function getEmailContact() {

        $data = $this->input->get();
        $data["area_id"] = $this->dao->getAreaEmployee($this->session->userdata("userInfo")["employee_id"])["area_id"];
        
        echo json_encode($this->inmail->getEmail($data));
    }
    
    public function getEmployeeData(){
        $data = $this->input->get();
        
//        if(!isset($data["id"])){
//            $data["employee_id"] = $this->session->userdata("userInfo")["employee_id"];
//        }
        
        echo json_encode($this->dao->getEmployeeData($data));
    }
    
    public function answeredDoc(){
        $params                    = $this->input->post();
//        echo json_encode($params);
//        return;
        $employeeData              = $this->session->userdata("userInfo")["employee"];
        $dateReturned              = $this->getCurrentDate()->format("Y-m-d H:i:s"); 
        $params["expiration_date"] = isset($params["priority_id"]) ? "'" . $this->calculateExpiration($params["priority_id"]) . "'" : "'0000-00-00 00:00:00'";
        $params["comments"]        = "CONCAT('$params[comments]', '\n-----$employeeData solicita la elaboración de respuesta el $dateReturned-----\n', comments)";
        $params["theme_id"]        = $this->dao->getIdThemeDoc(isset($params["theme_id"]) ? $params["theme_id"] : "No Aplica");
        
        if(isset($params["antecedent"])){$params["antecedent"] = "'$params[antecedent]'";}
        
        echo json_encode($this->dao->answeredDoc($params));
    }
    
    public function setAccepted(){
        
        $params        = $this->input->post();        
        $response      = $this->dao->setAccepted($params);
        
        echo json_encode($response);
    }
    
    public function setRejected(){
        
        $params = $this->input->post();
        echo json_encode($this->dao->setRejected($params));
    }
    
    public function setViewDocument(){
        
        $params = $this->input->post();
        echo json_encode($this->dao->setViewDocument($params));
    }
    
    public function getFilesData(){
        $params = $this->input->post();
        echo json_encode($this->dao->getFilesData($params)[0]);
    }
    
    public function setComment(){
        $params = $this->input->post();
        echo json_encode($this->dao->setComment($params));
    }
    
    public function getResponseFolio(){
        
        $controlFolio = $this->inmail->getDocumentData(array("folio" => $this->input->post()["control_folio"]));
        $folioOut     = $this->dao->getResponseFolio();
        
        $this->outmail->sendResponse($controlFolio, $folioOut);
        
        echo json_encode(array(
            "success"           => TRUE,
            "control_folio_out" => "$folioOut[code_out]-$folioOut[num_doc_out]/$folioOut[year_doc_out]"
        ));
    }
    
    public function setNewDocArea(){
        $params        = $this->input->post();
        
        $documentFolio = $this->inmail->getIdDoc($params["control_folio"]);
        $docFolioOut   = $params["folio_doc_out"];
        
        $params["sender_id"]       = $this->inmail->getIdSender("--------");
        $params["contact_id"]      = $this->inmail->getIdContact("--------");
        $params["theme_id"]        = $this->dao->getIdThemeDoc(isset($params["theme_id"]) ? $params["theme_id"] : "No Aplica");
        $params["priority_id"]     = 4;
        $params["expiration_date"] = $this->calculateExpiration(4);
        $params["answered"]        = 1;
        $params["status_id"]       = 2;
        $params["not_initial_doc"] = 1;

        $areaCode    = $this->dao->getAreaEmployee($this->session->userdata("userInfo")["employee_id"])["document_code"];
        $urlComplete = $this->checkURL(array("managemail", $areaCode, "answered"), FALSE);
        $fileData    = $this->saveFiles($urlComplete, array("pdf", "image"), "$docFolioOut");

        for ($i = 0; $i < count($fileData); $i++) {$fileData[$i]["final_document"] = 1;}

        $this->inmail->saveImagesFromDocument($documentFolio, $fileData);
        
        $docId = array_merge($documentFolio, array("area_id" => $this->dao->getAreaEmployee($this->session->userdata("userInfo")["employee_id"])["area_id"], "employee_id" => $this->session->userdata("userInfo")["employee_id"]));
        $this->inmail->saveAssingTo($docId);
        
        if(isset($params["cc"])){$this->inmail->setCC(array_merge($params, array("numDocument" =>$params["control_folio"])));}
        unset($params["cc"]); unset($params["control_folio"]); unset($params["folio_doc_out"]);
        
        $this->outmail->sendResponse($documentFolio, $params);
        
        echo json_encode(array("success" => TRUE));
        
    }
    
}
