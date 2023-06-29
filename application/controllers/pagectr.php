<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pageCtr
 *
 * @author oscar.f.medellin
 */
//session_start();

class PageCtr extends VX_Controller {
    
    private $defaultDependences = array(
        "js"  => array(
            "dependences" => array(
                "assets/vendors/jquery/dist/jquery.min.v2.js", 
                "assets/vendors/bootstrap/dist/js/bootstrap.min.js", 
                "assets/vendors/fastclick/lib/fastclick.js",
                "assets/vendors/nprogress/nprogress.js",
                "assets/vendors/validator/validator.js",
                "assets/build/js/custom.min.js", 
                "assets/js/Core/routing.page.js")),
        "css" => array(
            "dependences" => array(
                "assets/vendors/bootstrap/dist/css/bootstrap.min.css", 
                "assets/vendors/font-awesome/css/font-awesome.min.css", 
                "assets/build/css/custom.min.css", 
                "assets/css/modal.windows.css", 
                "assets/css/main.style.css"))
    );
    
    public function __construct() {
        
        parent::__construct();
        $this->load->library("session");
    }
    
    private function loadDefault(&$dataBuild){
        $dataBuild["css"] = $this->defaultDependences["css"];
        $dataBuild["js"]  = $this->defaultDependences["js"];
    }

    public function index() {

        if (!$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }
        
        $this->setContent(array(
            "module" => "",
            "view"   => "welcome",
            "data"   => array(
                "vMenu" => array(
                    "render" => FALSE
                ),
                "userData" => $this->getUserData()
            ),
            "bodyClass" => "nav-md"
        ));

        $dataBuild = $this->getDataBuild();
        $this->loadDefault($dataBuild);
        
        $dataBuild["js"]["dependences"][] = "assets/js/Core/DefaultFn.js";
        $dataBuild["js"]["dependences"][] = "assets/js/Core/AjaxFn.js";
        $dataBuild["js"]["dependences"][] = "assets/js/Core/ButtonObj.js";
        $dataBuild["js"]["dependences"][] = "assets/js/Core/FormObj.js";
        $dataBuild["js"]["dependences"][] = "assets/js/Core/ModalObj.js";
        $dataBuild["js"]["dependences"][] = "assets/js/modules/login/ajax/index.ajax.js";
        $dataBuild["js"]["dependences"][] = "assets/js/modules/login/form/index.form.js";
        $dataBuild["js"]["dependences"][] = "assets/js/modules/manage_email/modals/inmail.modals.js";
        $dataBuild["js"]["dependences"][] = "assets/js/modules/login/index.main.js";
        
        $this->load->view("mainPage.php", $dataBuild);
    }

    public function login() {
        
        if ($this->session->userdata("userInfo")) {
            redirect(base_url());
        }

        $this->setContent(array(
            "module"    => "login",
            "view"      => "index",
            "data"      => array(),
            "bodyClass" => "login"
        ));

        $dataBuild = $this->getDataBuild();

        $dataBuild["css"] = array(
                "dependences" => array(
                    "assets/vendors/bootstrap/dist/css/bootstrap.min.css",
                    "assets/vendors/font-awesome/css/font-awesome.min.css",
                    "assets/vendors/nprogress/nprogress.css",
                    "assets/vendors/animate.css/animate.min.css",
                    "assets/build/css/custom.min.css",
                    "assets/css/main.style.css",
                    "assets/css/modal.windows.css"
                ));
        $dataBuild["js"] = array(
                "dependences" => array(
                    "assets/vendors/jquery/dist/jquery.min.js",
                    "assets/js/Core/routing.page.js",
                    "assets/js/Core/DefaultFn.js",
                    "assets/js/Core/FormObj.js",
                    "assets/js/Core/ModalObj.js",
                    "assets/js/Core/AjaxFn.js",
                    "assets/js/modules/login/login.js"
                )
            );

        $this->load->view("mainPage.php", $dataBuild);
    }

}
