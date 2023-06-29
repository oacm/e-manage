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
class O365Dao extends VX_Model {
    
    private $token = NULL;

    public function __construct() {
        parent::__construct();
        
        $this->load->library("Curl", array("time_out" => 20),"curl");
        
        $this->load->helper("o365config");
        
        foreach (getConfigVars365() as $key => $value) {
            $this->{"$key"} = $value;
        }
    }
    
    private function oDataParams($params){
        
        if(is_null($params)){
            return "";
        }
        
        $data = array();
        
        foreach ($params as $key => $value) {
            $data[] = "$" . "$key=$value";
        }
        
        return "/?" . implode("&", $data);
        
    }
    
    public function setTokenBD($tokenData){
        
        $tokenData["date_creation"] = $this->getCurrentDate();
        $tokenData["active"]        = 1;
        
        $this->add("o365_token", $tokenData);
        
        return $this->db->insert_id();
    }
    
    public function getTokenBD($params){
        
        $params["active"] = 1;
        
        $this->db->select("access_token, token_type");
        $this->db->limit(1, 0);
        $token = $this->db->get_where("o365_token", $params)->result_array();
        
        return count($token) == 0 ? array() : $token[0];
    }
    
    public function o365AdminConsent(){
        
        return $this->o365Urls["session"].sprintf($this->o365Urls["adminconsent"], $this->o365Config["clientId"], urlencode(base_url().$this->o365Urls["redirect"]));
        
    }
    
    public function o365Manage($params){}
    
    public function getToken(){
        
        $url = $this->o365Urls["session"].sprintf($this->o365Urls["token"], $this->o365Config["tenant"]);
        
        $token_request_data = array(
            "client_id"     => $this->o365Config["clientId"],
            "client_secret" => $this->o365Config["clientSecret"],
            "grant_type"    => "client_credentials",
            "scope"         => "https://graph.microsoft.com/.default"
        );
        
        $headers = array(
            "Content-Type" => "application/x-www-form-urlencoded",
            "Accept"       => "application/json"
        );
        
        $this->curl->setHeaders($headers);
        $token = $this->curl->callApiRequest($url, "POST", $token_request_data);
        
        $token["data"]["app_id"] = $this->o365Config["clientId"];
        $tokenInsert = $this->setTokenBD($token["data"]);
        
        return $this->token = $this->getTokenBD(array("id" => $tokenInsert));
    }
    
    public function getUsers($params){
        
        $url    = $this->o365Urls["graphApi"] . "/users" . (!isset($params["user_id"]) ? "" : "/" . urldecode($params["user_id"])) . $this->oDataParams(isset($params["filters"]) ? $params["filters"] : NULL);
        $token  = is_null($this->token) ? $this->getTokenBD(array("app_id" => $this->o365Config["clientId"])) : $this->token;
        
        if(count(is_null($token) ? array() : $token) == 0){
            $token = $this->getToken();
        }

        $headers   = $this->headersDefault;
        $headers[] = "Authorization: $token[token_type] $token[access_token]";        
        
        $this->curl->setHeaders($headers);
        return $this->curl->callApiRequest($url, "GET");
        
    }
    
    public function getMessagesUser($params){
        
        $url    = $this->o365Urls["graphApi"] . "/users/" . urldecode($params["user_id"]) . ( !isset($params["folder_id"]) ? "" : "/mailFolders/" . $params["folder_id"]) . ( !isset($params["message_id"]) ? "/messages" : "/messages/$params[message_id]") . $this->oDataParams(isset($params["filters"]) ? $params["filters"] : NULL);
        $token  = is_null($this->token) ? $this->getTokenBD(array("app_id" => $this->o365Config["clientId"])) : $this->token;
        
        if(count(is_null($token) ? array() : $token) == 0){
            $token = $this->getToken();
        }
        
        $headers = array("Authorization: $token[token_type] $token[access_token]");
        
        $this->curl->setHeaders($headers);
        return $this->curl->callApiRequest($url, "GET");
    }
    
    public function getMessageAttachment($params){
        
        $url    = $this->o365Urls["graphApi"] . "/users/" . urldecode($params["user_id"]) . "/messages/$params[message_id]/attachments" . $this->oDataParams(isset($params["filters"]) ? $params["filters"] : NULL);
        $token  = is_null($this->token) ? $this->getTokenBD(array("app_id" => $this->o365Config["clientId"])) : $this->token;
        
        if(count(is_null($token) ? array() : $token) == 0){$token = $this->getToken();}
        
        $headers = array("Authorization: $token[token_type] $token[access_token]");
        
        $this->curl->setHeaders($headers);
        return $this->curl->callApiRequest($url, "GET");
    }
    
    public function getFileAttach($params){
        
        $url    = $this->o365Urls["graphApi"] . "/users/" . urldecode($params["user_id"]) . "/messages/$params[message_id]/attachments/$params[attach_id]" . $this->oDataParams(isset($params["filters"]) ? $params["filters"] : NULL);
        $token  = is_null($this->token) ? $this->getTokenBD(array("app_id" => $this->o365Config["clientId"])) : $this->token;
        
        if(count(is_null($token) ? array() : $token) == 0){$token = $this->getToken();}
        
        $headers = array("Authorization: $token[token_type] $token[access_token]");
        
        $this->curl->setHeaders($headers);
        return $this->curl->callApiRequest($url, "GET");
        
    }
    
    public function replyTo($params){
        
        $url    = $this->o365Urls["graphApi"] . "/users/" . urldecode($params["user_id"]) . "/messages/$params[message_id]/reply";
        $token  = is_null($this->token) ? $this->getTokenBD(array("app_id" => $this->o365Config["clientId"])) : $this->token;
        
        if(count(is_null($token) ? array() : $token) == 0){$token = $this->getToken();}
        
        $headers = array("Authorization: $token[token_type] $token[access_token]", "Content-Type: application/json", "Content-length: " . strlen(json_encode($params["data"])));
                
        $this->curl->setHeaders($headers);
        return $this->curl->callApiRequest($url, "POST", $params["data"], TRUE);
        
    }
    
    public function getFoldersUser($params){
        
        $url    = $this->o365Urls["graphApi"] . "/users/" . urldecode($params["user_id"]) . "/mailFolders/" . (isset($params["folder_id"]) ? "$params[folder_id]/" : "") . $this->oDataParams(isset($params["filters"]) ? $params["filters"] : NULL);
        $token  = is_null($this->token) ? $this->getTokenBD(array("app_id" => $this->o365Config["clientId"])) : $this->token;
        
        if(count(is_null($token) ? array() : $token) == 0){$token = $this->getToken();}
        
        $headers = array_merge(array("Authorization: $token[token_type] $token[access_token]"), $this->headersDefault);
                
        $this->curl->setHeaders($headers);
        return $this->curl->callApiRequest($url, "GET");
        
    }
    
    public function updateMsg($params){
        
        $url    = $this->o365Urls["graphApi"] . "/users/" . urldecode($params["user_id"]) . "/messages/$params[message_id]";
        $token  = is_null($this->token) ? $this->getTokenBD(array("app_id" => $this->o365Config["clientId"])) : $this->token;
        
        if(count(is_null($token) ? array() : $token) == 0){$token = $this->getToken();}
        
        $headers = array("Authorization: $token[token_type] $token[access_token]", "Content-Type: application/json", "Content-length: " . strlen(json_encode($params["data"])));
                
        $this->curl->setHeaders($headers);
        return $this->curl->callApiRequest($url, "PATCH", $params["data"], TRUE);
        
    }
    
    public function moveMsgFolder($params){
        
        $url    = $this->o365Urls["graphApi"] . "/users/" . urldecode($params["user_id"]) . "/messages/$params[message_id]/move" . $this->oDataParams(isset($params["filters"]) ? $params["filters"] : NULL);
        $token  = is_null($this->token) ? $this->getTokenBD(array("app_id" => $this->o365Config["clientId"])) : $this->token;
        
        if(count(is_null($token) ? array() : $token) == 0){$token = $this->getToken();}
        
        $headers = array("Authorization: $token[token_type] $token[access_token]", "Content-Type: application/json", "Content-length: " . strlen(json_encode($params["data"])));
                
        $this->curl->setHeaders($headers);
        return $this->curl->callApiRequest($url, "POST", $params["data"], TRUE);
        
    }
    
}