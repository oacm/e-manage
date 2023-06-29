<?php
ini_set('memory_limit', '-1');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VX_Controller
 *
 * @author oscar.f.medellin
 */
class VX_Controller extends CI_Controller {

    private $dataBuild     = array(
        "header"  => array(),
        "sideBar" => array(),
        "content" => array(),
        "footer"  => array()
    );
    private $currentModule = array(
        "module" => "",
        "view"   => ""
    );
    private $configFile    = array();
    private $checkSession  = NULL;
    private $dataMail = array(
        "subject" => "Nuevo comentario", 
        "html"    => TRUE, 
        "from"    => "Gestión Corresponcía"
    );
    
    private $uriBase = NULL;

    public function __construct($notLogin = FALSE) {

        parent::__construct();
        
        if($notLogin){return;}

        $page         = isset($this->uri->segments[1]) ? $this->uri->segments[1] : "";        
        $checkSession = $page == "login" && !$this->session->userdata("userInfo") ? FALSE : TRUE;
                        
        if ($checkSession && $this->session->isExpired) {
            echo "Tu sesión a caducado";
            sleep(2);
            redirect(base_url() . "login");
            exit;
        }
        
        $this->checkSession                = $checkSession;
        $this->configFile["upload_path"]   = "upload";
        $this->configFile["allowed_types"] = "";
        $this->configFile["max_size"]      = "30720";
        $this->configFile["overwrite"]     = TRUE;
        $this->uriBase                     = $_SERVER["DOCUMENT_ROOT"] . FOLDER_TPL;
    }
    
    protected function readTemplateXLSX($fileName){
        $templateRoot = $this->uriBase . "uploads/templates_files/$fileName";
        $xlsFile      = IOFactory::load($templateRoot);
        
        return $xlsFile;
    }
    
    protected function saveXLSXFile($spreadSheet, $nameFile = NULL, $pathFile = NULL, $ext = "xlsx"){
        
        $fName = ((is_null($nameFile) && is_null($pathFile) ? tempnam("/tmp", "tmp") : is_null($pathFile))) ? tempnam("/tmp", $nameFile . ".$ext") : $pathFile.$nameFile;
        
        $writer = IOFactory::createWriter($spreadSheet, $ext == "xlsx" ? 'Xlsx' : $ext);
        $writer->save($fName);
        
        return $fName;
    }
    
    protected function downloadXLSXFile($spreadsheet, $nameFile = "excelDownload", $ext = "xlsx"){
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nameFile . '.' . $ext . '"');
        header('Cache-Control: max-age=0');
        
        header('Cache-Control: max-age=1');
        
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer = IOFactory::createWriter($spreadsheet, $ext == "xlsx" ? 'Xlsx' : $ext);
        $writer->save('php://output');
        
    }

    protected function downloadZipFile($zipFile){
        
        $zipFileTmp = base64_decode($zipFile);
        $zipName    = "offer_sales.zip";
        
        header("Content-type: application/zip"); 
        header("Content-Disposition: attachment; filename=$zipName");
        header("Content-length: " . filesize($zipFileTmp));
        header("Pragma: no-cache"); 
        header("Expires: 0"); 
        readfile($zipFileTmp);
        
        unlink($zipFileTmp);
    }
    
    protected function getCurrentDate($withFormat = FALSE, $timezone = "America/Mexico_City") {
        
        $fecha = new DateTime("now", new DateTimeZone($timezone));
        return $withFormat ? $fecha->format("Y-m-d H:i:s") : $fecha;
        
    }
    
    public function goToIndex(){
        sleep(2);
        redirect(base_url() . "login");
    }
    
    protected function getSessionData(){
        return $this->checkSession;
    }

    public function getCurrentModule() {

        $page      = $this->uri->segments;
        $countPage = count($page);

        switch ($countPage) {
            case 2:
                $this->currentModule["module"] = $page[2];
                $this->currentModule["view"]   = "index";
                break;
            case 3:
                $this->currentModule["module"] = $page[2];
                $this->currentModule["view"]   = $page[3];
                break;
            case 4:
                $this->currentModule["module"] = $page[3];
                $this->currentModule["view"]   = $page[4];
                break;
        }

        return $this->currentModule;
    }

    public function getUserData() {
        $userInfo = $this->session->userdata("userInfo");

        return array(
            "icon"            => $userInfo["avatar"],
            "name"            => $userInfo["employee"],
            "position"        => $userInfo["position"],
            "WorkCenter"      => $userInfo["WorkCenter"],
            "employee_id"     => $userInfo["employee_id"],
            "AdminWorkCenter" => $userInfo["AdminWorkCenter"],
            "user"            => $userInfo["user"],
            "firstLogin"      => $userInfo["first_login"]
        );
    }

    private function getHeaderData() {

        $userInfo = $this->session->userdata("userInfo");

        if ($userInfo) {
            $this->dataBuild["header"]["render"] = TRUE;
            $this->dataBuild["header"]["data"]   = array(
                "userData" => $this->getUserData()
            );
        } else {
            $this->dataBuild["header"]["render"] = FALSE;
        }
    }

    private function getSideBar() {

        $userInfo = $this->session->userdata("userInfo");
        $modules  = $this->session->userdata("modules");
        
        if ($userInfo) {
            $this->dataBuild["sideBar"]["render"] = TRUE;
            $this->dataBuild["sideBar"]["data"] = array(
                "userData" => $this->getUserData()
            );

            foreach ($modules as $module) {
                $views = array();
                foreach ($module["views"] as $view) {
                    $views[] = array(
                        $view["nameView"],
                        $view["view"],
                        $this->currentModule["view"] == $view["view"] ? TRUE : FALSE
                    );
                }
                
                $this->dataBuild["sideBar"]["data"]["modules"][] = array(
                    $module["name"],
                    $module["module"],
                    $this->currentModule["module"] == $module["module"] ? TRUE : FALSE,
                    $views
                );
            }
        } else {
            $this->dataBuild["sideBar"]["render"] = FALSE;
        }
    }

    private function getFooter() {

        $userInfo = $this->session->userdata("userInfo");

        if ($userInfo) {
            $this->dataBuild["footer"]["render"] = TRUE;
        } else {
            $this->dataBuild["footer"]["render"] = FALSE;
        }
    }

    public function setContent($content) {
        $this->dataBuild["content"] = $content;
    }

    public function getDataBuild() {

        $this->getHeaderData();
        $this->getSideBar();
        $this->getFooter();

        return $this->dataBuild;
    }

    protected function createDir($path) {
        if (!file_exists($path)) {

            if (!mkdir($path, 0777)) {
                die('Fallo al crear carpeta');
            }
        }
    }

    protected function checkFiles($files) {

        $status = array("list" => [], "error" => FALSE);
        
        if (isset($files)) {

            $numFiles =  is_string($files["name"]) ? 1 : count($files["name"]);
            $error    = FALSE;

            for ($i = 0; $i < $numFiles; $i++) {
                if ((is_string($files["name"]) ? $files["error"] : $files["error"][$i]) !== 0) {
                    $status["error"]      = TRUE;
                    $status["textStatus"] = "File/s has any type of error.";
                    $status["list"][]     = array(
                        "file"     => $files["name"][$i],
                        "type"     => $files["error"][$i],
                        "complete" => $files
                    );
                    $error = TRUE;
                }
            }
            if($error){echo json_encode($status);exit;}
        } else {$status["error"] = TRUE; $status["textStatus"] = "File not found"; echo json_encode($status);exit;}

        return $status;
    }

    public function configUpload($type, $config = array()) {
        
        $config["allowed_types"] = "";
        
        foreach ($type as $value){
            switch ($value) {
                case "image":
                    $config["allowed_types"] .= strlen($config["allowed_types"]) == 0 ? "jpeg|png|jpg" : "|jpeg|png|jpg" ;
                    break;
                case "pdf";
                    $config["allowed_types"] .= strlen($config["allowed_types"]) == 0 ? "pdf" : "|pdf";
                    break;
                case "office":
                    $config["allowed_types"] .= strlen($config["allowed_types"]) == 0 ? "docx|doc|xls|xlsx" : "|docx|doc|xls|xlsx";
                    break;
            }
        }
        
        foreach ($config as $key => $value) {
            $this->configFile[$key] = $value;
        }
        
        return $this->configFile;
        
    }
    
    public function checkURL($arrayFolders, $sameLevel = TRUE, $rootFolder = "uploads"){
        
        $folderUri   = "";
        $folderArray = array();
        
        $this->configFile["upload_path"] = $rootFolder;
        
        foreach($arrayFolders as $folder ){
            
            if($sameLevel){
                $folderUri     = $folder;
                $folderArray[] = "$rootFolder/$folderUri";
            }else{
                $folderUri .= strlen($folderUri) == 0 ? $folder : "/$folder";
            }
            
            if(!file_exists("$rootFolder/$folderUri")){
                mkdir("$rootFolder/$folderUri", 0777, true) or die("Fallo al crear carpeta");
            }
            
        }
        
        return $sameLevel ? $folderArray : "$rootFolder/$folderUri";
        
    }
    
    public function saveFiles($dirc = "uploads/", $typeFiles = array("image"), 
            $specialNameFile = array(NULL), $overwrite = TRUE) {

        $filesUploaded = array();
        $errorFiles    = $this->checkFiles($_FILES["file"]);

        if ($errorFiles["error"]) { echo json_encode($errorFiles); exit; }

        $files           = $_FILES;        
        $manyFiles       = gettype($dirc)            === "string" ? array($dirc)            : $dirc;
        $specialNameFile = gettype($specialNameFile) === "string" ? array($specialNameFile) : $specialNameFile;
        
        if(count($manyFiles) !== count($specialNameFile)){
            echo json_encode(array(
                "error" => TRUE, 
                "msg" => "Los nombres de archivo no coinciden con el número de archivos"));
        }
                
        for ($i = 0; $i < count($files["file"]["name"]); $i++) {

            $config              = $this->configUpload($typeFiles, array("upload_path" => $manyFiles[$i]));
            $config["overwrite"] = $overwrite;

            if(!is_null($specialNameFile[$i])){$config["file_name"] = $specialNameFile[$i];}

            $_FILES['file']['name']     = $files['file']['name'][$i];
            $_FILES['file']['type']     = $files['file']['type'][$i];
            $_FILES['file']['tmp_name'] = $files['file']['tmp_name'][$i];
            $_FILES['file']['error']    = $files['file']['error'][$i];
            $_FILES['file']['size']     = $files['file']['size'][$i];
            $this->upload->initialize($config);
            if (!$this->upload->do_upload("file")) {
                echo json_encode(array(
                    "error" => $this->upload->display_errors(),
                    "file"  => $files['file']['name'][$i]
                ));
                exit;
            }

            $dataImg         = array("upload_data" => $this->upload->data());
            $filesUploaded[] = array(
                "path"      => $manyFiles[$i],
                "name"      => $dataImg["upload_data"]["raw_name"],
                "extension" => $dataImg["upload_data"]["file_ext"]
            );
        }
        
        return $filesUploaded;
    }
    
    protected function setSharedMail($mailObj, $sharedMail){
        $mailObj->setSharedMail($sharedMail);
    }

    protected function configMail($mailObj, $config = NULL, $debuger = 0){
        
        $mailObj->setDebugMailer($debuger);
        if(!is_null($config)){
            if(count($config) == 2 && (gettype($config[0]) == "string" && gettype($config[1]) == "boolean")){
                $mailObj->configMailer($config[0], $config[1]);
            }else{
                echo json_encode(array("status" => "error"));
                exit();
            }
        }else{
            $mailObj->configMailer();
        }
        
    }
    
    protected function sendMail($mailObj, $mail2send, $msg, $isHTML = TRUE){
        
        $mailObj->setAddress(gettype($mail2send) === "string" ? $mail2send : $mail2send["to"]);
        
        if(isset($mail2send["cc"])){
            $mailObj->setCC($mail2send["cc"]);
        }
        if(isset($mail2send["cco"])){
            $mailObj->setBCC($mail2send["cco"]);
        }
        
        $this->dataMail["msg"]   = $msg;
        $this->dataBuild["html"] = $isHTML;

        $mailResponse = $mailObj->sendMailer($this->dataMail);
        $mailObj->clearAddress();
        
        return $mailResponse;
    }
    
    protected function setSubject($subject){
        $this->dataMail["subject"] = $subject;
    }
    
    protected function readJSON($fileMultipart, $mode){
        
        $file = fopen($fileMultipart, $mode);
        $json = "";
        
        while ($line = fgets($file)){
            $json .= $line;
        }
        
        return json_decode($json, TRUE);
    }
    
    protected function readCSV($fileMultipart, $mode){
        
        $this->load->library("CSVManager", array(
            "fileCSV" => $fileMultipart,
            "mode"    => $mode), "csv");
        
        return $csvData = $this->csv->getArrayCSV();
    }
    
    protected function multiple_column_search($array, $search_list) {
        $keyResult = FALSE;
        
        foreach ($array as $key => $value) {
            foreach ($search_list as $k => $v) {
                if (!isset($value[$k]) || $value[$k] != $v){continue 2;}
            }            
            $keyResult = $key;
        }
        return $keyResult; 
    } 

}
