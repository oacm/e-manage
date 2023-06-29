<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of systemctr
 *
 * @author oscar.f.medellin
 */
class SystemCtr extends VX_Controller {
    
    public function __construct() {
        
        parent::__construct(TRUE);
        
        $this->load->model("manage_email/systemdao"    , "dao");
        $this->load->model("manage_email/o365dao"      , "o365");
        $this->load->model("manage_email/inmaildao"    , "inmail");
        $this->load->model("manage_email/pendingdocdao", "pendingdoc");
        $this->load->model("manage_email/maindao"      , "mainmodel");
        $this->load->model("manage_email/outmaildao"   , "outmail");
        
        $this->load->helper("o365config");
        
        $this->load->library("PHPMailerObj", "phpmailerobj");
        
        foreach (getMailManageMail() as $key => $value) {
            $this->{"$key"} = $value;
        }
    }
    
    /* Funciones principales */
    private function getAreaEmployee(){
        return $this->dao->getAreaEmployee($this->session->userdata("userInfo")["employee_id"]);
    }
    /* Funciones principales */
    /* Envio de mails */
    public function sendReminderAdmin(){
        
        $params        = count($this->input->post()) === 0 ? $this->input->get() : $this->input->post();
        $remindersData = $this->dao->sendReminderAdmin($params ? $params : []);
        
        $dataMail               = array(
            "subject" => "Documentos Pendientes de Atender",
            "html"    => TRUE,
            "from"    => "Gestión Corresponcía"
        );
        
        $this->phpmailerobj->setDebugMailer();
        $this->phpmailerobj->configMailer();
        $this->phpmailerobj->setSharedMail("manage.mail@fenixenergia.com.mx");
        
        foreach ($remindersData as $data){
            $dataMail["msg"] = $this->load->view("manage_email/mails/mailReminderAdmin", $data, TRUE);
            $this->phpmailerobj->setAddress($data["email"]);
            $this->phpmailerobj->sendMailer($dataMail);
            
            $this->phpmailerobj->clearAddress();
        }
    }
    
    public function sendReminderMakerAnswer(){
        
        $params        = count($this->input->post()) === 0 ? $this->input->get() : $this->input->post();
        $remindersData = $this->dao->sendReminderMakerAnswer($params ? $params : []);
        
        $dataMail               = array(
            "subject" => "Documentos Pendientes de Atender",
            "html"    => TRUE,
            "from"    => "Gestión Corresponcía"
        );
        
        $this->phpmailerobj->setDebugMailer();
        $this->phpmailerobj->configMailer();
        $this->phpmailerobj->setSharedMail("manage.mail@fenixenergia.com.mx");
        
        foreach ($remindersData as $data){
            $dataMail["msg"] = $this->load->view("manage_email/mails/sendReminderMakerAnswer", $data, TRUE);
            $this->phpmailerobj->setAddress($data["email"]);
            $this->phpmailerobj->sendMailer($dataMail);
            
            $this->phpmailerobj->clearAddress();
        }
    }
    
    public function setDefeatedDocs(){
        
        $params      = count($this->input->post()) === 0 ? $this->input->get() : $this->input->post();
        $docDefeated = $this->dao->getDocumentsDefeated($params ? $params : []);
        $currentDate = new DateTime($this->getCurrentDate()->format("Y-m-d"));
        
        foreach ($docDefeated as $value){
            
            $getDate     = explode("/", $value["expiration"]);
            $dateCompare = new DateTime("$getDate[2]-$getDate[1]-$getDate[0]");
            $interval    = $currentDate->diff($dateCompare);
            
            if(intval($interval->format("%R%a")) < 0){                
                $mainFolio = $this->inmail->getDocumentData(array("folio" => $value["control_folio"]));                
                $this->dao->setDefeatedDoc($mainFolio);
            }
            
        }
        
    }
    
    public function sendMailComment(){
        
        $params         = $this->input->post();
        $comment        = $params["comment"];
        $params["m.id"] = 2;
        $mailsArray     = array();
        unset($params["comment"]);
        
        $docData = $this->inmail->getDataDocumentComplete(array("control_folio" => $params["control_folio"]));
                
        if(intval($docData["onlyRead"]) == 0){$params["mat.returned"] = 0;}
        
        $mailsArray["to"]     = $this->mainmodel->getEmailToSend($params);
        $mailsArray["cc"]     = array_column($this->pendingdoc->getCC(array("control_folio" => $params["control_folio"])), "email");
                
        if(intval($docData["employee_id"]) !== 0 && ($docData["status_id"] == 4 || $docData["status_id"] == 7)){
            $mailsArray["cc"][] = $this->inmail->searchCompleteEmployeeData(array("employee_id" => $docData["employee_id"]))["email"];
        }
        
        $this->setSharedMail($this->phpmailerobj, "manage.mail@fenixenergia.com.mx");
        $this->configMail($this->phpmailerobj);
        $this->sendMail($this->phpmailerobj, $mailsArray, $this->load->view("manage_email/mails/sendCommentMessage", array(
            "user"         => $this->session->userdata("userInfo")["employee"],
            "controlFolio" => $params["control_folio"],
            "comment"      => $comment), TRUE));
        
        echo json_encode(array("success" => TRUE));
        
    }
    
    public function askAnswerMail(){
        
        $params     = $this->input->post();
        $comment    = $params["comment"];
        unset($params["comment"]);
        
        $docData = $this->inmail->getDataDocumentComplete($params);
        
        $mailEmployee = $this->dao->searchCompleteEmployeeData(array("employee_id" => $docData["employee_id"]));
        $mailsCC      = array_column($this->pendingdoc->getCC($params), "email");
        
        $this->setSharedMail($this->phpmailerobj, "manage.mail@fenixenergia.com.mx");
        $this->setSubject("Elaborar respuesta");
        $this->configMail($this->phpmailerobj);
        $this->sendMail($this->phpmailerobj, $mailEmployee["email"], $this->load->view("manage_email/mails/askAnswerMail", array(
                    "subject"      => $docData["subject"],
                    "theme"        => $docData["theme"],
                    "comment"      => $comment,
                    "controlFolio" => $params["control_folio"],
                    "expiration"   => $docData["priority_id"] == 4 ? "No aplica" : str_replace("/", " - ", $docData["expiration"]),
                    "area"         => $docData["nameAreas"]), TRUE));
        
        if(count($mailsCC) !== 0){
            $this->sendMail($this->phpmailerobj, array("to" => $mailsCC), $this->load->view("manage_email/mails/askAnswerMailCC", array(
            "user"         => $this->session->userdata("userInfo")["employee"],
            "employee"     => $docData["employee"],
            "subject"      => $docData["subject"],
            "theme"        => $docData["theme"],
            "controlFolio" => $params["control_folio"],
            "expiration"   => $docData["priority_id"] == 4 ? "No aplica" : str_replace("/", " - ", $docData["expiration"]),
            "comment"      => $comment), TRUE));
        }
        
        echo json_encode(array("success" => TRUE));
    }
    
    public function answerDocMail(){
        
        $params     = $this->input->post();        
        $docData    = $this->inmail->getDataDocumentComplete(array_slice($params, 0, 1));
        $mailsArray = array();
        
        $mailsArray["to"] = $this->mainmodel->getEmailToSend(array("control_folio" => $params["control_folio"]));
        $mailsArray["cc"] = array_column($this->pendingdoc->getCC(array_slice($params, 0, 1)), "email");
        
        $this->setSharedMail($this->phpmailerobj, "manage.mail@fenixenergia.com.mx");
        $this->configMail($this->phpmailerobj);
        $this->setSubject("Respuesta al documento");
        $this->sendMail($this->phpmailerobj, $mailsArray, $this->load->view("manage_email/mails/answerMail", array(
                    "user"         => $this->session->userdata("userInfo")["employee"],
                    "subject"      => $docData["subject"],
                    "theme"        => $docData["theme"],
                    "comment"      => $params["comment"],
                    "controlFolio" => $params["control_folio"],
                    "curDate"      => $this->getCurrentDate(FALSE),
                    "expiration"   => $docData["priority_id"] == 4 ? "No aplica" : str_replace("/", " - ", $docData["expiration"])), TRUE));
        
        echo json_encode(array("success" => TRUE));
    }
    
    public function rejectAcceptMail(){
        
        $params  = $this->input->post();
        $docData = $this->inmail->getDataDocumentComplete(array_slice($params, 0, 1));
        
        $mailEmployee = $this->dao->searchCompleteEmployeeData(array("employee_id" => $docData["employee_id"]));
        $mailsCC      = array_column($this->pendingdoc->getCC(array_slice($params, 0, 1)), "email");
        $dataMail     = array("controlFolio" => $params["control_folio"]);        
        
        $this->setSharedMail($this->phpmailerobj, "manage.mail@fenixenergia.com.mx");
        $this->configMail($this->phpmailerobj);
        $this->setSubject(isset($params["comment"]) ? "Rechazo de documento" : "Respuesta aceptada");
        $mailToEmployee = isset($params["comment"]) ? 
            $this->load->view("manage_email/mails/rejectDocMail", array_merge($dataMail, array_slice($params, 1, 1)), TRUE): 
            $this->load->view("manage_email/mails/acceptDocMail", $docData, TRUE);
        
        $this->sendMail($this->phpmailerobj, $mailEmployee["email"], $mailToEmployee);
        
        if(count($mailsCC) !== 0){
            $mailToCC       = isset($params["comment"]) ? 
            $this->load->view("manage_email/mails/rejectDocMailCC", array_merge($dataMail, array_slice($params, 1, 1), array("user" => $this->session->userdata("userInfo")["employee"])), TRUE):
            $this->load->view("manage_email/mails/acceptDocMailCC", $docData, TRUE);
            $this->sendMail($this->phpmailerobj, array("to" => $mailsCC), $mailToCC);
        }
        
        echo json_encode(array("success" => TRUE));
    }
    /* Envio de mails */
    /* Procesos de O365 */
    public function sendFailureMailFile($userId, $msgId, $message){
        
        $params = array(
            "user_id"    => $userId,
            "message_id" => $msgId,
            "data"       => array("comment" =>  $this->load->view("manage_email/mails/sendFailureMailFile", array(
                "message" => $message
            ),TRUE))
        );
        
        $reply = $this->o365->replyTo($params);
        
        echo "<pre>";
        var_dump($reply);
        echo "</pre>";
    }

    private function getAttachToMailManage($userId, $messageId, $attachData){
        
        $countAttach  = 0;$attachFilter = array();
        
        foreach ($attachData as $value) {
            if(!$value["isInline"]){
                $value["attach_id"] = $value["id"]; $value["user_id"] = $userId; $value["message_id"] = $messageId;
                $attachFilter[]     = $value;
                $countAttach++;
            }
        }
        
        if($countAttach != 1){
            $this->sendFailureMailFile($userId, $messageId, "un dato adjunto no puedes adjuntar multiples datos");
            $this->updateMessage($userId, $messageId);
            $this->moveProcessMessage($userId, $messageId);
            exit();
        }
        
        $attachExtension = explode("/",$attachData[0]["contentType"])[1];
        
        if(strtolower($attachExtension) != "pdf"){
            $this->sendFailureMailFile($userId, $messageId, "archivos en formato PDF");
            $this->updateMessage($userId, $messageId);
            $this->moveProcessMessage($userId, $messageId);
            exit();
        }
        
        return $this->o365->getFileAttach($attachFilter[0]);
        
    }
    
    public function updateMessage($userId, $messageId){
        $params = array(
            "user_id"    => $userId,
            "message_id" => $messageId,
            "data"       => array(
                "isRead" => TRUE
            )
        );
        
        $update = $this->o365->updateMsg($params);
        
        echo "<pre>";
        var_dump($update);
        echo "</pre>";
    }
    
    public function moveProcessMessage($userId, $messageId){
        
        $params = array(
            "user_id"    => $userId,
            "message_id" => $messageId,
            "data"       => array(
                "DestinationId" => $this->process_folder
            ),
            "filters"    => array("select" => "id,changeKey")
        );
        
        $moving = $this->o365->moveMsgFolder($params);
        
        echo "<pre>";
        var_dump($moving);
        echo "</pre>";
    }
    
    public function saveFilesAttached($file){
        
        $employeeData = $this->inmail->searchCompleteEmployeeData(array("email" => $file["email"]));
        
        $docData      = $this->inmail->getDocumentFolio(TRUE);
        $urlComplete  = $this->checkURL(array("managemail", "$docData[code]"), FALSE);        
        $fileData     = array("path" => $urlComplete, "extension"=>".pdf", "name"=>"$docData[code]-$docData[num_document]$docData[year_document]");
        
        $logs = array(
            "user_creation"     => $employeeData["employee_id"],
            "user_modification" => $employeeData["employee_id"],
            "date_creation"     => $this->getCurrentDate(TRUE),
            "date_modification" => $this->getCurrentDate(TRUE)
        );
        
        try{
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . FOLDER_DEFAULT . "$urlComplete/$docData[code]-$docData[num_document]$docData[year_document].pdf", base64_decode($file["contentBytes"]));
        } catch (Exception $e){
            print_r($e);
            exit;
        }
        
        $this->inmail->addNewDoc(array_merge($docData, $logs, array("from_inbox" => 1)), FALSE);
        $this->inmail->saveImagesFromDocument($docData, array(array_merge($fileData, $logs)), FALSE);
    }
    
    public function getFilesUser(){
        
        $params = array("user_id" => $this->user_id, 
            "folder_id" => $this->inbox_folder, 
            "filters" => array(
                "search" => '"hasAttachments:true"',
                "select" => "id,from"
        ));
        $files  = array();
                
        $attachMsg = $this->o365->getMessagesUser($params)["data"];
        if(count($attachMsg["value"]) == 0){echo "No existen mensajes para procesar";return;}
        $params["filters"] = array("select" => "id,isInline,contentType");
        
        foreach ($attachMsg["value"] as $message) {
            
            $params["message_id"] = $message["id"];
            $attachments          = $this->o365->getMessageAttachment($params)["data"]["value"];
            $file                 = $this->getAttachToMailManage($params["user_id"], $params["message_id"], $attachments)["data"];
            $file["email"]        = $message["from"]["emailAddress"]["address"];
            $files[]              = $file;
            $this->updateMessage($params["user_id"], $params["message_id"]);
            $this->moveProcessMessage($params["user_id"], $params["message_id"]);
        }
        
        foreach ($files as $file365) {$this->saveFilesAttached($file365);}
    }
    
    public function checkTokensO365(){
        $this->dao->checkTokensO365();
    }
    /* Procesos de O365 */
    /* Funciones de combos */
    public function getAreas(){
        $data = $this->input->get();
        echo json_encode($this->dao->getAreas($data));
    }
    
    public function getNumAvailable(){
        $data = $this->input->get() ? $this->input->get() : $this->input->post();
        echo json_encode($this->dao->getNumberAvailable($data));
    }
    /* Funciones de combos */
    /* Funciones Generales de todos los modulos pertenecientes a manage_email */
    public function setDocHistoryConfig(){
        
        $params        = $this->input->post();
        
        $documentFolio = $this->inmail->getIdDoc($params["control_folio"]);
        $docFolioOut   = $params["folio_doc_out"];
        
        $params["sender_id"]       = $this->inmail->getIdSender(isset($params["sender_id"])      ? $params["sender_id"]  : "--------");
        $params["contact_id"]      = $this->inmail->getIdContact(isset($params["contact_id"])    ? $params["contact_id"] : "--------");
        $params["theme_id"]        = $this->pendingdoc->getIdThemeDoc(isset($params["theme_id"]) ? $params["theme_id"]   : "No Aplica");
        $params["expiration_date"] = "0000-00-00 00:00:00";
        $params["answered"]        = 1; $params["status_id"] = 2; $params["priority_id"] = 4; $params["not_initial_doc"] = isset($params["doc_initial"]) ? 0 : 1;

        $area         = explode("-", $params["area_code"]); $areaCode = count($area) === 1 ? $area[0] : $area[1]; 
        $nameArchives = isset($params["doc_initial"]) ? array($params["control_folio"], "$docFolioOut") : array("$docFolioOut");
        $urlComplete  = isset($params["doc_initial"]) ? array($this->checkURL(array("managemail", "FNX-Doc-ECRR"), FALSE), $this->checkURL(array("managemail", $areaCode, "answered"), FALSE)) : $this->checkURL(array("managemail", $areaCode, "answered"), FALSE);
        
        $fileData = $this->saveFiles($urlComplete, array("pdf", "image"), $nameArchives);

        for ($i = 0 ; $i < count($fileData) ; $i++) { $fileData[$i]["final_document"] = count($fileData) == 1 ? 1 : $i;}
        
        $this->inmail->saveImagesFromDocument($documentFolio, $fileData);
        
        $docId = array_merge($documentFolio, array("area_id" => $params["area"]));
        $this->inmail->saveAssingTo($docId);
        unset($params["area"]); unset($params["control_folio"]); unset($params["folio_doc_out"]); unset($params["doc_initial"]); unset($params["area_code"]);
        $this->outmail->sendResponse($documentFolio, $params);
        
        
        echo json_encode(array("success" => TRUE));
    }
    
    public function getCodeArea(){
        
        $areaDocument = $this->getAreaEmployee();
        
        $corp     = "$areaDocument[clave]";
        $codeArea = strlen($areaDocument["main_code_doc"]) == 0 
                ? "$areaDocument[document_code]" 
                : "$areaDocument[main_code_doc]-$areaDocument[document_code]";
        
        echo json_encode(array(
            "corp"    => $corp,
            "doc_code"    => $codeArea,
            "area" => $areaDocument["area_id"],    
        ));
        
    }
    /* Funciones Generales de todos los modulos pertenecientes a manage_email */
    
}