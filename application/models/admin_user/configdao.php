<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of configdao
 *
 * @author oscar.f.medellin
 */
class ConfigDao extends VX_Model {
    
    public function __construct() {
        parent::__construct();
        
        $this->load->library("session");
    }
    
    public function saveDataEmployee($idEmployee, $dataEmployee, $logs = TRUE) {
        
        $userData = $this->session->userdata("userInfo");
        
        $this->edit("employees", array("employees_id" => $idEmployee), $dataEmployee, $logs);
        if(isset($dataEmployee["picture"])){$userData["avatar"] = $dataEmployee["picture"];}
        $userData["employee"] = isset($dataEmployee["name"]) ? $dataEmployee["name"] : $userData["employee"];
        
        $this->session->set_userdata("userInfo", $userData);
        
        return array("success" => TRUE);
        
    }
    
}
