<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SystemDao
 *
 * @author oscar.f.medellin
 */
class SystemDao extends VX_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getAreaEmployee($employeeId) {
        return parent::getAreaEmployee($employeeId);
    }
    
    public function searchCompleteEmployeeData($params){
        return parent::searchCompleteEmployeeData($params);
    }
    /* Envio de Mails */
    public function sendReminderAdmin($params) {
        
        $reminderData = $this->db->get_where("reminder_admin", $params)->result_array();
        
        return $reminderData;
        
    }
    
    public function sendReminderMakerAnswer($params){
        
        $reminderData = $this->db->get_where("reminder_maker_answer", $params)->result_array();
        
        return $reminderData;
    }

    public function sendMailComment($params) {
        echo json_encode($params);
        exit();
    }
    /* Envio de Mails */
    /* Procesos de O365 */
    public function getDocumentsDefeated($params){
        
        $this->db->where("priority_id > 0 AND priority_id < 4 AND status_id != 2");
        $docDefeated = $this->db->get_where("document_complete_data", $params)->result_array();
        
        return $docDefeated;
    }
    
    public function setDefeatedDoc($folioDoc){
        
        $this->edit("mngmail_documents", $folioDoc, array("defeated" => 1));
    }
    
    public function checkTokensO365(){
        
        $currentDate = $this->getCurrentDate();        
        $updateToken = $this->db->query("UPDATE o365_token SET active = 0 WHERE '$currentDate' >= date_add(date_creation, interval expires_in second) and active = 1");
        
        if(!$updateToken){
            echo json_encode(array(
                "error" => "Error actualizando token"
            ));
            return;
        }
        
        var_dump($updateToken);
        
    }
    /* Procesos de O365 */
    public function getAreas($params){
        
        $this->db->select("area_id as id, document_area_code as text", FALSE);
        $this->db->like("document_area_code", $params["term"]);
        unset($params["term"]);
        
        if(isset($params["employee_id"])){
            $this->db->where("employees_id = $params[employee_id]");
            unset($params["employee_id"]);
        }else{
            $this->db->group_by("area_id");
        }
        
        $this->db->order_by("document_area_code", "asc");
        $contacts = $this->db->get_where("list_complete_areas_code", $params);
//        echo $this->db->last_query();
        return $contacts->result_array();
        
    }
    
    public function getNumberAvailable($params){
        
        $numbers = NULL;
        $result  = array();
        
        if(intval($params["term"]) > 0){
            $this->db->where("num_doc_out", $params["term"]);
            unset($params["term"]);
            $numbers = $this->db->get_where("mngmail_documents", $params)->result_array();
            
            if(count($numbers) > 0){return array("error" => TRUE, "result" => array_pop($numbers));}else{return array("success" => TRUE);}
        }
        
        unset($params["term"]);
        
        $this->db->select("CAST(num_doc_out AS UNSIGNED) as not_available", FALSE);
        $this->db->order_by("not_available", "asc");
        
        $numbers   = array_column($this->db->get_where("mngmail_documents", $params)->result_array(), "not_available");
        $maxNumber = count($numbers) == 0 ? 30 : intval($numbers[count($numbers) - 1]) + 30;
        
        for($i = 1 ; $i <= $maxNumber ; $i++){
            if(!in_array($i, $numbers)){
                $number = $i < 10 ? "0$i" : $i;
                array_push($result, array("id" => $number, "text" => $number ));
            }
        }
        
        return $result;
        
    }
    
}
