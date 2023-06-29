<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mainctr
 *
 * @author oscar.f.medellin
 */
class MainCtr extends VX_Controller {
    
    private $libraries = array(
        "css" => array(
            "dependences" => array(
                "assets/vendors/bootstrap/dist/css/bootstrap.min.css",
                "assets/vendors/font-awesome/css/font-awesome.min.css",
                "assets/vendors/switchery/dist/switchery.min.css",
                "assets/build/css/custom.min.css",
                "assets/vendors/nprogress/nprogress.css",
                "assets/vendors/iCheck/skins/flat/green.css",
                "assets/vendors/pdf.js/web/viewer.css",
                "assets/vendors/jquery/src/jquery-ui.min.css",
                array("rel"=>"resource", "type"=>"application/l10n", "href"=>"assets/vendors/pdf.js/web/locale/locale.properties"))
            ),
        "js"  => array(
            "dependences" => array(
                "assets/vendors/jquery/dist/jquery.min.v2.js",
                "assets/js/cur.fixed.js",
                "assets/vendors/jquery/src/jquery-ui.min.js",
                "assets/vendors/bootstrap/dist/js/bootstrap.min.js",
                "assets/build/js/custom.min.js")
            )
    );

    public function __construct() {
        parent::__construct();
        $this->load->library("session");
    }
    
    public function config() {

        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }
        
        $this->libraries["css"]["dependences"][] = "assets/css/main.style.css";
        $this->libraries["css"]["dependences"][] = "assets/css/modal.windows.css";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/routing.page.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/DefaultFn.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/AttachmentObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/FormObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/ModalObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/AjaxFn.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/admin_user/config.js";

        $currentModule         = $this->getCurrentModule();
        $currentModule["data"] = array(
            "userData" => $this->getUserData()
        );
        $currentModule["bodyClass"] = "nav-md";

        $this->setContent($currentModule);
        $dataBuild = $this->getDataBuild();
        
        $dataBuild["css"] = $this->libraries["css"];
        $dataBuild["js"]  = $this->libraries["js"];
        
        $this->load->view("mainPage", $dataBuild);
    }

}
