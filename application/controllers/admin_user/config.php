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
class Config extends VX_Controller{
    
    public function __construct() {
        
        parent::__construct();
        
        $this->load->library("session");
        
        $this->load->model("admin_user/configdao", "dao");
    }
    
    public function saveConfig(){
        
        $params = $this->input->post();
        
        if (isset($_FILES["file"])) {

            $urlComplete = $this->checkURL(array("images", "profile"), FALSE);
            $fileData    = $this->saveFiles($urlComplete, array("image"), 
                    str_replace(".", "-", explode("@", $this->session->userdata("userInfo")["user"])[0] 
                            . "_" . $this->session->userdata("userInfo")["employee_id"]))[0];
            
            $params = array_merge(array("picture" => "$fileData[name]$fileData[extension]"), $params);
        }
        
        echo json_encode($this->dao->saveDataEmployee($this->session->userdata("userInfo")["employee_id"], $params));
    }
    
}