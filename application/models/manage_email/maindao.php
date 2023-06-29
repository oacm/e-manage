<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of manageemaildao
 *
 * @author oscar.f.medellin
 */
class MainDao extends VX_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library("session");
    }
    
public function getEmailToSend($params){
        
        $folioDoc  = $params["control_folio"];
        $emailData = array();
        unset($params["control_folio"]);
        
        $this->db->select("u.email");
        $this->db->where("CONCAT(mat.code, '-', mat.num_document, '/', mat.year_document) = '$folioDoc'");
        $this->db->join("areas a", "a.area_id = mat.area_id");
        $this->db->join("positions p", "p.area_id = a.area_id");
        $this->db->join("employees e", "e.position_id = p.position_id");
        $this->db->join("users u", "u.employee_id = e.employees_id");
        $this->db->join("user_groups ug", "ug.idUser = u.P_Id");
        $this->db->join("groups g", "g.id = ug.idGroup");
        $this->db->join("groups_modules gm", "gm.idGroups = g.id");
        $this->db->join("modules m", "m.id = gm.idModules");
        $this->db->group_by("e.employees_id");
        $emailsUsers = $this->db->get_where("mngmail_assing_to mat", $params)->result_array();
        
        foreach ($emailsUsers as $value) {
            $emailData[] = $value["email"];
        }
        
        return $emailData;
        
    } 
    
}