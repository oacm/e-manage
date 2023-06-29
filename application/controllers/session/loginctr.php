<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of loginctr
 *
 * @author oscar.f.medellin
 */

class LoginCtr extends VX_Controller {

    public function __construct() {
        
        parent::__construct();
        $this->load->model("session/logindao", "dao");
        $this->load->library("PHPMailerObj", "phpmailerobj");
        
    }

    public function login() {
        $params = $this->input->post();
        echo $this->dao->login($params);
    }
    
    public function logout(){
        $this->session->sess_destroy();
        echo json_encode(array("success" => TRUE));
    }
    
    public function recovery(){
        $params = $this->input->post();
        echo $this->dao->recovery($params);
    }
    
    public function updatePass(){
        $params = $this->input->post();
        echo json_encode($this->dao->updatePass($params));
    }
}
