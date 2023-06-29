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
class inMail extends VX_Controller{
    
    public function __construct() {
        
        parent::__construct();
        
        $this->load->library("session");
        
        $this->load->model("manage_email/maindao", "mainmodel");
        $this->load->model("manage_email/inmaildao", "dao");
        $this->load->model("manage_email/pendingdocdao", "pendingdoc");
        $this->load->model("manage_email/outmaildao", "outmail");
        
        $this->load->library("PHPMailerObj", "phpmailerobj");
    }
    
    public function getEmailContact() {

        $data = $this->input->get();
        echo json_encode($this->dao->getEmail($data));
    }

    public function getSender() {

        $data = $this->input->get();
        echo json_encode($this->dao->getSender($data));
    }
    
    public function getSignatoryContact() {

        $data = $this->input->get();
        echo json_encode($this->dao->getSignatoryContact($data));
    }
    
    public function saveNewDoc() {
        
        $params   = $this->input->post();
        echo json_encode($this->dao->saveNewDoc($params));
    }
    
    public function getTable() {
        $params      = $this->input->post();
        $tableResult = $this->dao->getTable($params);

        echo json_encode($tableResult);
    }
    
    public function initDocumentArea(){
        
        $params  = $this->input->post();
        $docData = $this->dao->initDocumentArea(isset($params["status_id"]) ? $params["status_id"] : NULL);
                
        if(!$docData){
            $docFolio = $this->dao->getDocumentFolio(TRUE);
            $this->dao->addNewDoc(array_merge($docFolio, array("status_id" => isset($params["status_id"]) ? $params["status_id"] : 9)));
        }
                
        echo json_encode(array(
            "docData" => !$docData ? array(
                "control_folio" => "$docFolio[code]-$docFolio[num_document]/$docFolio[year_document]") : $docData,
            "success" => TRUE
        ));
    }
    
    public function addNewDoc(){
        
        $docData     = $this->dao->getDocumentFolio(TRUE);
        $urlComplete = $this->checkURL(array("managemail", "$docData[code]"), FALSE);        
        $fileData    = $this->saveFiles($urlComplete, array("pdf"), "$docData[code]-$docData[num_document]$docData[year_document]");
        $this->dao->addNewDoc($docData);
        
        $filesUploaded = $this->dao->saveImagesFromDocument($docData, $fileData);

        if(isset($filesUploaded["error"])){
            echo json_encode($filesUploaded);
            return;
        }
        
        echo json_encode(array(
            "success" => TRUE,
            "wait"    => TRUE
        ));
    }
    
    public function sendMailToAgent(){
        
        $params                 = $this->input->post();
        $params["mat.returned"] = 0;
        $params["m.id"]         = 2;
        
        $dataMail               = array(
            "subject" => "Documento Asignado",
            "html"    => TRUE,
            "from"    => "Gestión Corresponcía"
        );
        
        if(isset($params["comment"])){unset($params["comment"]);}
        
        $getEmailsToSend        = $this->mainmodel->getEmailToSend($params);
        $infoDoc                = $this->dao->getInfoDoc($params["control_folio"]);
        $dataMail["msg"]        = $this->load->view("manage_email/mails/mailNewDoc", $infoDoc, TRUE);
        
//        $this->phpmailerobj->setDebugMailer();
        $this->phpmailerobj->configMailer();
        $this->phpmailerobj->setSharedMail("manage.mail@fenixenergia.com.mx");
        $this->phpmailerobj->setAddress($getEmailsToSend);
        $sendStatus = $this->phpmailerobj->sendMailer($dataMail);
        
        if($sendStatus["status"] == "error"){
            echo json_encode($sendStatus);
            return;
        }
        
        echo json_encode($sendStatus);
    }
    
    public function sendMailDefeated(){
        
        $params                 = $this->input->post();
        $params["mat.returned"] = 0;
        $dataMail               = array("subject" => "Documento Vencido", "html" => TRUE, "from" => "Gestión Corresponcía");
        $docData                = $this->dao->getDataDocumentComplete(array( "control_folio" => $params["folioInDoc"]));
        $getEmailsToSend        = NULL;
                
        switch (intval($docData["status_id"])){
            case 4:case 7:
                $employeeSearch = array("employee_id" => $docData["employee_id"]);$params["msg"] = "Elaboración"; $getEmailsToSend = array($this->dao->searchCompleteEmployeeData($employeeSearch)["email"]); break;
            case 3:
                $params["m.id"] = 2; $getEmailsToSend = $this->mainmodel->getEmailToSend($params); $params["msg"] = "Revisión"; break;
            case 5:
                $params["m.id"] = 4; $getEmailsToSend = $this->mainmodel->getEmailToSend($params); $params["msg"] = "Firma y Digitalización"; break; 
        }
        
        $dataMail["msg"] = $this->load->view("manage_email/mails/mailDefeatedDoc", $params, TRUE);
        
        $this->phpmailerobj->configMailer();
        $this->phpmailerobj->setSharedMail("manage.mail@fenixenergia.com.mx");
        $this->phpmailerobj->setAddress($getEmailsToSend);
        $sendStatus = $this->phpmailerobj->sendMailer($dataMail);
        
        if($sendStatus["status"] == "error"){echo json_encode($sendStatus);return;}
        
        echo json_encode($sendStatus);
    }
    
    public function replaceDocument(){
        
        $params = $this->input->post();
        
        $files  = $this->pendingdoc->getFilesData($params);
        
        foreach($files as $file){
            $this->saveFiles($file["path"], array("pdf"), "$file[fileName]");
        }
        
        echo json_encode(array("success" => TRUE));
    }
    
    public function addAcknowledgment(){
        
        $params    = $this->input->post();
        $docData   = $this->dao->getDocumentData($params, TRUE);
        $mainFolio = $docData["mainFolio"];
        $outFolio  = $docData["outFolio"];
                
        if (isset($_FILES["file"])) {

            $areaCode    = $this->dao->getDataDocumentComplete(array("control_folio" => $params["folio"]))["areaCode"];            
            $urlComplete = $this->checkURL(array("managemail", $areaCode, "answered"), FALSE);
            $fileData    = $this->saveFiles($urlComplete, array("pdf"), "$outFolio[code_out]-$outFolio[num_doc_out]$outFolio[year_doc_out]-acknowledgment");
            
            for ($i = 0; $i < count($fileData); $i++) {
                $fileData[$i]["final_document"] = 1;
                $fileData[$i]["acknowledgment_document"] = 1;
            }

            $this->dao->saveImagesFromDocument($mainFolio, $fileData);
            $this->outmail->sendResponse($mainFolio, array("acknowledgment" => 1));
        }
        
        echo json_encode(array("success" => TRUE));
    }
    
    public function getFileToView(){
        
        $params  = $this->input->post();
        $folio   = $this->dao->getDocumentData(array("folio" => $params["control_folio"]));
        
        unset($params["control_folio"]);
        
        echo json_encode($this->dao->getFileToView(array_merge($folio, $params)));
    }
    
}
