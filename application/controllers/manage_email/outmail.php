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
class outMail extends VX_Controller {

    public function __construct() {

        parent::__construct();

        $this->load->library("session");
        $this->load->model("manage_email/inmaildao", "inmail");
//        $this->load->model("manage_email/pendingdocdao", "pending");
//        $this->load->model("manage_email/checkmaildao", "dao");
        $this->load->model("manage_email/outmaildao", "dao");
    }

    public function getTableWaiting() {
        $params      = $this->input->post();
        $tableResult = $this->dao->getTableWaiting($params);

        echo json_encode($tableResult);
    }
    
    public function getTableHistory(){
        $params      = $this->input->post();
        $tableResult = $this->dao->getTableHistory($params, "historyMain");

        echo json_encode($tableResult);
    }
    
    public function getTableHistoryTurned(){
        $params      = $this->input->post();
        $tableResult = $this->dao->getTableHistory($params, "historyTurned");

        echo json_encode($tableResult);
    }
    
    public function setResponseDocument(){
        
        $params          = $this->input->post();
        $mainFolio       = $this->dao->getDocumentData(array("folio" => $params["docOut"]));
        $docCompleteData = $this->dao->getDocumentInfo(array("control_folio_out" => $params["docOut"]))[0];
        
        if (isset($_FILES["file"])) {

            $areaCode    = $docCompleteData["areaCode"];
            $urlComplete = $this->checkURL(array("managemail", $areaCode, "answered"), FALSE);
            $fileData    = $this->saveFiles($urlComplete, array("pdf", "image"), "$params[docOut]");
            unset($params["docOut"]);
            
            $params["status_id"] = 2;
            $params["defeated"]  = 0;
            $params["answered"]  = 1;
            
            for ($i = 0; $i < count($fileData); $i++) {$fileData[$i]["final_document"] = 1;}

            $this->inmail->saveImagesFromDocument($mainFolio, $fileData);
            $this->dao->sendResponse($mainFolio, $params);
            
        }
        
        echo json_encode(array("success" => TRUE));
    }

}
