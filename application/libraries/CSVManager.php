<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CVSManager
 *
 * @author oscar.f.medellin
 */
include "ReadFiles/FileManager.php";

class CSVManager extends FileManager {
    
    private $fileCSV, $error = FALSE, $errorType = NULL;
    private $dataCSV = array();

    public function __construct($fileCSV = NULL, $mode = "r"){
        
        if(is_array($fileCSV)){
            $mode    = isset($fileCSV["mode"])    ? $fileCSV["mode"]    : "r";
            $fileCSV = isset($fileCSV["fileCSV"]) ? $fileCSV["fileCSV"] : NULL;
        }
        
        if(is_null($fileCSV)){
            return;
        }
        
        parent::__construct($fileCSV, $mode);
        $this->isCSV();
        if($this->openCSV() === FALSE){
            $this->csvProcessedFile("error");
            $this->error = TRUE;
            $this->errorType = "No se pudo abrir el archivo";
        }
    }
    
    public function setFileCSV($fileCSV, $mode = "r"){
        
        parent::__construct($fileCSV, $mode);
        
        $this->isCSV();
        
        if($this->openCSV() === FALSE){
            $this->csvProcessedFile("error");
            $this->error = TRUE;
            $this->errorType = "No se pudo abrir el archivo";
        }
        
        return $this;
    }
    
    private function encodeUTF8Array($dataArray){
        
        foreach ($dataArray as $key => $value) {
            if(gettype($value) == "array"){
                $dataArray[$key] = $this->encodeUTF8Array($dataArray[$key]);
            }
            
            $dataArray[$key] = utf8_encode($value);
        }
        
        return $dataArray;
        
    }
    
    private function encodeArray($encode, $dataArray){
        
        $dataEncodeArray = NULL;
        
        switch ($encode) {
            case "utf8":
                $dataEncodeArray = $this->encodeUTF8Array($dataArray);
                break;
        }
        
        return $dataEncodeArray;
    }
    
    public function hasError(){
        return $this->error;
    }
    
    public function getErrorType(){
        return $this->errorType;
    }
    
    public function isCSV(){
        
        if(strtolower($this->getExtension()) !== "csv"){
            $this->error     = TRUE;
            $this->errorType = "El archivo no es de formato CSV";
        }
    }
    
    public function openCSV($csvUri = NULL, $encode = NULL){
        
        if(!is_null($csvUri)){
            $this->setFileUri($csvUri);
            return $this->fileCSV = $this->openFile();
        }
        
        $this->fileCSV = $this->getOpenFile();
        
        if(!is_null($encode)){
            $this->readCSV(array("encode" => $encode));
        } else {
            $this->readCSV();
        }        
    }
    
    public function readCSV($maxLen = 0, $delimiter = ",", $encode = NULL){
        
        if(gettype($maxLen) == "array"){
            $copyValue = $maxLen;
            $maxLen    = isset($copyValue["maxLen"])    ? $copyValue["maxLen"]    : 0;
            $delimiter = isset($copyValue["delimiter"]) ? $copyValue["delimiter"] : ",";
            $encode    = isset($copyValue["encode"])    ? $copyValue["encode"]    : NULL;
        }
        
        while (($data = fgetcsv($this->fileCSV, $maxLen, $delimiter)) !== FALSE) {
            $this->dataCSV[] = is_null($encode) ? $data : $this->encodeArray($encode, $data);
        }
        
        $this->closeFile();
    }
    
    public function getDataCSV(){
        return $this->dataCSV;
    }
    
    public function setDataCSV($csvData){
        $this->dataCSV = $csvData;
    }

    public function getArrayCSV(){
        
        $dataCSV  = $this->dataCSV;
        
        $columns  = array_shift($dataCSV);
        $csvArray = array();
        
        while($valuesCSV = array_shift($dataCSV)){
            $arrayKeyVal = array();
            
            foreach ($valuesCSV as $idx => $val) {
                $arrayKeyVal[$columns[$idx]] = $val;
            }
            
            $csvArray[] = $arrayKeyVal;
            
        }
        
        return $csvArray;
    }
    
    public function csvProcessedFile($fileProccess, $url){
        
        $dateNow     = new DateTime("now", new DateTimeZone("America/Mexico_City"));
        $dataProcess = $this->getNameFile() . "-" . $dateNow->format("YmdHis") . "." . $this->getExtension();
        
        switch ($fileProccess){
            case "error":
                $this->renameFile("$url" . "$dataProcess");
                break;
            case "done":
                $this->renameFile("$url" . "$dataProcess");
                break;
        }
    }
    
    public function resetDataCSV(){
        $this->dataCSV = array();
    }
    
}

//$cvs  = new CSVManager("C:\\xampp\\htdocs\\reportinvoiceapp\\reportData.csv");
//$data = $cvs->getDataCSV();
//
//var_dump($data[0]);