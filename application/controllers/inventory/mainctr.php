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
                "assets/build/css/custom.min.css",
                "assets/vendors/nprogress/nprogress.css",
                "assets/vendors/iCheck/skins/flat/green.css",
                "assets/vendors/jquery/src/jquery-ui.min.css")
            ),
        "js"  => array(
            "dependences" => array(
                "assets/vendors/jquery/dist/jquery.min.js",
                "assets/js/cur.fixed.js",
                "assets/vendors/jquery/src/jquery-ui.min.js",
                "assets/vendors/bootstrap/dist/js/bootstrap.min.js",
                "assets/build/js/custom.min.js")
            )
    );

    public function __construct() {
        parent::__construct();
        $this->load->library("session");

        $this->load->model("inventory/maindao", "dao");
    }
    
    private function loadDataTables(){
        
        $js  = array(            
            "assets/vendors/datatables.net/js/jquery.dataTables.min.js",
            "assets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js",
            "assets/vendors/datatables.net-buttons/js/dataTables.buttons.min.js",
            "assets/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js",
            "assets/vendors/datatables.net-buttons/js/buttons.flash.min.js",
            "assets/vendors/datatables.net-buttons/js/buttons.html5.min.js",
            "assets/vendors/datatables.net-buttons/js/buttons.print.min.js",
            "assets/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js",
            "assets/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js",
            "assets/vendors/datatables.net-responsive/js/dataTables.responsive.min.js",
            "assets/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js",
            "assets/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"
        );
        
        $css = array(
            "assets/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css",
            "assets/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css",
            "assets/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css",
            "assets/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css",
            "assets/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css"
        );
        
        $this->libraries["js"]["dependences"]  = array_merge($this->libraries["js"]["dependences"], $js);
        $this->libraries["css"]["dependences"] = array_merge($this->libraries["css"]["dependences"], $css);
        
        
    }

    public function record() {

        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }
        
//        $this->loadDataTables();
        
//        $this->libraries["css"]["dependences"][] = "assets/vendors/select2/dist/css/select2.min.css";
//        $this->libraries["css"]["dependences"][] = "assets/vendors/bootstrap-daterangepicker/daterangepicker.css";
        $this->libraries["css"]["dependences"][] = "assets/css/main.style.css";
        $this->libraries["css"]["dependences"][] = "assets/css/modal.windows.css";
        $this->libraries["js"]["dependences"][]  = "assets/js/routing.page.js";
//        $this->libraries["js"]["dependences"][]  = "assets/vendors/select2/dist/js/select2.full.js";
//        $this->libraries["js"]["dependences"][]  = "assets/vendors/moment/min/moment.min.js";
//        $this->libraries["js"]["dependences"][]  = "assets/vendors/bootstrap-daterangepicker/daterangepicker.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/main_functions/DefaultFn.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/main_functions/AttachmentObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/main_functions/FormObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/main_functions/ModalObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/main_functions/DataTableObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/inventory/record.main.js";

        $currentModule                           = $this->getCurrentModule();
        $currentModule["data"]                   = array(
            "vMenu" => array(
                "render" => TRUE,
                "data" => array(
                    "buttons" => array(
                        array(
                            "label"  => "Inventario", 
                            "icon"   => "fa fa-envelope",
                            "active" => TRUE,
                            "panel"  => "brands"),
                        array(
                            "label"  => "Asignaciones", 
                            "icon"   => "fa fa-history",
                            "active" => FALSE,
                            "panel"  => "models")
                    )
                )
            ),
            "userData" => $this->getUserData()
        );
        $currentModule["bodyClass"] = "nav-md";

        $this->setContent($currentModule);

        $dataBuild = $this->getDataBuild();

        $dataBuild["css"] = $this->libraries["css"];
        $dataBuild["js"]  = $this->libraries["js"];
        
        $this->load->view("mainPage", $dataBuild);
    }
    
    public function assignment(){}

}
