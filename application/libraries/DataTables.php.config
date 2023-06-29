<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DataTables
 *
 * @author oscar.f.medellin    
 */
require_once 'DataTables/ssp.class.php';

class DataTables extends SSP {

    private $dbConfig  = NULL;
    private $dataTable = array(
        "table"   => "",
        "idTable" => "",
        "select"  => array(),
        "query"   => "",
        "where"   => "",
        "groupBy" => ""
    );

    public function __construct() {
        parent::__construct("local");
        $this->dbConfig = $this->getConnection();
    }
    
    public function getStructureTable($table, $idTable, $specialCount = FALSE){
        $newStructure            = $this->dataTable;
        $newStructure["table"]   = $table;
        $newStructure["idTable"] = $idTable;
        
        if($specialCount){
            $newStructure["specialCount"] = "";
        }
        
        return $newStructure;
    }
    
    public function getDataTable($data, $dataTable){
        
        if(isset($dataTable["specialCount"])){
            return SSP::simple( 
                    $data, 
                    $this->dbConfig, 
                    $dataTable["table"], 
                    $dataTable["idTable"], 
                    $dataTable["select"], 
                    $dataTable["query"], 
                    $dataTable["where"], 
                    $dataTable["groupBy"],
                    $dataTable["specialCount"]);
        }
        
        return SSP::simple( 
                $data, 
                $this->dbConfig, 
                $dataTable["table"], 
                $dataTable["idTable"], 
                $dataTable["select"], 
                $dataTable["query"], 
                $dataTable["where"],
                $dataTable["groupBy"]);
        
    }

}