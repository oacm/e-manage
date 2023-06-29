<?php

require_once 'PHPMailer/PHPMailerAutoload.php';

class PHPMailerObj {    
    
    private $phpMailer   = NULL;
    private $debugMailer = 0;
    private $configMail  = array(
        "user"       => "jose.mendoza@fenixenergia.com.mx",
        "sharedMail" => NULL,
        "pass"       => "J05e..#$$055M31qU14}}",
        "server" => array(
            "office365" => array(
                "smtp"     => "smtp.office365.com",
                "port"     => 587,
                "security" => "tls"
            )
        )
    );
    
    
    public function __construct($configDefault = array()) {
        $this->configMail["user"] = isset($configDefault["user"]) ? $configDefault["user"] : $this->configMail["user"];
        $this->configMail["pass"] = isset($configDefault["pass"]) ? $configDefault["pass"] : $this->configMail["pass"];
        $this->phpMailer          = new PHPMailer();
    }
    
    public function setUser($userName){
        $this->configMail["user"] = $userName;
    }
    
    public function getUser(){
        return $this->configMail["user"];
    }
    
    public function setPassword($password){
        $this->configMail["pass"] = $password;
    }
    
    public function setConfigServer($nameServer, $config = array()){
        
        if(!isset($this->configMail["server"][$nameServer])){
            $this->configMail["server"][$nameServer] = array(
                "smtp"     => "",
                "port"     => NULL,
                "security" => ""
            );
        }
        
        $this->configMail["server"][$nameServer]["smtp"]     = isset($config["smtp"]) ? $config["smtp"] : $this->configMail["server"][$nameServer]["smtp"];
        $this->configMail["server"][$nameServer]["port"]     = isset($config["port"]) ? $config["port"] : $this->configMail["server"][$nameServer]["port"];
        $this->configMail["server"][$nameServer]["security"] = isset($config["security"]) ? $config["security"] : $this->configMail["server"][$nameServer]["security"];
        
        return $nameServer;
        
    }
    
    public function setSharedMail($sharedMail = "soporte@fenixenergia.com.mx"){
        $this->configMail["sharedMail"] = $sharedMail;
    }
    
    public function setDebugMailer($debugMailer = 2){
        $this->debugMailer = $debugMailer;
    }
    
    public function setAddress($address){
        
        if(gettype($address) == "array"){
            foreach ($address as $value) {
                $this->phpMailer->addAddress($value, "Notificaciones Fénix");
            }
        }else{
            $this->phpMailer->addAddress($address, "Notificaciones Fénix");
        }
        
    }
    
    public function setCC($address){
        
        if(gettype($address) == "array"){
            foreach ($address as $value) {
                $this->phpMailer->addCC($value, "Notificaciones Fénix");
            }
        }else{
            $this->phpMailer->addCC($address, "Notificaciones Fénix");
        }
        
    }
    
    public function setBCC($address){
        
        if(gettype($address) == "array"){
            foreach ($address as $value) {
                $this->phpMailer->addBCC($value, "Notificaciones Fénix");
            }
        }else{
            $this->phpMailer->addBCC($address, "Notificaciones Fénix");
        }
        
    }
    
    public function clearAddress(){
        $this->phpMailer->clearAddresses();
        $this->phpMailer->clearCCs();
        $this->phpMailer->clearBCCs();
    }
    
    public function configMailer($nameServer = "office365", $isSMTP = TRUE){
        
        if($isSMTP){$this->phpMailer->isSMTP ();}
        
        $this->phpMailer->Host       = $this->configMail["server"][$nameServer]["smtp"];
        $this->phpMailer->SMTPAuth   = TRUE;
        $this->phpMailer->SMTPDebug  = $this->debugMailer;
        $this->phpMailer->Username   = $this->configMail["user"];
        $this->phpMailer->Password   = $this->configMail["pass"];
        $this->phpMailer->SMTPSecure = $this->configMail["server"][$nameServer]["security"];
        $this->phpMailer->Port       = $this->configMail["server"][$nameServer]["port"];
        
        return $nameServer;
        
    }
    
    public function sendMailer($dataMailer){
        
        $sendStatus = array();
        
        if(!is_null($this->configMail["sharedMail"])){
            $this->phpMailer->setFrom($this->configMail["sharedMail"], $dataMailer["from"]);
        }else{
            $this->phpMailer->setFrom($this->configMail["user"], $dataMailer["from"]);
        }
        
        if($dataMailer["html"]){$this->phpMailer->isHTML(TRUE);}
        
        $this->phpMailer->Subject = $dataMailer["subject"];
        $this->phpMailer->CharSet = "UTF-8";
        $this->phpMailer->MsgHTML($dataMailer["msg"]);
        
        if(!$this->phpMailer->send()){
            echo json_encode(array(
                "status" => "error",
                "messageSystem" => $this->phpMailer->ErrorInfo
            ));
            exit();
        }else{
            $sendStatus["status"]        = "success";
            $sendStatus["messageSystem"] = $this->phpMailer->ErrorInfo;
        }
        
        return $sendStatus;
    }
    
}