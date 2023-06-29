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
    
}