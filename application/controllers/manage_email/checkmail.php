<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mainctr
 *
 * @author oscar.f.medellin
 */
class checkMail extends VX_Controller {

    public function __construct() {

        parent::__construct();

        $this->load->library("session");
        $this->load->model("manage_email/inmaildao", "inmail");
        $this->load->model("manage_email/pendingdocdao", "pending");
        $this->load->model("manage_email/checkmaildao", "dao");
    }

    public function getTableAnswered() {

        $params = $this->input->post();
        $tableResult = $this->dao->getTableAnswered($params);

        echo json_encode($tableResult);
    }
    
    public function getTablePending() {

        $params = $this->input->post();
        $tableResult = $this->dao->getTablePending($params);

        echo json_encode($tableResult);
    }
    
    public function getAntecedents(){
        
        $params      = $this->input->post();
        $antecedents = $this->dao->getAntecedents($params);
        array_pop($antecedents);
        
        echo json_encode($antecedents);
    }
    
    public function setEdit(){
        
        $params = $this->input->post();
        echo json_encode($this->dao->setEdit($params));
    }
    
    public function addAnsweredDocument() {
        
        $params       = $this->input->post();
        $areaCode     = $params["areaCode"];
        $mainFolio    = $this->inmail->getDocumentData(array("folio" => $params["numDocument"]));
        $employeeData = $this->session->userdata("userInfo");
        $dateAccepted = date("Y-m-d H:i", strtotime($this->getCurrentDate(TRUE)));
        unset($params["numDocument"]);unset($params["areaCode"]);
        
        $params["comments"]  = "CONCAT('$params[comments]','\n-----Respuesta elaborada por $employeeData[employee] a las $dateAccepted-----\n', comments)";
        $params["status_id"] = 3;

        if (isset($_FILES["file"])) {

            $urlComplete         = $this->checkURL(array("managemail", $areaCode, "waiting"), FALSE);
            $fileVersion         = $this->pending->getVersionDoc($mainFolio);
            $fileData            = $this->saveFiles($urlComplete, array("office", "pdf"), "$mainFolio[code]-$mainFolio[num_document]/$mainFolio[year_document]-answer-Ver$fileVersion");
            
            foreach ($fileData as $key => $value){$fileData[$key]["check_document"] = 1;}
            $this->inmail->saveImagesFromDocument($mainFolio, $fileData);
        }
        
        $this->pending->sendResponse($mainFolio, $params, FALSE, TRUE);

        echo json_encode(array(
            "success" => TRUE
        ));
    }
    
}