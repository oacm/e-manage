<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

use PhpOffice\PhpWord\TemplateProcessor;


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
class MainCtr extends VX_Controller
{

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
                array("rel" => "resource", "type" => "application/l10n", "href" => "assets/vendors/pdf.js/web/locale/locale.properties")
            )
        ),
        "js" => array(
            "dependences" => array(
                "assets/vendors/jquery/dist/jquery.min.js",
                "assets/js/cur.fixed.js",
                "assets/vendors/pdf.js/build/pdf.js",
                "assets/vendors/pdf.js/web/viewer.js",
                "assets/vendors/jquery/src/jquery-ui.min.js",
                "assets/vendors/bootstrap/dist/js/bootstrap.min.js",
                "assets/build/js/custom.min.js"
            )
        )
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->library("session");

        $this->load->model("manage_email/maindao", "dao");

        $this->load->model("deal/mainctrdao", "mainctrdao");
        $this->load->library("Logging", "logging");

    }

    private function loadDataTables()
    {

        $js = array(
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

        $this->libraries["js"]["dependences"] = array_merge($this->libraries["js"]["dependences"], $js);
        $this->libraries["css"]["dependences"] = array_merge($this->libraries["css"]["dependences"], $css);


    }




    //////
    public function eproduced()
    {

        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }

        $this->loadDataTables();




        $this->libraries["css"]["dependences"][] = "assets/vendors/select2/dist/css/select2.min.css";
        $this->libraries["css"]["dependences"][] = "assets/vendors/bootstrap-daterangepicker/daterangepicker.css";
        $this->libraries["css"]["dependences"][] = "assets/css/main.style.css";
        $this->libraries["css"]["dependences"][] = "assets/css/modal.windows.css";
        $this->libraries["css"]["dependences"][] = "assets/vendors/distexcel/handsontable.full.min.css";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/routing.page.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/select2/dist/js/select2.full.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/moment/min/moment.min.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/switchery/dist/switchery.min.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/bootstrap-daterangepicker/daterangepicker.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/jQuery.Select.Year/lib/year-select.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/DefaultFn.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/AttachmentObj.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/FormObj.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/ModalObj.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/DataTableObj.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/distexcel/handsontable.full.min.js";
        $this->libraries["js"]["dependences"][] = "assets/js/modules/energy_management/fechamuestra.js";
        $this->libraries["js"]["dependences"][] = "assets/js/modules/energy_management/excelvalores.js";
        $this->libraries["js"]["dependences"][] = "assets/js/modules/energy_management/eproduced.mail.js";



        $userInfoData = $this->mainctrdao->getInfoWorkCenter($this->getUserData());
        $stationInfoData = $this->mainctrdao->getInfoStation($this->getUserData());



        $currentModule = $this->getCurrentModule();
        $currentModule["data"] = array(
            "vMenu" => array(
                "render" => TRUE,
                "data" => array(
                    "buttons" => array(


                    )
                )
            ),
            "userData" => $this->getUserData(),
            "userInfoData" => $userInfoData,
            "userStationData" => $stationInfoData

        );
        $currentModule["bodyClass"] = "nav-md";

        $this->setContent($currentModule);

        $dataBuild = $this->getDataBuild();

        $dataBuild["css"] = $this->libraries["css"];
        $dataBuild["js"] = $this->libraries["js"];

        $this->load->view("mainPage", $dataBuild);
    }
    ////// alejandro castro
    public function deals()
    {

        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }

        $this->loadDataTables();




        $this->libraries["css"]["dependences"][] = "assets/vendors/select2/dist/css/select2.min.css";
        $this->libraries["css"]["dependences"][] = "assets/vendors/bootstrap-daterangepicker/daterangepicker.css";
        $this->libraries["css"]["dependences"][] = "assets/css/main.style.css";
        $this->libraries["css"]["dependences"][] = "assets/css/modal.windows.css";
        $this->libraries["css"]["dependences"][] = "assets/vendors/distexcel/handsontable.full.min.css";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/routing.page.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/select2/dist/js/select2.full.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/moment/min/moment.min.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/switchery/dist/switchery.min.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/bootstrap-daterangepicker/daterangepicker.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/jQuery.Select.Year/lib/year-select.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/DefaultFn.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/AttachmentObj.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/FormObj.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/ModalObj.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/DataTableObj.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/distexcel/handsontable.full.min.js";
        $this->libraries["js"]["dependences"][] = "assets/js/modules/energy_management/fechamuestra.js";


        $this->libraries["js"]["dependences"][] = "assets/js/modules/ofertas/deals.js";

        $clientsSelect = $this->mainctrdao->getClientsSelect();
       
 
        if ($params = $this->input->post()) {
            $deals = $this->mainctrdao->getDealsfilter($params);
        } else {
            $deals = $this->mainctrdao->getDeals();
        }

     
        $currentModule = $this->getCurrentModule();
        $currentModule["data"] = array(
            "vMenu" => array(
                "render" => TRUE,
                "data" => array(
                    "buttons" => array(


                    )
                )
            ),
            "userData" => $this->getUserData(),
            "clientsSelects" => $clientsSelect,
            "deals" => $deals
           


        );
        $currentModule["bodyClass"] = "nav-md";

        $this->setContent($currentModule);

        $dataBuild = $this->getDataBuild();

        $dataBuild["css"] = $this->libraries["css"];
        $dataBuild["js"] = $this->libraries["js"];

        $this->load->view("mainPage", $dataBuild);
    }



    ////// alejandro castro
    public function clients()
    {

        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }

        $this->libraries["css"]["dependences"][] = "assets/vendors/select2/dist/css/select2.min.css";
        $this->libraries["css"]["dependences"][] = "assets/vendors/bootstrap-daterangepicker/daterangepicker.css";
        $this->libraries["css"]["dependences"][] = "assets/css/main.style.css";
        $this->libraries["css"]["dependences"][] = "assets/css/modal.windows.css";
        $this->libraries["css"]["dependences"][] = "assets/vendors/distexcel/handsontable.full.min.css";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/routing.page.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/select2/dist/js/select2.full.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/moment/min/moment.min.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/switchery/dist/switchery.min.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/bootstrap-daterangepicker/daterangepicker.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/jQuery.Select.Year/lib/year-select.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/DefaultFn.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/AttachmentObj.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/FormObj.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/ModalObj.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/DataTableObj.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/distexcel/handsontable.full.min.js";
        $this->libraries["js"]["dependences"][] = "assets/js/modules/energy_management/fechamuestra.js";

        $this->libraries["js"]["dependences"][] = "assets/js/modules/ofertas/clientes.js";


        $clients = $this->mainctrdao->getClients();
        $clientsSelect = $this->mainctrdao->getClientsSelect();
       
        if ($params = $this->input->post()) {
            $clientesRPU = $this->mainctrdao->getClientesRPUfilter($params);
        } else {
            $clientesRPU = $this->mainctrdao->getClientesRPU();
        }
        
        $currentModule = $this->getCurrentModule();
        $currentModule["data"] = array(
            "vMenu" => array(
                "render" => TRUE,
                "data" => array(
                    "buttons" => array(


                    )
                )
            ),
            "userData" => $this->getUserData(),
            "clients" => $clients,
            "clientsSelects" => $clientsSelect,
            "clientesRPU" => $clientesRPU

        );
        $currentModule["bodyClass"] = "nav-md";

        $this->setContent($currentModule);

        $dataBuild = $this->getDataBuild();

        $dataBuild["css"] = $this->libraries["css"];
        $dataBuild["js"] = $this->libraries["js"];

        $this->load->view("mainPage", $dataBuild);
    }


    //// alejandro castro
    public function saveClient()
    {

        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }

        $params = $this->input->post();
        $nombre = $params["nombre"];
        $razonsocial = $params["razonsocial"];
        $calificado = $params["calificado"];
        $newInfo = $this->mainctrdao->saveClient($this->getUserData(), $nombre, $razonsocial, $calificado);
        $res["status"] = $newInfo;


        echo json_encode($res);

    }

    public function saveRPU()
    {
        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }
        $params = $this->input->post();
        $newInfo = $this->mainctrdao->saveRPU($this->getUserData(), $params);
        $res["status"] = $newInfo;
        echo json_encode($res);
    }

    public function removeRPU()
    {
        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }
        $params = $this->input->post();
        $newInfo = $this->mainctrdao->removeRPU($this->getUserData(), $params);
        $res["status"] = $newInfo;
        echo json_encode($res);

    }


    public function saveDeal()
    {
        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }
        $params = $this->input->post();
        $newInfo = $this->mainctrdao->saveDeal($this->getUserData(), $params);
        $res["status"] = $newInfo;
        echo json_encode($res);
    }


    public function removeDeal()
    {
        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }
        $params = $this->input->post();
        $newInfo = $this->mainctrdao->removeDeal($this->getUserData(), $params);
        $res["status"] = $newInfo;
        echo json_encode($res);
    }
   
    public function saveData()
{
    //$preciosFile = $_FILES['preciosFile'];
      $tarifasFile = $_FILES['tarifasFile'];
    // $horariosFile = $_FILES['horariosFile'];
    // $generadorFile = $_FILES['generadorFile']; 
    $ofertaId = $_POST['ofertaId'];
   

   // $this->mainctrdao->savePrecios($preciosFile);
      $this->mainctrdao->saveTarifas($tarifasFile);
    // $this->mainctrdao->saveHorarios($horariosFile); 
    // $this->mainctrdao->saveGenerador($generadorFile, $ofertaId);
    // $this->mainctrdao->saveSeguimiento($ofertaId);
    
    
    
    return  $res["status"] = "success";
    echo json_encode($res);
}


public function saveContrato()
{
    $ofertaId = $_POST['ofertaId'];
    
    $dir = $_SERVER['DOCUMENT_ROOT'] . '/e-manage/Contrato';
    $carpeta_oferta = $dir . '/' . $ofertaId;

    if (!file_exists($carpeta_oferta)) {
        mkdir($carpeta_oferta, 0777, true);
    }

    if (isset($_FILES['contrato'])) {
        $archivos = $_FILES['contrato'];

        $num_archivos = count($archivos['name']);
        $upload_success = 0;

        for ($i = 0; $i < $num_archivos; $i++) {
            if ($archivos['type'][$i] === 'application/pdf') {
                $nombre_archivo = $archivos['name'][$i];
                
            
                $fecha_actual = date("Y-m-d");
                $fecha_binaria = decbin(strtotime($fecha_actual));

         
                $nombre_archivo = str_replace('.pdf', '', $nombre_archivo);
                $nombre_archivo = $nombre_archivo . '_' . $fecha_binaria . '.pdf';
                
                $ruta_destino = $carpeta_oferta . '/' . $nombre_archivo;
                
                $data = array(
                    'name' => $nombre_archivo,
                    'id_oferta' => $ofertaId,
                    'fecha' => $fecha_actual
                );
                $this->db->insert('of_files', $data);
                
                if (move_uploaded_file($archivos['tmp_name'][$i], $ruta_destino)) {
                    $upload_success++;
                }
            }
        }

        if ($upload_success > 0) {
            $response = array(
                'status' => 'success',
                'message' => 'Se guardaron los archivos correctamente.'
            );
            echo json_encode($response);
            return;
        }
    }

    $response = array(
        'status' => 'error',
        'message' => 'Ocurrió un error al guardar los archivos o no se han subido archivos válidos.'
    );
    echo json_encode($response);
}

public function generarWord() {    
    if(isset($_POST['word'])) {
        $params = $this->input->post();
        $result = $this->mainctrdao->generarDatosEmpresa($params);
    
        $datos = $result->result_array();

        $createdDate = $datos[0]['createdDate'];
        $nombre = $datos[0]['nombre'];
        $razon = $datos[0]['razonSocial'];
        $templatePath = $_SERVER['DOCUMENT_ROOT'] . '/e-manage/Contrato/oferta.docx';
    
    
        $document = new TemplateProcessor($templatePath);

        $document->setValue('nombre', $nombre);
        $document->setValue('fOferta', strftime('%d de %B de %Y', strtotime($createdDate)));
        $document->setValue('razon', $razon);
    
        $tempFilePath = tempnam(sys_get_temp_dir(), 'word');
        $document->saveAs($tempFilePath);
    
    
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="oferta.docx"');
        header('Content-Length: ' . filesize($tempFilePath));
        readfile($tempFilePath);
    
        unlink($tempFilePath);
    } else {
      
        header('HTTP/1.1 400 Bad Request');
        echo "Solicitud inválida";
    }
}

public function downloadContrado() {   
        $params = $this->input->post();
        $ofertaId = $params["ofertaId"];  
        $fileName = $params["name"]; 
      
        $templatePath = $_SERVER['DOCUMENT_ROOT'] . '/e-manage/Contrato/'. $ofertaId .'/'.$fileName;
         
         $tempFilePath = tempnam(sys_get_temp_dir(), 'pdf');
         copy($templatePath, $tempFilePath); 
        
         header('Content-Description: File Transfer');
         header('Content-Type: application/octet-stream');
         header('Content-Disposition: attachment; filename="' . $fileName . '"'); 
         header('Content-Length: ' . filesize($tempFilePath));
         readfile($tempFilePath);
     
         unlink($tempFilePath);      
}


public function subirtarifa()
{
    $tarifasFile = $_FILES['tarifasFile'];   
    $this->mainctrdao->saveTarifas($tarifasFile);
 
    return  $res["status"] = "success";
    echo json_encode($res);
}

public function validarSeguimiento()
{
    $params = $this->input->post();
    $newInfo = $this->mainctrdao->validarSeguimiento($params);
 
    $res["status"] = $newInfo;
    echo json_encode($res);
}

public function validarSeguimiento2()
{
    $params = $this->input->post();
    $newInfo = $this->mainctrdao->validarSeguimiento2($params);
    $res["status"] = $newInfo;
    echo json_encode($res);
}

public function validarSeguimiento3()
{
    $params = $this->input->post();
    $newInfo = $this->mainctrdao->validarSeguimiento3($params);
    $res["status"] = $newInfo;
    echo json_encode($res);
}

public function validarSeguimiento4()
{
    $params = $this->input->post();
    $newInfo = $this->mainctrdao->validarSeguimiento4($params);
    $res["status"] = $newInfo;
    echo json_encode($res);
}

public function validarSeguimiento5()
{
    $params = $this->input->post();
    $newInfo = $this->mainctrdao->validarSeguimiento5($params);
    $res["status"] = $newInfo;
    echo json_encode($res);
}

public function paso1()
{
    $params = $this->input->post();
    $newInfo = $this->mainctrdao->paso1($params);
    $res["status"] = $newInfo;
    echo json_encode($res);
}

public function paso2()
{
    $params = $this->input->post();
    $newInfo = $this->mainctrdao->paso2($params);
    $res["status"] = $newInfo;
    echo json_encode($res);
}

public function paso3()
{
    $params = $this->input->post();
    $newInfo = $this->mainctrdao->paso3($params);
    $res["status"] = $newInfo;
    echo json_encode($res);
}

public function paso4()
{
    $params = $this->input->post();
    $newInfo = $this->mainctrdao->paso4($params);
    $res["status"] = $newInfo;
    echo json_encode($res);
}

public function paso5()
{
    $params = $this->input->post();
    $newInfo = $this->mainctrdao->paso5($params);
    $res["status"] = $newInfo;
    echo json_encode($res);
}


public function viewDeal()
    { // module/deal/deals
        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }

        


        $this->libraries["css"]["dependences"][] = "assets/vendors/select2/dist/css/select2.min.css";
        $this->libraries["css"]["dependences"][] = "assets/vendors/bootstrap-daterangepicker/daterangepicker.css";
        $this->libraries["css"]["dependences"][] = "assets/css/main.style.css";
        $this->libraries["css"]["dependences"][] = "assets/css/modal.windows.css";
        $this->libraries["css"]["dependences"][] = "assets/vendors/distexcel/handsontable.full.min.css";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/routing.page.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/select2/dist/js/select2.full.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/moment/min/moment.min.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/switchery/dist/switchery.min.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/bootstrap-daterangepicker/daterangepicker.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/jQuery.Select.Year/lib/year-select.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/DefaultFn.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/AttachmentObj.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/FormObj.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/ModalObj.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/DataTableObj.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/distexcel/handsontable.full.min.js";
        $this->libraries["js"]["dependences"][] = "assets/js/modules/energy_management/fechamuestra.js";

        $this->libraries["js"]["dependences"][] = "assets/js/modules/ofertas/viewDeal.js";


        $clients = $this->mainctrdao->getClients();
        $clientsSelect = $this->mainctrdao->getClientsSelect();
        $divisionesSelect = $this->mainctrdao->getDivisionesSelect();
       

        $validarPrecio = 0;
        $validarTarifa = 0;
        $validarHorario = 0;
        $validarGenerador = 0;

        $validarPrecio = $this->mainctrdao->validarPrecio( $_GET["ofertaId"]);

        $validarTarifa = $this->mainctrdao->validarTarifa( $_GET["ofertaId"]); 

        $validarHorario = $this->mainctrdao->validarHorario( $_GET["ofertaId"]); 

        $validarGenerador = $this->mainctrdao->validarGenerador( $_GET["ofertaId"]);

        $validarBtnValidar = $this->mainctrdao->validarBtnValidar( $_GET["ofertaId"]);  

        $validarBtnPasoSi = $this->mainctrdao->validarBtnPasoSi( $_GET["ofertaId"]);  

        $validarBtnPasoSi2 = $this->mainctrdao->validarBtnPasoSi2( $_GET["ofertaId"]); 
        
        $validarBtnPasoSi3 = $this->mainctrdao->validarBtnPasoSi3( $_GET["ofertaId"]); 

        $validarBtnPasoSi4 = $this->mainctrdao->validarBtnPasoSi4( $_GET["ofertaId"]); 

        $findPaso = $this->mainctrdao->findPaso( $_GET["ofertaId"]); 

        $getFiles = $this->mainctrdao -> getFiles($_GET["ofertaId"]);

        $auditoria = $this->mainctrdao->getAuditoria($_GET["ofertaId"]);

        $validarBtnPasoSi5 = $this->mainctrdao->validarBtnPasoSi5( $_GET["ofertaId"]);

        $currentModule = $this->getCurrentModule();
      
        $currentModule["data"] = array(
            "vMenu" => array(
                "render" => TRUE,
                "data" => array(
                    "buttons" => array(


                    )
                )
            ),
            "userData" => $this->getUserData(),
            "ofertaId" => $_GET["ofertaId"],
            "clients" => $clients,
            "clientsSelects"=> $clientsSelect,
            "validarPrecio" => $validarPrecio,
            "validarTarifa" => $validarTarifa,
            "validarHorario" => $validarHorario,
            "validarGenerador" => $validarGenerador,
            "validarBtnValidar" => $validarBtnValidar,
            "validarBtnPasoSi" => $validarBtnPasoSi,
            "validarBtnPasoSi2" => $validarBtnPasoSi2,
            "validarBtnPasoSi3" => $validarBtnPasoSi3,
            "validarBtnPasoSi4" => $validarBtnPasoSi4,
            'findPaso' => $findPaso,
            "getFiles" => $getFiles,
            "auditoria" => $auditoria,
            "validarBtnPasoSi5" => $validarBtnPasoSi5,
            "divisionesSelect" => $divisionesSelect


        );
        $currentModule["bodyClass"] = "nav-md";

        $this->setContent($currentModule);

        $dataBuild = $this->getDataBuild();

        $dataBuild["css"] = $this->libraries["css"];
        $dataBuild["js"] = $this->libraries["js"];

        $this->load->view("mainPage", $dataBuild);
    }




    public function generar()
    {
        
        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }

        $params = $this->input->post();

        //$newInfo = $this->mainctrdao->saveDeal($this->getUserData(), $params);
        $perfil = $params["perfil"];
        $zonacarga= $params["selZC"];
        $ofertaId=$params["ofertaId"];
        $demandacontratada=$params["txtD"];
        $division=$params["selDivision"];
        $tarifa=$params["selTarifa"];

        $arrTarifas = array(
        '0'=>[$ofertaId, $params["anio1"],$params["mes1"],$params["recibo1"]],
        '1'=>[$ofertaId, $params["anio2"],$params["mes2"],$params["recibo2"]],
        '2'=>[$ofertaId, $params["anio3"],$params["mes3"],$params["recibo3"]],
        '3'=>[$ofertaId, $params["anio4"],$params["mes4"],$params["recibo4"]],
        '4'=>[$ofertaId, $params["anio5"],$params["mes5"],$params["recibo5"]],
        '5'=>[$ofertaId, $params["anio6"],$params["mes6"],$params["recibo6"]],
        '6'=>[$ofertaId, $params["anio7"],$params["mes7"],$params["recibo7"]],
        '7'=>[$ofertaId, $params["anio8"],$params["mes8"],$params["recibo8"]],
        '8'=>[$ofertaId, $params["anio9"],$params["mes9"],$params["recibo9"]],
        '9'=>[$ofertaId, $params["anio10"],$params["mes10"],$params["recibo10"]],
        '10'=>[$ofertaId, $params["anio11"],$params["mes11"],$params["recibo11"]],
        '11'=>[$ofertaId, $params["anio12"],$params["mes12"],$params["recibo12"]]
        );
        $this->mainctrdao->saveRecibosTarifas($arrTarifas);
        $arrPRC = array(
            '0'=>[$ofertaId, $params["anio1"],$params["mes1"],$params["reqcel1"]],
            '1'=>[$ofertaId, $params["anio2"],$params["mes2"],$params["reqcel2"]],
            '2'=>[$ofertaId, $params["anio3"],$params["mes3"],$params["reqcel3"]],
            '3'=>[$ofertaId, $params["anio4"],$params["mes4"],$params["reqcel4"]],
            '4'=>[$ofertaId, $params["anio5"],$params["mes5"],$params["reqcel5"]],
            '5'=>[$ofertaId, $params["anio6"],$params["mes6"],$params["reqcel6"]],
            '6'=>[$ofertaId, $params["anio7"],$params["mes7"],$params["reqcel7"]],
            '7'=>[$ofertaId, $params["anio8"],$params["mes8"],$params["reqcel8"]],
            '8'=>[$ofertaId, $params["anio9"],$params["mes9"],$params["reqcel9"]],
            '9'=>[$ofertaId, $params["anio10"],$params["mes10"],$params["reqcel10"]],
            '10'=>[$ofertaId, $params["anio11"],$params["mes11"],$params["reqcel11"]],
            '11'=>[$ofertaId, $params["anio12"],$params["mes12"],$params["reqcel12"]]
            );
        $this->mainctrdao->savePorcentajeReqCel($arrPRC);

        $GB=1; // indica si va a usar la primer tabla de Generador de Bloques o el segundo

        /********************/
        /*INICIO obtener del GB el rango de meses cargado*/
        
        $arrRangoMeses=null;
        $arrRangoMeses=$this->mainctrdao->getRangoMesesGB($ofertaId);
        if (sizeof($arrRangoMeses) == 0){
            $arrRangoMeses=$this->mainctrdao->getRangoMesesGBdos($ofertaId);
            $GB=2;
        }
        /*FIN obtener del GB el rango de meses cargado*/
        /*********/

        /********************/
        /*INICIO crear porcentaje perfil*/
        $res["porcentajeperfil"] = $this->mainctrdao->crearPorcentajePerfil($ofertaId, $GB);
        /*FIN crear porcentaje perfil*/
        /********************/


        /********************/
        /*INICIO facturacion cfessb*/
        $res["facturacioncfessb"] =$this->mainctrdao->crearFacturacionCFESSB($ofertaId, $GB, $params);        
        /********************/
        /*FIN facturacion cfessb*/

        /********************/
        /*INICIO facturacion */
        $res["facturacion1"]=$this->mainctrdao->crearFacturacion1($ofertaId, $GB, $params);        
        /********************/
        /*FIN facturacion cfessb*/


        $res["status"] = "success";
        $res["data"] = $params;
        echo json_encode($res);
    }

    public function getZonasCarga(){
        $params = $this->input->post();
        $zonasCargasSelect = $this->mainctrdao->getZonasCargasSelect($params);
        $res["status"] = "success";
        $res["data"]=$zonasCargasSelect;
        echo json_encode($res);
    }
















    public function validaFormaCapturada()
    {
        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }

        $params = $this->input->post();

        $fechainicio = $params["fechainicio"];
        $inputCentral = $params["inputCentral"];
        $inputOrden = $params["inputOrden"];
        $newInfoData = $this->mainctrdao->postInfoDataValida($this->getUserData(), $fechainicio, $inputCentral, $inputOrden);




        echo ($newInfoData);

    }

    ///alejandro castro
    public function validaFormaCapturadaDam()
    {
        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }

        $params = $this->input->post();

        $fechainicio = $params["fechainicio"];
        $inputCentral = $params["inputCentral"];
        $inputOrden = $params["inputOrden"];
        $newInfoData = $this->mainctrdao->postInfoDataValidaDam($this->getUserData(), $fechainicio, $inputCentral, $inputOrden);




        echo ($newInfoData);

    }

    public function actualizaFormas()
    {
        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }

        $params = $this->input->post();
        $datExcel = $params["datExcel"];
        $totDatExcel = $params["totDatExcel"];
        $fechainicio = $params["fechainicio"];
        $inputCentral = $params["inputCentral"];
        $inputOrden = $params["inputOrden"];
        $arrayrelunit = $params["arrayrelunit"];
        $resultdataid = $params["resultdataid"];





        $newInfoData = $this->mainctrdao->postInfoUpdateData($this->getUserData(), $datExcel, $totDatExcel, $fechainicio, $inputCentral, $inputOrden, $arrayrelunit, $resultdataid);

        echo json_encode($newInfoData);
        ///no lee el rray id

    }

    public function actualizaFormasSorder()
    {
        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }

        $params = $this->input->post();
        $datExcel = $params["datExcel"];
        $totDatExcel = $params["totDatExcel"];
        $fechainicio = $params["fechainicio"];
        $inputCentral = $params["inputCentral"];
        $inputOrden = $params["inputOrden"];
        $arrayrelunit = $params["arrayrelunit"];
        $resultdata = $params["resultdata"];




        $newInfoData = $this->mainctrdao->postInfoUpdateDataSorder($this->getUserData(), $datExcel, $totDatExcel, $fechainicio, $inputCentral, $inputOrden, $arrayrelunit, $resultdata);


    }




    public function FormasConsultas()
    {
        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }

        $params = $this->input->post();

        $fechainicio = $params["fechainicio"];
        $inputCentral = $params["inputCentral"];
        $inputOrden = $params["inputOrden"];





        $newInfoData = $this->mainctrdao->getInfoDatas($this->getUserData(), $fechainicio, $inputCentral);

        echo json_encode($newInfoData);

    }

    public function FormasConsultasTank()
    {
        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }

        $params = $this->input->post();

        $fechainicio = $params["fechainicio"];
        $inputCentral = $params["inputCentral"];
        $inputOrden = $params["inputOrden"];





        $newInfoData = $this->mainctrdao->getInfoDatasTank($this->getUserData(), $fechainicio, $inputCentral);

        echo json_encode($newInfoData);

    }


    public function FormasConsultasSorder()
    {
        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }

        $params = $this->input->post();

        $fechainicio = $params["fechainicio"];
        $inputCentral = $params["inputCentral"];
        $inputOrden = $params["inputOrden"];





        $newInfoData = $this->mainctrdao->getInfoDatasSorder($this->getUserData(), $fechainicio, $inputCentral);

        echo json_encode($newInfoData);

    }




    public function saveFormasSorder()
    {
        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }

        $this->createDir("application/logs/logws");
        $this->logging->lfile('application/logs/logws/' . date("DmyHis") . '.txt');

        $params = $this->input->post();
        $sendWS = FALSE;
        $offerEnergy = $this->getValWS($params);

        $this->mainctrdao->postInfoDataSorder($params);
        $response = array("response" => 0);

        if ($params["actualizar"] == 0) {
            $xmlWS = $this->prepareXML($offerEnergy, $params);
            $sendWS = $this->sendWS($xmlWS);
            $response = array("response" => 1);
        }

        if (!$sendWS) {
            $zipFile = $this->createZipFile($offerEnergy, $params);
            $response = array("response" => 2, "zip" => base64_encode($zipFile));
        }

        echo json_encode($response);
    }

    private function getValWS($params)
    {

        $offerArray = array();
        $sumValues = array();

        for ($i = 0; $i < count($params["headerExcel"]); $i++) {
            $unitValues = $params["datExcel"][$i];

            if (count($unitValues) == 24) {
                $unitValues[25] = 0;
            }

            foreach ($unitValues as $hour => $val) {
                if (!isset($sumValues[$hour])) {
                    $sumValues[$hour] = 0;
                }
                $sumValues[$hour] += (strlen($val) == 0 || $val == "-") ? 0 : floatval($val);
            }

            $offerArray[intval($params["inputCentral"]) == 1 ? 0 : $i] = intval($params["inputCentral"]) == 1 ? $sumValues : $unitValues;
        }

        return $offerArray;
    }

    private function prepareXML($valData, $params)
    {

        $xmlWS = array();

        foreach ($valData as $key => $data) {

            $energyJSON = array();
            $unitCode = explode("-", $params["headerExcel"][$key]);

            foreach ($data as $hour => $energyVal) {
                if ($hour == 25 && $energyVal == 0) {
                    continue;
                }
                $energyJSON[] = array(
                    "hora" => $hour,
                    "idSubInt" => 1,
                    "oiMw01" => $energyVal,
                    "oiPrecio01" => "0.0"
                );
            }

            $xmlWS[] = $this->load->view("energy_management/ws_cenace/salesOfferXML", array(
                "dateStart" => $params["fechainicio"],
                "dateEnd" => $params["fechafin"],
                "placeCode" => $unitCode[0],
                "unitCode" => $params["headerExcel"][$key],
                "energyJSON" => $energyJSON
            ), TRUE);
        }

        return $xmlWS;
    }

    private function sendWS($xml)
    {

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => "9082",
            CURLOPT_URL => "https://ws01.cenace.gob.mx:9082/mxswmement/EnviarOfertaNoDespachableService.asmx",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 2,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $xml,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: text/xml",
                "cache-control: no-cache"
            )
        )
        );

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if (strlen($response) == 0) {
            $codigoRespuesta = FALSE;
            $this->logging->lwrite("No se logro una conexión con el servidor de CENACE");
        } else {
            $this->logging->lwrite($response);
            $parteJson = strstr($response, '<enviarOfertaNoDespachableResult>');
            if (strlen($parteJson) < 5) {
                $codigoRespuesta = FALSE;
                $this->logging->lwrite("No se logro una conexión con el servidor de CENACE");
            } else {

                $extraeerror = $parteJson;
                $parteJson = strstr($parteJson, '{');
                if (strlen($parteJson) < 5) {
                    $codigoRespuesta = FALSE;
                    $extraeerror = strstr($extraeerror, '>');
                    $this->logging->lwrite("Ocurrio un error de Webservice - " . strstr($extraeerror, '</enviarOfertaNoDespachableResult>', TRUE));
                } else {
                    $parteJson = strstr($parteJson, '</enviarOfertaNoDespachableResult>', TRUE);
                    $strjson = json_decode($parteJson);
                    $arrstrjson = $strjson->resultado;

                    if ($arrstrjson[0]->codigo == 2000) {
                        $codigoRespuesta = 1;
                    } else {
                        $this->logging->lwrite("Ocurrio un error de Webservice con codigo - >" . $arrstrjson[0]->codigo);
                        $codigoRespuesta = FALSE;
                    }
                }
            }
        }

        if ($err) {
            $codigoRespuesta = FALSE;
        }

        return $codigoRespuesta;

    }

    private function createTplCenace($valData, $params, $ext = "xlsx")
    {

        $spreadSheet = $this->readTemplateXLSX("Oferta_No_Despachable.xlsx");
        $filesName = array();

        $dateStart = DateTime::createFromFormat('d/m/Y', $params["fechainicio"]);
        $dateEnd = DateTime::createFromFormat('d/m/Y', $params["fechafin"]);

        $intervalFile = !($dateStart->format("Ymd") == $dateEnd->format("Ymd")) ?
            intval($dateStart->format("m")) < intval($dateEnd->format("m")) ?
            $dateStart->format("Ymd") . " al " . $dateEnd->format("md") : $dateStart->format("Ymd") . " al " . $dateEnd->format("d") : $dateStart->format("Ymd");

        $spreadSheet->getActiveSheet()->setCellValueExplicit("D4", $params["fechainicio"], DataType::TYPE_STRING2);
        $spreadSheet->getActiveSheet()->setCellValueExplicit("H4", $params["fechafin"], DataType::TYPE_STRING2);

        foreach ($valData as $key => $data) {

            $unitCode = explode("-", $params["headerExcel"][$key]);

            $spreadSheet->getActiveSheet()->setCellValueExplicit("L4", $unitCode[0], DataType::TYPE_STRING2);
            $spreadSheet->getActiveSheet()->setCellValueExplicit("P4", $params["headerExcel"][$key], DataType::TYPE_STRING2);

            foreach ($data as $hour => $energyVal) {
                if ($hour == 25 && $energyVal == 0) {
                    continue;
                }
                $spreadSheet->getActiveSheet()->getStyle("D" . ($hour + 13))->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
                $spreadSheet->getActiveSheet()->setCellValueExplicit("D" . ($hour + 13), floatval($energyVal), DataType::TYPE_NUMERIC);
            }

            $filesName[] = array("tmpName" => $this->saveXLSXFile($spreadSheet, "5Of"), "excelName" => "5Oferta No Despachable_" . $params["headerExcel"][$key] . "_$intervalFile.$ext");

        }

        return $filesName;
    }

    private function createZipFile($offerData, $params)
    {

        $zipTmpName = tempnam("/tmp", "off");

        $zipFile = new ZipArchive();
        $zipFile->open($zipTmpName, ZipArchive::OVERWRITE);

        $excelFiles = $this->createTplCenace($offerData, $params);

        foreach ($excelFiles as $excel) {
            $zipFile->addFile($excel["tmpName"], $excel["excelName"]);
            //            unlink($excel["tmpName"]);
        }

        $zipFile->close();

        return $zipTmpName;
    }

    public function downloadZipFile($file = NULL)
    {

        $params = $this->input->get();
        parent::downloadZipFile($params["f"]);
    }

    public function wturbine()
    {

        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }

        $this->loadDataTables();




        $this->libraries["css"]["dependences"][] = "assets/vendors/select2/dist/css/select2.min.css";
        $this->libraries["css"]["dependences"][] = "assets/vendors/bootstrap-daterangepicker/daterangepicker.css";
        $this->libraries["css"]["dependences"][] = "assets/css/main.style.css";
        $this->libraries["css"]["dependences"][] = "assets/css/modal.windows.css";
        $this->libraries["css"]["dependences"][] = "assets/vendors/distexcel/handsontable.full.min.css";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/routing.page.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/select2/dist/js/select2.full.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/moment/min/moment.min.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/switchery/dist/switchery.min.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/bootstrap-daterangepicker/daterangepicker.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/jQuery.Select.Year/lib/year-select.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/DefaultFn.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/AttachmentObj.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/FormObj.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/ModalObj.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/DataTableObj.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/distexcel/handsontable.full.min.js";
        $this->libraries["js"]["dependences"][] = "assets/js/modules/energy_management/fechamuestrawturbine.js";
        $this->libraries["js"]["dependences"][] = "assets/js/modules/energy_management/validanumero.js";
        $this->libraries["js"]["dependences"][] = "assets/js/modules/energy_management/wturbine.mail.js";

        $userInfoData = $this->mainctrdao->getInfoWorkCenterDam($this->getUserData());
        $stationInfoData = $this->mainctrdao->getInfoStation($this->getUserData());


        $currentModule = $this->getCurrentModule();
        $currentModule["data"] = array(
            "vMenu" => array(
                "render" => TRUE,
                "data" => array(
                    "buttons" => array(

                    )
                )
            ),
            "userData" => $this->getUserData(),
            "userInfoData" => $userInfoData,
            "userStationData" => $stationInfoData

        );
        $currentModule["bodyClass"] = "nav-md";

        $this->setContent($currentModule);

        $dataBuild = $this->getDataBuild();

        $dataBuild["css"] = $this->libraries["css"];
        $dataBuild["js"] = $this->libraries["js"];

        $this->load->view("mainPage", $dataBuild);
    }





    public function saveFormasWturbine()
    {
        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }

        $params = $this->input->post();

        $fechainicio = $params["fechainicio"];
        $inputCentral = $params["inputCentral"];
        $inputValor = $params["inputValor"];
        $inputValorMes = $params["inputValorMes"];
        $guardaoactualiza = $params["guardaoactualiza"];


        if ($guardaoactualiza == 0) {
            $newInfoData = $this->mainctrdao->postInfoDataWturbine($this->getUserData(), $fechainicio, $inputCentral, $inputValor, $inputValorMes);
        } else {
            $newInfoData = $this->mainctrdao->postInfoDataWturbineupdate($this->getUserData(), $fechainicio, $inputCentral, $inputValor, $inputValorMes);

        }



    }

    public function consultaFormasWturbine()
    {
        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }

        $params = $this->input->post();

        $fechainicio = $params["fechainicio"];
        $inputCentral = $params["inputCentral"];


        $newInfoData = $this->mainctrdao->getInfoDataWturbine($this->getUserData(), $fechainicio, $inputCentral);




        //$fecha1 = "2010-12-29";
//$fecha2 = "2011-01-12";

        //for($i=$fecha1;$i<=$fecha2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
        //  echo $i . "<br />";
        //aca puedes comparar $i a una fecha en la bd y guardar el resultado en un arreglo

        //}





        echo json_encode($newInfoData);
    }





    public function sorder()
    {

        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }

        $this->loadDataTables();




        $this->libraries["css"]["dependences"][] = "assets/vendors/select2/dist/css/select2.min.css";
        $this->libraries["css"]["dependences"][] = "assets/vendors/bootstrap-daterangepicker/daterangepicker.css";
        $this->libraries["css"]["dependences"][] = "assets/css/main.style.css";
        $this->libraries["css"]["dependences"][] = "assets/css/modal.windows.css";
        $this->libraries["css"]["dependences"][] = "assets/vendors/distexcel/handsontable.full.min.css";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/routing.page.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/select2/dist/js/select2.full.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/moment/min/moment.min.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/switchery/dist/switchery.min.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/bootstrap-daterangepicker/daterangepicker.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/jQuery.Select.Year/lib/year-select.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/DefaultFn.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/AttachmentObj.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/FormObj.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/ModalObj.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/DataTableObj.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/distexcel/handsontable.full.min.js";
        $this->libraries["js"]["dependences"][] = "assets/js/modules/energy_management/fechasmuestrasorder.js";
        $this->libraries["js"]["dependences"][] = "assets/js/modules/energy_management/excelvalores.js";
        $this->libraries["js"]["dependences"][] = "assets/js/modules/energy_management/sorder.mail.js";

        $userInfoData = $this->mainctrdao->getInfoWorkCenter($this->getUserData());
        $stationInfoData = $this->mainctrdao->getInfoStation($this->getUserData());


        $currentModule = $this->getCurrentModule();
        $currentModule["data"] = array(
            "vMenu" => array(
                "render" => TRUE,
                "data" => array(
                    "buttons" => array(

                    )
                )
            ),
            "userData" => $this->getUserData(),
            "userInfoData" => $userInfoData,
            "userStationData" => $stationInfoData

        );
        $currentModule["bodyClass"] = "nav-md";

        $this->setContent($currentModule);

        $dataBuild = $this->getDataBuild();

        $dataBuild["css"] = $this->libraries["css"];
        $dataBuild["js"] = $this->libraries["js"];

        $this->load->view("mainPage", $dataBuild);
    }


    public function consultaultimosorder()
    {
        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }

        $params = $this->input->post();


        $inputCentral = $params["inputCentral"];


        $newInfoData = $this->mainctrdao->getInfoDatesWturbine($this->getUserData(), $inputCentral);


        echo $newInfoData;
    }






    /// elicenses

    public function elicenses()
    {

        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }

        $this->loadDataTables();




        $this->libraries["css"]["dependences"][] = "assets/vendors/select2/dist/css/select2.min.css";
        $this->libraries["css"]["dependences"][] = "assets/vendors/bootstrap-daterangepicker/daterangepicker.css";
        $this->libraries["css"]["dependences"][] = "assets/css/main.style.css";
        $this->libraries["css"]["dependences"][] = "assets/css/modal.windows.css";
        $this->libraries["css"]["dependences"][] = "assets/vendors/distexcel/handsontable.full.min.css";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/routing.page.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/select2/dist/js/select2.full.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/moment/min/moment.min.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/switchery/dist/switchery.min.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/bootstrap-daterangepicker/daterangepicker.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/jQuery.Select.Year/lib/year-select.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/DefaultFn.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/AttachmentObj.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/PanelObj.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/ButtonObj.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/FormObj.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/ModalObj.js";
        $this->libraries["js"]["dependences"][] = "assets/js/Core/DataTableObj.js";
        $this->libraries["js"]["dependences"][] = "assets/vendors/distexcel/handsontable.full.min.js";
        $this->libraries["js"]["dependences"][] = "assets/js/modules/energy_management/fechasmuestraelicenses.js";
        $this->libraries["js"]["dependences"][] = "assets/js/modules/energy_management/elicenses.mail.js";
        //$this->libraries["js"]["dependences"][]  = "assets/js/modules/energy_management/insertlic.js";

        $userInfoData = $this->mainctrdao->getInfoWorkCenterLic($this->getUserData());
        $stationInfoData = $this->mainctrdao->getInfoStationLic($this->getUserData());


        $currentModule = $this->getCurrentModule();
        $currentModule["data"] = array(
            "vMenu" => array(
                "render" => TRUE,
                "data" => array(
                    "buttons" => array(

                    )
                )
            ),
            "userData" => $this->getUserData(),
            "userInfoData" => $userInfoData,
            "userStationData" => $stationInfoData

        );
        $currentModule["bodyClass"] = "nav-md";

        $this->setContent($currentModule);

        $dataBuild = $this->getDataBuild();

        $dataBuild["css"] = $this->libraries["css"];
        $dataBuild["js"] = $this->libraries["js"];

        $this->load->view("mainPage", $dataBuild);
    }


    public function saveFormasElicenses()
    {
        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }

        $params = $this->input->post();
        $dataLicencias = $params["dataLicencias"];

        $newInfoData = $this->mainctrdao->postInfoDataElicenses($this->getUserData(), $dataLicencias);

        //echo var_dump($dataLicencias); 


        echo json_encode($newInfoData);
    }


    public function ActualizandoFormasElicenses()
    {
        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }

        $params = $this->input->post();
        $idunidadactualiar = $params["idunidadactualiar"];
        $actualizafei = $params["actualizafei"];
        $actualizafefin = $params["actualizafefin"];
        $estacionval = $params["estacionval"];
        $unidadval = $params["unidadval"];


        $newInfoData = $this->mainctrdao->postActualInfoDataElicenses($this->getUserData(), $idunidadactualiar, $actualizafei, $actualizafefin, $estacionval, $unidadval);

        //echo var_dump($dataLicencias); 


        echo json_encode($newInfoData);
    }



    public function muestraElicenses()
    {
        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }

        $params = $this->input->post();
        $activo = $params["activo"];

        $newInfoData = $this->mainctrdao->getInfoDataElicenses($this->getUserData());

        //echo var_dump($dataLicencias); 


        echo json_encode($newInfoData);
    }


    public function buscandoElicenses()
    {
        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }

        $params = $this->input->post();
        $buscarpor = $params["buscarpor"];
        $inputCentralval = $params["inputCentralval"];
        $inputUnidadesval = $params["inputUnidadesval"];
        $fechainicioval = $params["fechainicioval"];
        $fechafinval = $params["fechafinval"];
        $optradioval = $params["optradioval"];
        $numlicinputval = $params["numlicinputval"];


        $newInfoData = $this->mainctrdao->getInfoDataElicensesopciones($this->getUserData(), $buscarpor, $inputCentralval, $inputUnidadesval, $fechainicioval, $fechafinval, $optradioval, $numlicinputval);

        //echo var_dump($dataLicencias); 


        echo json_encode($newInfoData);
    }



    public function buscandoElicensesActivas()
    {
        if ($this->getSessionData() && !$this->session->userdata("userInfo")) {
            redirect(base_url() . "login");
        }

        $params = $this->input->post();
        $buscarpor = $params["buscarpor"];
        //$inputCentralval = $params["inputCentralval"];
        //$inputUnidadesval = $params["inputUnidadesval"];
        //$fechainicioval = $params["fechainicioval"];
        //$fechafinval = $params["fechafinval"];
        //$optradioval = $params["optradioval"];
        //$numlicinputval = $params["numlicinputval"];


        $newInfoData = $this->mainctrdao->getInfoDataElicensesopcionesTodas($this->getUserData(), $buscarpor);

        //echo var_dump($dataLicencias); 


        echo json_encode($newInfoData);
    }


}

