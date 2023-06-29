<?php
/**
 * Created by PhpStorm.
 * User: porfirio
 * Date: 15/10/2014
 * Time: 07:10 PM
 */

class Curl{

    private $curl;
    private $httpCode;

    public function __construct($params = array()){

        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, isset($params["time_out"]) ? $params["time_out"] : 0);

        if(isset($params["user"]) && isset($params["pass"])){
            curl_setopt($this->curl, CURLOPT_USERPWD, "$params[user]:$params[pass]");
        }

    }
    
    private function logs(){
        $this->httpCode = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        $errorData = array();
        
        if($this->httpCode <= 400 ){
            $errorData["errorNumber"] = $this->httpCode;
            $errorData["error"]       = "Request returned HTTP error ".$this->httpCode;
        }
        
        $curl_errno = curl_errno($this->curl);
        $curl_err = curl_error($this->curl);

        if ($curl_errno) {
            $msg                      = "$curl_errno : $curl_err";
            $errorData["errorNumber"] = $curl_errno;
            $errorData["error"]       = $msg;
            echo json_encode($errorData);
            exit;
        }
    }
    
    public function setHeaders($headers){
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);
    }
    
    public function configPostSend($params = NULL){
        
        curl_setopt($this->curl, CURLOPT_POST, true);
        
        if(!is_null($params)){
            if(gettype($params) == "string"){
                curl_setopt($this->curl, CURLOPT_POSTFIELDS, $params);
            }else{
                curl_setopt($this->curl, CURLOPT_POSTFIELDS, http_build_query($params));
            }

        }
    }
    
    public function callApiRequest($url, $method = "GET", $params = array(), $paramsJson = FALSE){
       
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $method);
        
        switch ($method){
            case "GET":
                break;
            case "POST": case "PATCH":
                $this->configPostSend($paramsJson ? json_encode($params) : $params);
                break;
            default:
                eval("\$this->get\$method();");
        }
        
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($this->curl);
        
        $this->logs();
        
        $jsonResponse = json_decode($response, true);
        
        if(isset($jsonResponse["error"])){
            echo $response;
            exit;
        }
        
        return array("data" => json_decode($response, true), "codeResponse" => $this->httpCode);
    }

/*    public function customResponse(){
        $this->customResponse = TRUE;
    }

    public function createCustomResponse(){

        $jsonResponse = json_decode(curl_exec($this->curl), TRUE);
        $codeResponse = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);

        return array(
            "response" => $jsonResponse,
            "code" => $codeResponse
        );

    }

    public function setHeaders($headers){
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);
    }

    public function sendGetMethod($url, $paramethers = NULL){

        if(!is_null($paramethers)){
            $params = $this->buildParamethers($paramethers);
            $url .= "?".$params;
        }

        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($this->curl, CURLOPT_POST, FALSE);
        
        error_log("curl_exec done.");
      
      $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
      error_log("Request returned status ".$httpCode);
      if (self::isFailure($httpCode)) {
        return array('errorNumber' => $httpCode,
                     'error' => 'Token request returned HTTP error '.$httpCode);
      }
      
      // Check error
      $curl_errno = curl_errno($curl);
      $curl_err = curl_error($curl);
      if ($curl_errno) {
        $msg = $curl_errno.": ".$curl_err;
        error_log("CURL returned an error: ".$msg);
        return array('errorNumber' => $curl_errno,
                     'error' => $msg);
      }

        return $this->customResponse ? $this->createCustomResponse() : curl_exec($this->curl);
    }

    public function sendPostMethod($url, $paramethers = NULL){

        if(!is_null($paramethers)){

            if(json_decode($paramethers)){
                curl_setopt($this->curl, CURLOPT_POSTFIELDS, $paramethers);
            }else{
                $params = $this->buildParamethers($paramethers);
                curl_setopt($this->curl, CURLOPT_POSTFIELDS, $params);
            }

        }

        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($this->curl, CURLOPT_POST, TRUE);

        return $this->customResponse ? $this->createCustomResponse() : curl_exec($this->curl);

    }

    public function buildParamethers($paramethers){

        $param_result = "";

        foreach($paramethers as $key => $value){
            $param_result .= $key."=".$value."&";
        }

        return trim($param_result, "&");

    }*/

    public function closeCurl(){
        curl_close($this->curl);
    }
// cambios
}

?>