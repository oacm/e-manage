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
                "assets/vendors/pdf.js/build/pdf.js",
                "assets/vendors/pdf.js/web/viewer.js",
                "assets/vendors/jquery/src/jquery-ui.min.js",
                "assets/vendors/bootstrap/dist/js/bootstrap.min.js",
                "assets/build/js/custom.min.js")
            )
    );

    public function __construct() {
        parent::__construct();
        $this->load->library("session");

        $this->load->model("manage_email/maindao", "dao");
    }
    
    private function loadDataTables(){
        
        $js  = array(            
            "assets/vendors/datatables.net/js/jquery.dataTables.js",
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

    public function inMail() {

        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }
        
        $this->loadDataTables();
        
        $this->libraries["css"]["dependences"][] = "assets/vendors/select2/dist/css/select2.min.css";
        $this->libraries["css"]["dependences"][] = "assets/vendors/bootstrap-daterangepicker/daterangepicker.css";
        $this->libraries["css"]["dependences"][] = "assets/css/main.style.css";
        $this->libraries["css"]["dependences"][] = "assets/css/modal.windows.css";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/routing.page.js";
        $this->libraries["js"]["dependences"][]  = "assets/vendors/select2/dist/js/select2.full.js";
        $this->libraries["js"]["dependences"][]  = "assets/vendors/moment/min/moment.min.js";
        $this->libraries["js"]["dependences"][]  = "assets/vendors/switchery/dist/switchery.min.js";
        $this->libraries["js"]["dependences"][]  = "assets/vendors/bootstrap-daterangepicker/daterangepicker.js";
        $this->libraries["js"]["dependences"][]  = "assets/vendors/jQuery.Select.Year/lib/year-select.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/DefaultFn.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/AttachmentObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/AjaxFn.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/PanelObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/ButtonObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/FormObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/ModalObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/DataTableObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/manage_email/ajax/inmail.ajax.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/manage_email/forms/inmail.forms.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/manage_email/modals/inmail.modals.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/manage_email/tables/inmail.tables.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/manage_email/panels/inmail.panels.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/manage_email/inmail.main.js";

        $currentModule                           = $this->getCurrentModule();
        $currentModule["data"]                   = array(
            "vMenu" => array(
                "render" => TRUE,
                "data" => array(
                    "buttons" => array(
                        array(
                            "name"   => "docStart",
                            "label"  => "Entrada", 
                            "icon"   => "fa fa-envelope",
                            "active" => TRUE),
                        array(
                            "name"   => "history",
                            "label"  => "Historial", 
                            "icon"   => "fa fa-history",
                            "active" => FALSE)
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
    
    public function pendingdoc(){
        
        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }

        $this->loadDataTables();
        
        $this->libraries["css"]["dependences"][] = "assets/vendors/select2/dist/css/select2.min.css";
        $this->libraries["css"]["dependences"][] = "assets/css/main.style.css";
        $this->libraries["css"]["dependences"][] = "assets/css/modal.windows.css";
        $this->libraries["css"]["dependences"][] = "assets/css/panel.thumb.style.css";
        $this->libraries["css"]["dependences"][] = "assets/vendors/bootstrap-daterangepicker/daterangepicker.css";
        $this->libraries["css"]["dependences"][] = "assets/css/main.style.css";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/routing.page.js";
        $this->libraries["js"]["dependences"][]  = "assets/vendors/iCheck/icheck.min.js";
        $this->libraries["js"]["dependences"][]  = "assets/vendors/moment/min/moment.min.js";
        $this->libraries["js"]["dependences"][]  = "assets/vendors/switchery/dist/switchery.min.js";
        $this->libraries["js"]["dependences"][]  = "assets/vendors/bootstrap-daterangepicker/daterangepicker.js";
        $this->libraries["js"]["dependences"][]  = "assets/vendors/jQuery.Select.Year/lib/year-select.js";
        $this->libraries["js"]["dependences"][]  = "assets/vendors/select2/dist/js/select2.full.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/DefaultFn.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/AttachmentObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/AjaxFn.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/PanelObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/ButtonObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/FormObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/ModalObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/DataTableObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/manage_email/ajax/pendingdoc.ajax.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/manage_email/forms/pendingdoc.forms.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/manage_email/modals/inmail.modals.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/manage_email/tables/pendingdoc.tables.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/manage_email/panels/pendingdoc.panels.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/manage_email/pendingdoc.main.js"; 

        $currentModule                           = $this->getCurrentModule();
        $currentModule["data"]                   = array(
            "vMenu" => array(
                "render" => TRUE,
                "data" => array(
                    "buttons" => array(
                        array(
                            "name"   => "inbox",
                            "label"  => "Entrada", 
                            "icon"   => "fa fa-envelope",
                            "active" => TRUE),
                        array(
                            "name"   => "check",
                            "label"  => "Revisar", 
                            "icon"   => "glyphicon glyphicon-eye-open",
                            "active" => FALSE),
                        array(
                            "name"   => "history",
                            "label"  => "Historial", 
                            "icon"   => "fa fa-history",
                            "active" => FALSE)
                    )
                )
            ),
            "userData" => $this->getUserData()
        );
        $currentModule["bodyClass"] = "nav-md";

        $this->setContent($currentModule);

        $dataBuild        = $this->getDataBuild();

        $dataBuild["css"] = $this->libraries["css"];
        $dataBuild["js"]  = $this->libraries["js"];
        
        $this->load->view("mainPage", $dataBuild);
    }

    public function outMail(){
        
        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }

        $this->loadDataTables();
        
        $this->libraries["css"]["dependences"][] = "assets/vendors/select2/dist/css/select2.min.css";
        $this->libraries["css"]["dependences"][] = "assets/css/main.style.css";
        $this->libraries["css"]["dependences"][] = "assets/css/modal.windows.css";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/routing.page.js";
        $this->libraries["js"]["dependences"][]  = "assets/vendors/select2/dist/js/select2.full.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/DefaultFn.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/AttachmentObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/AjaxFn.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/PanelObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/ButtonObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/FormObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/ModalObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/DataTableObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/manage_email/ajax/inmail.ajax.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/manage_email/ajax/outmail.ajax.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/manage_email/forms/outmail.forms.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/manage_email/modals/inmail.modals.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/manage_email/tables/outmail.tables.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/manage_email/panels/outmail.panels.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/manage_email/outmail.main.js"; 

        $currentModule                           = $this->getCurrentModule();
        $currentModule["data"]                   = array(
            "vMenu" => array(
                "render" => FALSE,
            ),
            "userData" => $this->getUserData()
        );
        $currentModule["bodyClass"] = "nav-md";

        $this->setContent($currentModule);

        $dataBuild        = $this->getDataBuild();

        $dataBuild["css"] = $this->libraries["css"];
        $dataBuild["js"]  = $this->libraries["js"];
        
        $this->load->view("mainPage", $dataBuild);
    }

    public function checkmail(){
        
        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }

        $this->loadDataTables();
        
        $this->libraries["css"]["dependences"][] = "assets/vendors/select2/dist/css/select2.min.css";
        $this->libraries["css"]["dependences"][] = "assets/css/main.style.css";
        $this->libraries["css"]["dependences"][] = "assets/css/modal.windows.css";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/routing.page.js";
        $this->libraries["js"]["dependences"][]  = "assets/vendors/select2/dist/js/select2.full.js";
        $this->libraries["js"]["dependences"][]  = "assets/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/DefaultFn.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/AttachmentObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/AjaxFn.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/PanelObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/ButtonObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/FormObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/ModalObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/Core/DataTableObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/manage_email/ajax/pendingdoc.ajax.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/manage_email/ajax/checkmail.ajax.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/manage_email/forms/checkmail.forms.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/manage_email/modals/inmail.modals.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/manage_email/tables/checkmail.tables.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/manage_email/panels/checkmail.panels.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/manage_email/checkmail.main.js";

        $currentModule                           = $this->getCurrentModule();
        $currentModule["data"]                   = array(
            "vMenu"    => array(
                "render" => FALSE
            ),
            "userData" => $this->getUserData()
        );
        $currentModule["bodyClass"] = "nav-md";

        $this->setContent($currentModule);

        $dataBuild        = $this->getDataBuild();

        $dataBuild["css"] = $this->libraries["css"];
        $dataBuild["js"]  = $this->libraries["js"];
        
        $this->load->view("mainPage", $dataBuild);
    }
    
    public function reports(){
        
        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }

        $this->loadDataTables();
        
        $this->libraries["css"]["dependences"][] = "assets/css/main.style.css";
        $this->libraries["css"]["dependences"][] = "assets/css/modal.windows.css";
        $this->libraries["js"]["dependences"][]  = "assets/js/routing.page.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/main_functions/DefaultFn.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/main_functions/AttachmentObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/main_functions/FormObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/main_functions/ModalObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/main_functions/DataTableObj.js";

        $currentModule                           = $this->getCurrentModule();
        $currentModule["data"]                   = array(
            "vMenu"    => array(
                "render" => FALSE
            ),
            "userData" => $this->getUserData()
        );
        $currentModule["bodyClass"] = "nav-md";

        $this->setContent($currentModule);

        $dataBuild        = $this->getDataBuild();

        $dataBuild["css"] = $this->libraries["css"];
        $dataBuild["js"]  = $this->libraries["js"];
        
        $this->load->view("mainPage", $dataBuild);
        
    }
    
    public function direction(){
        
        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }

        $this->loadDataTables();
        
        $this->libraries["css"]["dependences"][] = "assets/vendors/select2/dist/css/select2.min.css";
        $this->libraries["css"]["dependences"][] = "assets/css/main.style.css";
        $this->libraries["css"]["dependences"][] = "assets/css/modal.windows.css";
        $this->libraries["js"]["dependences"][]  = "assets/js/routing.page.js";
        $this->libraries["js"]["dependences"][]  = "assets/vendors/select2/dist/js/select2.full.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/main_functions/DefaultFn.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/main_functions/AttachmentObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/main_functions/FormObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/main_functions/ModalObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/main_functions/DataTableObj.js";
        $this->libraries["js"]["dependences"][]  = "assets/js/modules/manage_email/direction.main.js";

        $currentModule                           = $this->getCurrentModule();
        $currentModule["data"]                   = array(
            "vMenu"    => array(
                "render" => FALSE,
            ),
            "userData" => $this->getUserData()
        );
        $currentModule["bodyClass"] = "nav-md";

        $this->setContent($currentModule);

        $dataBuild        = $this->getDataBuild();

        $dataBuild["css"] = $this->libraries["css"];
        $dataBuild["js"]  = $this->libraries["js"];
        
        $this->load->view("mainPage", $dataBuild);
    }

}
