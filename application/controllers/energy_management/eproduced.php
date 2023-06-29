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
class eproduced extends VX_Controller{
    
    public function __construct() {
        
        parent::__construct();
        
        $this->load->library("session");
        
       $this->load->model("energy_management/mainctrdao", "mainctrdao");
    }
    
    
    
    
    
    public function saveForms() {
        
       
        //$userInfoData = $this->mainctrdao->getInfoWorkCenter($this->getUserData());
        //$params   = $this->input->post();

       echo json_encode($this->mainctrdao->getInfoWorkCenter($this->getUserData()));
    }
    
    
    
}
