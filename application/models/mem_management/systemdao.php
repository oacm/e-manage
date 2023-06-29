<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of systemdao
 *
 * @author oscar.f.medellin
 */
class SystemDao extends VX_Model {
        
    public function __construct() {
        parent::__construct();
    }
    
    public function getRangeMtr($dateStart, $range){
        $query = <<<QUERY
SELECT 
    case
            WHEN corp.code_subsidiary = 'CH Necaxa' THEN 1
            WHEN corp.code_subsidiary = 'CH Tepexic' THEN 2
            WHEN corp.code_subsidiary = 'CH Patla' THEN 3
            WHEN corp.code_subsidiary = 'CH Lerma' THEN 4
            WHEN corp.code_subsidiary = 'CH Alameda' THEN 5
            ELSE 6
    end as 'cp',
    mtr.`date`,
    mtr.`hour`,
    corp.code_subsidiary,
    mtr.cat_node_id,
    mtr.local_marginal_price_mwh
FROM prices_pml_mtr mtr
JOIN cat_nodes nodes
    ON nodes.node_id = mtr.cat_node_id
JOIN cat_corps_subsidiary corp
    ON corp.corp_subsidiary_id = nodes.corp_subsidiary_id
WHERE `date` between date_sub('$dateStart', interval $range day) and '$dateStart' and nodes.node_id in ('01NEC-85','01TEP-85','01PTL-85','01ZIC-85','01LER-85','01LEC-85')
order by mtr.`date` ASC, mtr.`hour` ASC, `cp` ASC;
QUERY;
                
        $rangeMtr = $this->db->query($query)->result_array();
        
        if(count($rangeMtr) == 0){
            echo json_encode(array("error" => TRUE, "textStatus" => "No data"));
            exit;
        }
        
        return $rangeMtr;
    }
    
    public function setPrices($typePrices, $typeMarket, $process){
        
        $columnsNamesBD   = array_column($this->db->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'prices_$typePrices"."_$typeMarket';")->result_array()
                , "COLUMN_NAME");
        $columnsNamesFile = array_keys($process[0]);
        
        foreach ($columnsNamesFile as $value){
            if(array_search($value, $columnsNamesBD) === FALSE){return array("error" => TRUE, "textStatus" => "Column name $value in the file does not match in the table $typePrices"."_$typeMarket");}
        }
        
        $date = $process[0]["date"];
        
        $this->db->select("count(*) as exist", FALSE);
        $result = $this->db->get_where("prices_$typePrices"."_$typeMarket", "date = '$date'")->result_array();
        
        if($result[0]["exist"] > 0){return array("error" => TRUE, "textStatus" => "data already exist!");}
        
        return $this->addBatch("prices_$typePrices"."_$typeMarket", $process, TRUE) ? array("success" => TRUE) : FALSE;
        
    }
    
    public function getAvgPricesMDA($dayPublication){
    
        $avgPriceMDA = $this->db->query("call national_fenix_prices_mda('$dayPublication')")->result_array();
        
        if(count($avgPriceMDA) == 0){
            echo json_encode(array("error" => TRUE, "textStatus" => "No data exist!"));
            exit;
        }        
        
        return $avgPriceMDA;
    }
}
