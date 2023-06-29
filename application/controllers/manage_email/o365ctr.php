<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of systemctr
 *
 * @author oscar.f.medellin
 */
class o365Ctr extends VX_Controller {
    
    public function __construct() {
        
        parent::__construct(TRUE);
        
        $this->load->model("manage_email/o365dao", "dao");
    }
    
    public function o365AdminConsent(){
        
        $loginUri = $this->dao->o365AdminConsent();
        
        header("location: $loginUri");
    }
    
    public function o365Manage(){
        $params = $this->input->get();
        
        header("location: " . base_url());
    }
    
    public function getToken(){
        
        return $this->dao->getToken();
    }
    
    public function getUsers($data = NULL){
        
        //In post or get method set $jsonResponse = TRUE for echo in json_format
        $params = !is_null($data) ? $data : ($this->input->post() ? $this->input->post() : $this->input->get());        
        $users  = $this->dao->getUsers($params);
        
        if($params){
            if(isset($params["jsonResponse"])){
                echo !$params["jsonResponse"] ? "" : json_encode($users);
                exit;
            }
        }
        
        return $users;
        
    }
    
    public function getMessagesUser($data = NULL){
        
        //In post or get method set $jsonResponse = TRUE for echo in json_format
        $params   = !is_null($data) ? $data : ($this->input->post() ? $this->input->post() : $this->input->get());
        $messages = $this->dao->getMessagesUser($params);
        
        if($params){
            if(isset($params["jsonResponse"])){
                echo "<pre>";
                var_dump($messages);
                echo "</pre>";
                exit;
            }
        }
        
        return $messages;
    }
    
    public function getMessageAttachment($data = NULL){
        
        //In post or get method set $jsonResponse = TRUE for echo in json_format
        $params     = !is_null($data) ? $data : ($this->input->post() ? $this->input->post() : $this->input->get());
        $attachment = $this->dao->getMessageAttachment($params);
        
        if($params){
            if(isset($params["jsonResponse"])){
                echo !$params["jsonResponse"] ? "" : json_encode($attachment);
                exit;
            }
        }
        
        return $attachment;
    }
    
    public function getFileAttach($data = NULL){
        
        //In post or get method set $jsonResponse = TRUE for echo in json_format
        $params = !is_null($data) ? $data : ($this->input->post() ? $this->input->post() : $this->input->get());
        $file   = $this->dao->getFileAttach($params);
        
        if($params){
            if(isset($params["jsonResponse"])){
                echo !$params["jsonResponse"] ? "" : json_encode($file);
                exit;
            }
        }
        
        return $file;
    }
    
    public function replyTo($data = NULL){
        
        //In post or get method set $jsonResponse = TRUE for echo in json_format
        $params = !is_null($data) ? $data : $this->input->post();
        $replyTo = $this->dao->moveMsgFolder($params);
        
        if($params){
            if(isset($params["jsonResponse"])){
                echo !$params["jsonResponse"] ? "" : json_encode($replyTo);
                exit;
            }
        }
        
        return $replyTo;
        
    }
    
    public function getFoldersUser($data = NULL){
        
         //In post or get method set $jsonResponse = TRUE for echo in json_format
        $params  = !is_null($data) ? $data : ($this->input->post() ? $this->input->post() : $this->input->get());
        $folders = $this->dao->getFoldersUser($params);
        
        if($params){
            if(isset($params["jsonResponse"])){
                echo !$params["jsonResponse"] ? "" : json_encode($folders);
                exit;
            }
        }
        
        return $folders;
        
    }
    
    public function moveMsgFolder($data = NULL){
        
        //In post or get method set $jsonResponse = TRUE for echo in json_format
        $params = !is_null($data) ? $data : $this->input->post();
        $msgMove = $this->dao->moveMsgFolder($params);
        
        if($params){
            if(isset($params["jsonResponse"])){
                echo !$params["jsonResponse"] ? "" : json_encode($msgMove);
                exit;
            }
        }
        
        return $msgMove;
    }
    
}