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
class level_tank extends VX_Controller{
    
    public function __construct() {
        
        parent::__construct();
        
        $this->load->library("session");
        $this->load->library("PHPMailerObj", "phpmailerobj");
        
       $this->load->model("energy_management/level_tankdao", "dao");
    }
    
    public function getLevelDamIGS() {
              
//       $userInfoData = $this->mainctrdao->getInfoWorkCenter($this->getUserData());
//       $params   = $this->input->post();
//
//       echo json_encode($this->mainctrdao->getInfoWorkCenter($this->getUserData()));
       
    }
    
    public function setLevelDam() {
        
        $params = $this->input->post();        
        echo json_encode($this->dao->setLevelDam($params));
        
    }
    
    public function setLevelDam2IGS($hoursManually = NULL){
        
        $damInfoId = $this->dao->getDamInfo();
        $result    = array();
        $problems  = array();
        
        foreach ($damInfoId as $value){            
            
            $lastLevelDateDam  = $this->dao->getDateDam($value["id_weather_dam"])[0]["weather_date"];
            
            $seconds           = (strtotime($this->getCurrentDate(TRUE)) - strtotime($lastLevelDateDam));
            $hours             = is_null($hoursManually) ? intval($seconds/60/60) : $hoursManually;
            
            $response          = $this->dao->getLevelDamIGS($value["id_weather_dam"], $value["id_weather_igs"], $lastLevelDateDam, $hours);
            if(count($response["problemStation"]) > 0){$problems[] = $response["problemStation"];}
            $result[] = $response;
        }
        
        if(count($problems) > 0){$this->sendMailProblemStation($problems);}
        
        echo json_encode($result);        
    }
    
    private function sendMailProblemStation($data){
        
        $dataMail = array(
            "subject" => "Datos faltantes en estaciones de IGS",
            "html"    => TRUE,
            "from"    => "Soporte Fénix"
        );
        
        $this->phpmailerobj->setDebugMailer();
        $this->phpmailerobj->configMailer();
        $this->phpmailerobj->setSharedMail("informes.fenix@fenixenergia.com.mx");
        
        
        $dataMail["msg"] = $this->load->view("energy_management/mails/sendMailProblemStation", array("problemStation"=>$data), TRUE);
        $this->phpmailerobj->setAddress("e.contreras@igsmex.com");
        $this->phpmailerobj->setAddress("f.torres@igsmex.com");
        $this->phpmailerobj->setAddress("e.montejo@igsmex.com");
        $this->phpmailerobj->setCC("rui.desousa@fenixenergia.com.mx");
        $this->phpmailerobj->setCC("monserrat.davila@fenixenergia.com.mx");
        $this->phpmailerobj->setCC("jose.mendoza@fenixenergia.com.mx");
        $this->phpmailerobj->setCC("oscar.flores@fenixenergia.com.mx");
        $this->phpmailerobj->setCC("vicente.cordova@fenixenergia.com.mx");
        $this->phpmailerobj->setCC("joao.ribeiro@fenixenergia.com.mx");
        $this->phpmailerobj->sendMailer($dataMail);

        $this->phpmailerobj->clearAddress();
    }
    
}
