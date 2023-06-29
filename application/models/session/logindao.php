<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of logindao
 *
 * @author oscar.f.medellin
 */
//session_start();

class LoginDao extends VX_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library("SecuritySession", "securitysession");
        $this->load->library("session");
    }

    private function checkLogin() {

        $select = <<<SELECT
us.P_Id,
us.username AS user, 
us.privilege_id AS levelUser,
us.email AS email,
e.corp_subsidiary_id as WorkCenter,
e.employees_id as employee_id,
e.name AS employee,
p.name AS position,
e.picture AS avatar,
us.first_login AS first_login
SELECT;
        
        $data = array(
            "us.password" => $this->securitysession->getPassword(),
            "us.active"   => 1
        );
        
        if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", 
                $this->securitysession->getUsername())){
            $data["us.username"] = $this->securitysession->getUsername();
        }else{
            $data["SPLIT_STRING(us.username, '@', 1) ="] = $this->securitysession->getUsername();
        }

        $this->db->select($select, FALSE);
        $this->db->join("employees e", "e.employees_id = us.employee_id");
        $this->db->join("positions p", "p.position_id  = e.position_id");
        $login = $this->db->get_where("users us", $data);
        
        return $login->result_array();
    }

    private function getModulesUser($username) {

        $select = <<<EOT
            m.view,
            m.nameView
EOT;

        $data = array(
            "u.username" => $username
        );

        $this->db->select("m.module, m.name");
        $this->db->join("user_groups ug", "ug.idUser = u.P_Id");
        $this->db->join("groups g", "ug.idGroup = g.id");
        $this->db->join("groups_modules gm", "g.id = gm.idgroups");
        $this->db->join("modules m", "m.id = gm.idModules");

        $this->db->group_by("m.name");
        $this->db->order_by("m.orderView", "asc");

        $modules = $this->db->get_where("users u", $data)->result_array();

        foreach ($modules as $key => $value) {
            $this->db->select($select);
            $this->db->join("user_groups ug", "ug.idUser = u.P_Id");
            $this->db->join("groups g", "ug.idGroup = g.id");
            $this->db->join("groups_modules gm", "g.id = gm.idgroups");
            $this->db->join("modules m", "m.id = gm.idModules");
            
            $this->db->order_by("m.orderView", "asc");
            $data["m.module"]    = $value["module"];
            $modules[$key]["views"] = $this->db->get_where("users u", $data)->result_array();
        }

        return $modules;
    }
    
    private function getWorkCenterUser($employeeId){
        
        $whereStore = array(
            "e.employees_id" => $employeeId
        );
        
        $this->db->select("cs.corp_subsidiary_id");
        $this->db->join("rel_employee_subsidiary_view sv", "sv.employee_id = e.employees_id");
        $this->db->join("cat_corps_subsidiary cs", "cs.corp_subsidiary_id = sv.cat_corp_subsidiary_id");

        $workCenter = $this->db->get_where("employees e", $whereStore)->result_array();
        $workArray  = array();
        
        if(count($workCenter) > 0){        
            foreach ($workCenter as $value) {
                $workArray[] = $value["corp_subsidiary_id"];
            }
        }
        
        return $workArray;
    }

    public function login($params) {

        $this->securitysession->setUsername($params["username"]);
        $this->securitysession->setPassword($params["pass"]);

        $logged = $this->checkLogin();

        if (count($logged) > 0) {

            $modules                      = $this->getModulesUser($logged[0]["user"]);
            $logged[0]["AdminWorkCenter"] = $this->getWorkCenterUser($logged[0]["employee_id"]);
                        
            $response = array("success" => TRUE);

            $this->session->set_userdata(array(
                "userInfo" => $logged[0],
                "modules" => $modules
            ));
        } else {
            $response = array(
                "success" => FALSE
            );
        }

        return json_encode($response);
    }

    public function checkIfExist($usr) {
        $result = $this->db->get_where('users', array('email' => $usr));
        if ($result->row_array() != null) {
            return true;
        } else {
            return false;
        }
    }

    public function updatePass($params){
        
        $this->securitysession->setUsername($params["username"]);
        $this->securitysession->setPassword($params["password"]);
        
        $login = $this->checkLogin();
//        var_dump($login);
//        echo $this->db->last_query();
//        exit;
        if(count($login) > 0){
            
            $this->securitysession->setPassword($params["new_pass"]);
            
            $this->edit("users", array(
                "P_Id" => $login[0]["P_Id"]
            ),array(
                "password"    => $this->securitysession->getPassword(),
                "first_login" => 0
            ));
            
            return array("success" => TRUE);            
        }
        
        return array("error" => TRUE);
        
    }
}
