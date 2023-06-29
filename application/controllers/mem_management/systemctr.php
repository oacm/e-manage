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
        
        $this->load->model("mem_management/systemdao" , "dao");
    }
    
    public function getRangeMtr($year, $month, $day, $range){
        
        if(!checkdate(intval($month), intval($day), intval($year))){
            echo json_encode(array("error" => TRUE, "textStatus" => "Invalid Date Format"));
            return;
        }else if($range > 60){
            echo json_encode(array("error" => TRUE, "textStatus" => "Value out of range"));
            return;
        }
        
        $data      = array();
        $nodes     = array('01NEC-85','01TEP-85','01PTL-85','01ZIC-85','01LER-85','01LEC-85');
        $idx       = 0;
        
        $mtrPrices = $this->dao->getRangeMtr(intval($year) . "-" . (intval($month) < 10 ? "0" . intval($month): intval($month)) . "-" . (intval($month) < 10 ? "0" . intval($day): intval($day)), $range);
        
        foreach ($mtrPrices as $price){
            if($price["cp"] == 1){$data[] = array("date" => $price["date"], "hour" => $price["hour"]);}
            $data[$idx][$price["cat_node_id"]] = $price["local_marginal_price_mwh"];
            if($price["cp"] == 6){$idx++;}
        }
        
        echo json_encode($data);
        
    }
    
    public function setPrices($typePrices, $typeMarket, $fileType){
        
        if(!isset($_FILES["file"])){echo json_encode(array("error" => TRUE, "textStatus" => "File not found"));return;}
        
        $fileExt = strtoupper(substr($_FILES["file"]["name"], strrpos($_FILES["file"]["name"], ".", -1) + 1));
        if($fileExt !== strtoupper($fileType)){return json_encode(array("error" => TRUE, "textStatus" => "Not $fileExt File"));}
        
        eval('$process = $this->read' . $fileExt . '($_FILES["file"]["tmp_name"], "r");');
        
        echo json_encode($this->dao->setPrices($typePrices, $typeMarket, $process));
        
    }
    
    public function getAvgPricesMDA($year, $month, $day){
        
        if(!checkdate(intval($month), intval($day), intval($year))){
            echo json_encode(array("error" => TRUE, "textStatus" => "Invalid Date"));
            return;
        }
        
        $dayPublication = intval($year) . "-" . (intval($month) < 10 ? "0" . intval($month): intval($month)) . "-" . (intval($day) < 10 ? "0" . intval($day): intval($day));
        
        echo json_encode($this->dao->getAvgPricesMDA($dayPublication));
    }
}
