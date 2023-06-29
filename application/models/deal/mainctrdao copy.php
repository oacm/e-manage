<?php

use PhpOffice\PhpSpreadsheet\IOFactory;


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mainctrDao
 *
 * @author oscar.f.medellin
 */
class mainCtrDao extends VX_Model {
    
    public function __construct() {
        parent::__construct(array("energy"));
        
        $this->load->library("DataTables", "datatables");
        $this->load->library("session");
        $this->load->library("Logging", "logging");
    }

    public function saveClient($userData, $nombre, $razonsocial, $calificado) {
        $data = array(
            'nombre' => $nombre,
            'razonSocial' => $razonsocial,
            'activo' => 1,
            'createdDate' => date("Y-m-d"),
            'calificado' => $calificado
        );

        $this->db->where('nombre', $nombre);
        $this->db->where('activo', 1);
        $result = $this->db->get('of_clientes');

        if ($result->num_rows() > 0) {
            return "Ya existe un cliente con ese nombre.";
        } else {
            $this->db->insert('of_clientes', $data);
            return "success";
        }
    }
 
    
    public function getClients(){
        $clients=$this->db->query('select oc.clienteId as cclienteId,oc.nombre as cliente,oc.razonSocial as razon, r.* from of_clientes oc
        left join of_RPUs r on r.clienteId= oc.clienteId
        where oc.activo = 1;');
        return $clients->result_array();
    }

    public function getClientsSelect(){
        $clients=$this->db->query('select * from of_clientes oc
        where oc.activo = 1;');
        return $clients->result_array();
    }
   
    public function getClientes(){
        $clientes = $this->db->query('select * from of_clientes oc
        where oc.activo = 1;');
        return $clientes->result_array();
    }

    public function getClientesRPU(){
        $clientesRPU = $this->db->query('SELECT oc.clienteId, oc.nombre, oc.razonSocial, oc.activo, 
        r.RPUid, r.rpu, r.direccion, r.division, r.demandaContratada, r.demandaMaxima, 
        r.consumoRegistrado, r.noRecibos, r.consumoAnual, r.demandaRequerida, r.planta, 
        r.razonSocial AS razonSocialRPU
        FROM of_clientes oc
        INNER JOIN of_RPUs r ON oc.clienteId = r.clienteId
        WHERE r.avtivo = 1 
        ORDER BY oc.nombre');
        return $clientesRPU->result_array();
    }

    public function getClientesRPUfilter($params){
        $clientesRPUfilter = $this->db->query('SELECT oc.clienteId, oc.nombre, oc.razonSocial, oc.activo, 
        r.RPUid, r.rpu, r.direccion, r.division, r.demandaContratada, r.demandaMaxima, 
        r.consumoRegistrado, r.noRecibos, r.consumoAnual, r.demandaRequerida, r.planta, 
        r.razonSocial AS razonSocialRPU
        FROM of_clientes oc
        INNER JOIN of_RPUs r ON oc.clienteId = r.clienteId
        WHERE r.avtivo = 1 
        AND oc.nombre = "'.$params["txtnombre"].'" 
        AND r.rpu = "'.$params["txtrpu"].'"
        ORDER BY oc.nombre');
        return $clientesRPUfilter->result_array();
    }
    


    public function removeRPU($userData,$params){
        $this->db->query("update of_RPUs set avtivo = 0, deletedDate = '".date("Y-m-d")."' where RPUid = ".$params["RPUid"].";");
        return "success";
    }

    public function saveRPU($userData,$params){
        $data = array(
            'clienteId' => $params["selCliente"],
            'rpu' => $params["txtRPU"],
            'direccion' => $params["txtdireccion"],
            'division' => $params["txtdivisiom"],
            'demandaContratada' => $params["txtDC"],
            'demandaMaxima' => $params["txtDM"],
            'consumoRegistrado' => $params["txtCR"],
            'noRecibos' => $params["txtNR"],
            'consumoAnual' => $params["txtCA"],
            'demandaRequerida' => $params["txtDR"],
            'planta' => $params["txtPlanta"],
            'razonSocial' => $params["txtRZ"],
            'createdDate' => date("Y-m-d"),
            'avtivo' => 1
        );
        $this->db->where('rpu', $params["txtRPU"]);
        $this->db->where('avtivo', 1);
        $result = $this->db->get('of_RPUs');
        if ($result->num_rows() > 0) {
            return "Ya existe un registro con ese RPU activo.";
        } else {
            $this->db->insert('of_RPUs', $data);
            return "success";
        }
    }

public function saveDeal($userData, $params) {
    $clienteId = $params["clienteId"];
    $clienteIdFormatted = ($clienteId < 10) ? '0'.$clienteId : $clienteId;
    
    $ofertaId = $this->db->query("SELECT COUNT(ofertaid) as count FROM of_ofertas WHERE clienteid = '".$clienteId."';")->row()->count + 1;
    $ofertaIdFormatted = ($ofertaId < 10) ? '00'.$ofertaId : '0'.$ofertaId;
    
    $name = $this->db->query("SELECT nombre FROM of_clientes WHERE clienteid = '".$clienteId."';")->row()->nombre;
    
    $f = $params["folio"];
    $fecha = date("ym");
   
    $folio = $clienteIdFormatted . "-" . $ofertaIdFormatted . "-" . $fecha;
   
    $data = $params;
    $data["nombre"] = 'OF-'.$name.' '.date("d/m/y");
    $data["folio"] = $f.'-'.$folio;
    $data["estado"] = 1;
    $data["paso"] = 0;
    $data["activo"] = 1;
    $data["createdDate"] = date("Y-m-d");

    $this->db->insert('of_ofertas', $data);

    return "success";
}
    
    public function getDeals(){
        $clients=$this->db->query("SELECT oc.nombre AS cliente, o.nombre AS oferta, o.folio AS fol, oe.estado, IFNULL(op.paso,'--') AS paso, o.ofertaId, oe.estadoId, op.pasoId, oc.clienteId FROM of_ofertas o
            INNER JOIN of_estados oe ON oe.estadoId = o.estado
            LEFT JOIN of_pasos op ON op.pasoId = o.paso
            INNER JOIN of_clientes oc ON oc.clienteId = o.clienteid
            WHERE o.activo = 1
            GROUP BY oc.clienteId, o.ofertaId
            ORDER BY oc.nombre, o.nombre");
        return $clients->result_array();
    }



    public function getDealsfilter($params){
        $getDealsfilter = $this->db->query('SELECT oc.nombre AS cliente, o.nombre AS oferta, o.folio AS fol, oe.estado, IFNULL(op.paso,"--") AS paso, o.ofertaId, oe.estadoId, op.pasoId, oc.clienteId FROM of_ofertas o
            INNER JOIN of_estados oe ON oe.estadoId = o.estado
            LEFT JOIN of_pasos op ON op.pasoId = o.paso
            INNER JOIN of_clientes oc ON oc.clienteId = o.clienteid
            WHERE o.activo = 1 AND oc.nombre = "'.$params["txtnombred"].'"  
            AND o.folio = "'.$params["txtfolio"].'" 
            GROUP BY oc.clienteId, o.ofertaId
            ORDER BY oc.nombre, o.nombre');
        return $getDealsfilter->result_array();
    }
    
    

    public function removeDeal($userData,$params){
        $this->db->query("update of_ofertas set activo = 0, deletedDate = '".date("Y-m-d")."' where ofertaId = ".$params["ofertaId"].";");
        return "success";
    }

    public function getDeal($ofertaId){
        $deal=$this->db->query("select o.nombre as oferta,oc.nombre as cliente,oe.estado,ifnull(op.paso,'--') as paso, o.ofertaId, oe.estadoId, op.pasoId, oc.clienteId from of_ofertas o
        inner join of_estados oe on oe.estadoId = o.estado
        left join of_pasos op on op.pasoId = o.paso
        inner join of_clientes oc on oc.clienteId = o.clienteid
        where o.activo = 1 and o.ofertaId=".$ofertaId.";");
        return $deal->result_array();
    }

    public function savePrecios($preciosFile) {
     
        // Obtiene la ruta temporal del archivo subido
        $filePath = $preciosFile['tmp_name'];       
        // Carga el archivo de Excel usando PhpSpreadsheet
        $objPHPExcel = IOFactory::load($filePath);      
        // Selecciona la primera hoja
        $sheet = $objPHPExcel->getActiveSheet();   
        // Itera por cada fila, comenzando en la fila 9
        foreach ($sheet->getRowIterator(9) as $row) {
            $rowData = array();
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE);
            foreach ($cellIterator as $cell) {
                $rowData[] = $cell->getValue();
            }
            // Crea un arreglo con los valores para la fila actual
            $data = array(
                'hora' => $rowData[0],
                'cNodo' => $rowData[1],
                'pmLocal' => $rowData[2],
                'cenergia' => $rowData[3],
                'cperdidas' => $rowData[4],
                'ccogestion' => $rowData[5],
            ); 
            //obtiene el valor de cada celda
            $tipoPrecio = $sheet->getCell('A2')->getValue();
            $entidad = $sheet->getCell('A3')->getValue(); 
            $fecha = $sheet->getCell('A5')->getValue();
    
            $tipoPrecio = preg_match('/MTR|MDA/', $tipoPrecio, $matches) ? $matches[0] : "";
    
            $entidad = str_replace("Sistema Interconectado ", "", $entidad);
    
            //Extraer la fecha de la cadena de texto
            preg_match('/Fecha: (\d{2}\/[a-zA-Z]{3}\/\d{4})/', $fecha, $matches);
            $fecha = isset($matches[1]) ? $matches[1] : "";
    
            //Agregar los nuevos valores al arreglo de datos
            $data['tipoPrecio'] = $tipoPrecio;
            $data['entidad'] = $entidad;
            $data['fecha'] = $fecha;


            // Inserta la fila en la tabla "of_precios"
            $this->db->insert('of_precios', $data);
         
        }           
        return "success";
    }

    public function saveTarifas($tarifasFile){

            // Obtiene la ruta temporal del archivo subido
            $filePath = $tarifasFile['tmp_name'];
            // Carga el archivo de Excel usando PhpSpreadsheet
            $objPHPExcel = IOFactory::load($filePath);
            // Selecciona la hoja "Tarifas"
        
        // $sheet =  $objPHPExcel->getActiveSheet();
        //$sheet = $objPHPExcel->setActiveSheetIndex(6);
            $sheet = $objPHPExcel->getSheetByName('Hoja3');

            // $rowIndex = 3;
            // $previousInpc = null; // Almacenar el valor inpc anterior

                foreach ($sheet->getRowIterator(3) as $row) {
                    $rowData = array();
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(FALSE);
                    foreach ($cellIterator as $cell) {
                        $rowData[] = $cell->getValue();
                    }
            
                    $data_distribucion = array(
                        'anio' => $rowData[0],
                        'division' => $rowData[1],
                        'tarifa' => $rowData[2],
                        'mxn/kwh' => $rowData[3]
                    );

                        $this->db->insert('of_tarifa_distribucion',  $data_distribucion);
            

                    // $data_transmicion = array (
                    //     'anio' => $rowData[6],
                    //     'tarifa' => $rowData[7],
                    //     'tarifaPrecio' => $rowData[8]
                    // );

                    //     if (!empty(array_filter($data_transmicion))) {
                    //         $this->db->insert('of_tarifa_transmision', $data_transmicion);
                    //     }

                    // $data_operacion = array (
                    //     'anio' => $rowData[10],
                    //     'tarifa' => $rowData[11]
                    // );

                    // if (!empty(array_filter($data_operacion))) {
                    //     $this->db->insert('of_tarifa_operacion', $data_operacion);
                    // }

                
                    // $data_scnmem = array (
                    //     'anio' => $rowData[13],
                    //     'tarifa' => $rowData[14]
                    // );

                    //         if (!empty(array_filter($data_scnmem))) {
                    //         $this->db->insert('of_tarifa_scnmem', $data_scnmem);
                    //         }

                    // $data_diprecio = array (
                    //     'division' => $rowData[16],
                    //     'precio' => $rowData[17]
                    // );

                    //         if (!empty(array_filter($data_diprecio))) {
                    //             $this->db->insert('of_tarifa_division_precio', $data_diprecio);
                    //         }
            

                    // $data_otrosprecios = array(
                    //     'anio' => $rowData[19],
                    //     'mes' => $rowData[20],
                    //     'mxn/kwh' => $rowData[21]
                    // );  

                    //     if (!empty(array_filter($data_otrosprecios))) {
                    //         $this->db->insert('of_tarifa_otrosprecios', $data_otrosprecios);
                    //     }

                
                    // $data_energias = array(
                    //     'anio' => $rowData[26],
                    //     'mes' => $rowData[27],
                    //     'division' => $rowData[28],
                    //     'tarifasigla' => $rowData[29],
                    //     'tafiratipo' => $rowData[30],
                    //     'mxn/kwh' => $rowData[31]
                    // );  

                    // if (!empty(array_filter($data_energias))) {
                    //     $this->db->insert('of_tarifa_energia', $data_energias);
                    // }

                    // $data_capacidad = array(
                    //     'anio' => $rowData[33],
                    //     'mes' => $rowData[34],
                    //     'tarifa' => $rowData[35],
                    //     'division' => $rowData[36],
                    //     'valor' => $rowData[37]
                    // );  

                    // if (!empty(array_filter($data_capacidad))) {
                    //     $this->db->insert('of_tarifa_capacidad', $data_capacidad);
                    // }
        
                    // $data_operacion_sb = array(
                    //     'anio' => $rowData[39],
                    //     'division' => $rowData[40],
                    //     'tarifa' => $rowData[41],
                    //     'mxn/kwh' => $rowData[42]
                    // );  

                    // if (!empty(array_filter($data_operacion_sb))) {
                    //     $this->db->insert('of_tarifa_operacion_sb', $data_operacion_sb);
                    // }    
        
                    // $data_inversion = array(
                    //     'anios' => $rowData[45],
                    //     'inversion' => $rowData[46],
                    //     'cuota_me_apro' => $rowData[47]
                    // );

                    
                    // if (!empty(array_filter($data_inversion))) {
                    //     $this->db->insert('of_tarifa_inversion_gdmth', $data_inversion);
                    // }

                    
                    // $data_sc = array(
                    //     'anio' => $rowData[49],
                    //     'mes' => $rowData[50],
                    //     'mxn/kwh' => $rowData[51]
                    // );

                    // if (!empty(array_filter($data_sc))) {
                    //     $this->db->insert('of_tarifa_tc', $data_sc);
                    // }

                    
                    // $data_necaxa = array(
                    //     'anio' => $rowData[53],
                    //     'mes' => $rowData[54],
                    //     'inpc' => $rowData[56],
                    //     'incremento' => 0 
                    // );

                    // if (!empty(array_filter($data_necaxa))) {
                    //     $this->db->insert('of_tarifa_precio_necaxa', $data_necaxa);
            
                    //     if ($previousInpc !== null) {
                    //         $currentRow = $this->db->insert_id();
                    //         $currentInpc = $rowData[56];
                    //         $incremento = ($currentInpc - $previousInpc) / $previousInpc;
            
                    //         $this->db->set('incremento', $incremento);
                    //         $this->db->where('id', $currentRow);
                    //         $this->db->update('of_tarifa_precio_necaxa');
                    //     }
            
                    //     $previousInpc = $rowData[56];
                    // }
                    // $rowIndex++;
                                        
                }

                
    return "success";   
    }

    public function saveHorarios($horariosFile) {
       
            // Obtiene la ruta temporal del archivo subido
        $filePath = $horariosFile['tmp_name'];       
        // Carga el archivo de Excel usando PhpSpreadsheet
        $objPHPExcel = IOFactory::load($filePath);      
        // Selecciona la primera hoja
        $sheet = $objPHPExcel->getActiveSheet();   
        // Itera por cada fila, comenzando en la fila 9
        foreach ($sheet->getRowIterator(8) as $row) {
            $rowData = array();
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE);
            foreach ($cellIterator as $cell) {
                $rowData[] = $cell->getValue();
            }
    
            $data_horarios = array(
                'anio' => $rowData[0],
                'mes' => $rowData[1],
                'B' => $rowData[2],
                'I' => $rowData[3],
                'P' => $rowData[4]
            ); 
        
            $this->db->insert('of_datos_horarios', $data_horarios);  
        }
      
    }

    // public function saveGenerador($generadorFile) {
    //         // Obtiene la ruta temporal del archivo subido
    //     $filePath = $generadorFile['tmp_name'];       
    //     // Carga el archivo de Excel usando PhpSpreadsheet
    //     $objPHPExcel = IOFactory::load($filePath);      
    //     // Selecciona la primera hoja
    //     $sheet = $objPHPExcel->getActiveSheet();   
    //     // Itera por cada fila, comenzando en la fila 9
    //     foreach ($sheet->getRowIterator(3) as $row) {
    //         $rowData = array();
    //         $cellIterator = $row->getCellIterator();
    //         $cellIterator->setIterateOnlyExistingCells(FALSE);
    //         foreach ($cellIterator as $cell) {
    //             $rowData[] = $cell->getValue();
    //         }

    //         $data_generador = array(
    //             'B' => $rowData[2],
    //             'I' => $rowData[3],
    //             'P' => $rowData[4],
    //             'total' => $rowData[5],
    //             'demanda_max' => $rowData[6],
    //             'demanda_max_pu' => $rowData[7],
    //             'kvarh' => $rowData[8],
    //             'anio' => $rowData[0],
    //             'mes' => $rowData[1]

    //         ); 

    //             if (!empty(array_filter($data_generador))) {
    //                 $this->db->insert('of_generador_bloques', $data_generador);
    //             }
    //     }
        
    // return "success";
    // }


    public function saveGenerador($generadorFile) {
        // Obtiene la ruta temporal del archivo subido
        $filePath = $generadorFile['tmp_name'];       
        // Carga el archivo de Excel usando PhpSpreadsheet
        $objPHPExcel = IOFactory::load($filePath);      
        // Selecciona la primera hoja
        $sheet = $objPHPExcel->getActiveSheet();   
    
        $maxRows = 12; // Número máximo de filas a recorrer
        $rowCount = 0; // Contador de filas
    
        // Itera por cada fila, comenzando en la fila 3
        foreach ($sheet->getRowIterator(3) as $row) {
            $rowCount++;
    
            $rowData = array();
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE);
            foreach ($cellIterator as $cell) {
                $rowData[] = $cell->getValue();
            }
    
            $data_generador = array(
                'B' => $rowData[2],
                'I' => $rowData[3],
                'P' => $rowData[4],
                'total' => $rowData[5],
                'demanda_max' => $rowData[6],
                'demanda_max_pu' => $rowData[7],
                'kvarh' => $rowData[8],
                'anio' => $rowData[0],
                'mes' => $rowData[1]
            ); 
    
            if (!empty(array_filter($data_generador))) {
                $this->db->insert('of_generador_bloques', $data_generador);
            }
    
            if ($rowCount >= $maxRows) {
                break; // Detiene el bucle después de alcanzar el número máximo de filas
            }
        }
    
        $rowCount = 0; // Reinicia el contador de filas
    
        // Itera por cada fila, comenzando en la fila 19
        foreach ($sheet->getRowIterator(19) as $row) {
            $rowCount++;
    
            $rowData = array();
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE);
            foreach ($cellIterator as $cell) {
                $rowData[] = $cell->getValue();
            }
    
            $data_generador_dos = array(
                'B' => $rowData[2],
                'I' => $rowData[3],
                'P' => $rowData[4],
                'total' => $rowData[5],
                'demanda_max' => $rowData[6],
                'demanda_max_pu' => $rowData[7],
                'kvarh' => $rowData[8],
                'anio' => $rowData[0],
                'mes' => $rowData[1]
            ); 
    
            if (!empty(array_filter($data_generador_dos))) {
                $this->db->insert('of_generador_bloques_dos', $data_generador_dos);
            }
    
            if ($rowCount >= $maxRows) {
                break; // Detiene el bucle después de alcanzar el número máximo de filas
            }
        }
            
        return "success";
    }
    
    


    public function saveSeguimiento($ofertaId){
        $idOferta = $ofertaId;
        $data = $params;

        $data["ofertaId"] = $idOferta;
        $data["chkprecios"] = 1 ;
        $data["chktarifas"] = 1 ;
        $data["chkdatos_horarios"] = 1;
        $data["chkgenerador_bloques"] = 1;
        $data["iptprecios"] = 1;
        $data["ipttarifas"] = 1 ;
        $data["ipthorarios"] = 1;
        $data["iptgenerador"] = 1;
        $data["aprobado_paso1"] = 0;
        $data["aprobado_paso2"] = 0;
        $data["aprobado_paso3"] = 0;
        $data["aprobado_paso4"] = 0;
        $data["aprobado_paso5"] = 0;
 
        $this->db->insert('of_datos_seguimiento', $data);
            return "success";    
    }

    public function validarSeguimiento($params){
        $ofertaId = $params["ofertaId"];
        $this->db->query("update of_datos_seguimiento set aprobado_paso1 = 1 where ofertaid = ".$ofertaId.";"); 
        return "success";
    }

    public function validarSeguimiento2($params){
        $ofertaId = $params["ofertaId"];
        $this->db->query("update of_datos_seguimiento set aprobado_paso2 = 1 where ofertaid = ".$ofertaId.";"); 
        return "success";
    }

    public function validarSeguimiento3($params){
        $ofertaId = $params["ofertaId"];
        $this->db->query("update of_datos_seguimiento set aprobado_paso3 = 1 where ofertaid = ".$ofertaId.";"); 
        return "success";
    }

    public function validarSeguimiento4($params){
        $ofertaId = $params["ofertaId"];
        $this->db->query("update of_datos_seguimiento set aprobado_paso4 = 1 where ofertaid = ".$ofertaId.";"); 
        return "success";
    }

    public function validarSeguimiento5($params){
        $ofertaId = $params["ofertaId"];
        $this->db->query("update of_datos_seguimiento set aprobado_paso5 = 1 where ofertaid = ".$ofertaId.";"); 
        return "success";
    }

    public function paso1($params){ 
        $ofertaId = $params["ofertaId"];
        $this->db->query("update of_ofertas set paso = 1 where ofertaid = ".$ofertaId.";");
        return "success";
    }

    public function paso2($params){ 
        $ofertaId = $params["ofertaId"];
        $this->db->query("update of_ofertas set paso = 2 where ofertaid = ".$ofertaId.";");
        return "success";
    }

    public function paso3($params){ 
        $ofertaId = $params["ofertaId"];
        $this->db->query("update of_ofertas set paso = 3 where ofertaid = ".$ofertaId.";");
        return "success";
    }
    public function paso4($params){ 
        $ofertaId = $params["ofertaId"];
        $this->db->query("update of_ofertas set paso = 4 where ofertaid = ".$ofertaId.";");
        return "success";
    }
    public function paso5($params){ 
        $ofertaId = $params["ofertaId"];
        $this->db->query("update of_ofertas set paso = 5 where ofertaid = ".$ofertaId.";");
        return "success";
    }

  
    // public function validarPrecio($ofertaId){
    //     $fechaActual = date('d/M/Y', strtotime('-7 hours'));
    //     $query = $this->db->query("
    //     SELECT EXISTS (
    //         SELECT 1
    //         FROM of_precios p
    //         INNER JOIN of_rpus r ON p.entidad = r.division
    //         INNER JOIN of_ofertas o ON r.clienteid = o.clienteid
    //         WHERE DATE(o.createdDate) = STR_TO_DATE(p.fecha, '%d/%b/%Y')
    //         AND o.ofertaid = $ofertaId
    //     ) AS existe_precio;"
    //     );
    
    //     return $query->row()->existe_precio; 
    // }

   
    

    // public function validarTarifa($ofertaId){
    //     $anoActual = date('Y');
    //     $result = $this->db->query("
    //         SELECT EXISTS (
    //         SELECT 1
    //         FROM of_tarifa_distribucion AS td
    //         INNER JOIN of_rpus AS r ON td.division = r.division
    //         INNER JOIN of_ofertas AS o ON r.clienteid = o.clienteid
    //         WHERE td.anio = '$anoActual'
    //         AND o.ofertaid = $ofertaId
    //       ) AS existe_tarifa;"
    // );
    
    //     return $result->row()->existe_tarifa; 
    // }

    public function validarTarifa($ofertaId) {
        $anoActual = date('Y');
        $result = $this->db->query("
            SELECT CASE
                WHEN COUNT(*) > 0 THEN TRUE
                ELSE FALSE
            END AS existe_tarifa
            FROM of_tarifa_distribucion AS td
            INNER JOIN of_RPUs AS r ON td.division = r.division
            INNER JOIN of_ofertas AS o ON r.clienteid = o.clienteid
            WHERE td.anio = '$anoActual'
            AND o.ofertaid = $ofertaId;"
        );
        
        return $result->row()->existe_tarifa; 
    }
    
    public function validarPrecio($ofertaId) {
        $fechaActual = date('d/M/Y', strtotime('-7 hours'));
        $query = $this->db->query("
            SELECT CASE
                WHEN COUNT(*) > 0 THEN TRUE
                ELSE FALSE
            END AS existe_precio
            FROM of_precios p
            INNER JOIN of_RPUs r ON p.entidad = r.division
            INNER JOIN of_ofertas o ON r.clienteid = o.clienteid
            WHERE DATE(o.createdDate) = STR_TO_DATE(p.fecha, '%d/%b/%Y')
            AND o.ofertaid = $ofertaId;"
        );
        
        return $query->row()->existe_precio;
    }
    

    public function validarHorario($ofertaId){
        $query = $this->db->query("
            SELECT
            IF(chkdatos_horarios = 1 AND ipthorarios = 1, TRUE, FALSE) AS resultado
        FROM
            of_datos_seguimiento
        WHERE
            ofertaId = $ofertaId;
       "
        );
    
        return $query->row()->resultado; 
    }

    public function validarGenerador($ofertaId){
        $query = $this->db->query("
            SELECT
            IF(chkgenerador_bloques = 1 AND iptgenerador = 1, TRUE, FALSE) AS resultado
        FROM
            of_datos_seguimiento
        WHERE
            ofertaId = $ofertaId;
        "
        );
    
        return $query->row()->resultado; 
    }

    public function validarBtnValidar($ofertaId){
        $query = $this->db->query("  
        SELECT
        IF(chkprecios = 1 AND chktarifas = 1 AND chkdatos_horarios = 1 
        AND chkgenerador_bloques = 1 AND iptprecios = 1 AND ipttarifas = 1 
        AND ipthorarios = 1 AND iptgenerador = 1, TRUE, FALSE) AS resultado
        FROM
        of_datos_seguimiento
        WHERE
        ofertaId = $ofertaId;
        "
        );
    
        return $query->row()->resultado; 
    }

    public function validarBtnPasoSi($ofertaId){
        $query = $this->db->query("  
        SELECT
        IF(aprobado_paso1 = 1 , TRUE, FALSE) AS resultado
        FROM
        of_datos_seguimiento
        WHERE
        ofertaId = $ofertaId;
        "
        );
    
        return $query->row()->resultado; 
    }

    public function validarBtnPasoSi2($ofertaId){
        $query = $this->db->query("  
        SELECT
        IF(aprobado_paso2 = 1 , TRUE, FALSE) AS resultado
        FROM
        of_datos_seguimiento
        WHERE
        ofertaId = $ofertaId;
        "
        );
    
        return $query->row()->resultado; 
    }

    public function validarBtnPasoSi3($ofertaId){
        $query = $this->db->query("  
        SELECT
        IF(aprobado_paso3 = 1 , TRUE, FALSE) AS resultado
        FROM
        of_datos_seguimiento
        WHERE
        ofertaId = $ofertaId;
        "
        );
    
        return $query->row()->resultado; 
    }

    public function validarBtnPasoSi4($ofertaId){
        $query = $this->db->query("  
        SELECT
        IF(aprobado_paso4 = 1 , TRUE, FALSE) AS resultado
        FROM
        of_datos_seguimiento
        WHERE
        ofertaId = $ofertaId;
        "
        );
    
        return $query->row()->resultado; 
    }
    
    public function findPaso($ofertaId) {
        $query = $this->db->query("
            SELECT paso
            FROM of_ofertas
            WHERE activo = 1 AND ofertaid = $ofertaId;
        ");
    
        return $query->row()->paso;
    }
    
    
    public function getDivisionesSelect(){
        $divisionesRPU = $this->db->query('select * from of_divisiones where activo = 1;');
        return $divisionesRPU->result_array();
    }
    public function getZonasCargasSelect($params){
        $zonasCarga = $this->db->query('select * from of_zonas_carga where division_id='.$params["division"].' and activo = 1;');
        return $zonasCarga->result_array();
    }

    public function getRangoMesesGB($ofertaId){
        $rangomeses = $this->db->query('select anio,mes from of_generador_bloques where id_oferta='.$ofertaId.';');
        return $rangomeses->result_array();
    }

    public function getRangoMesesGBdos($ofertaId){
        $rangomeses = $this->db->query('select anio,mes from of_generador_bloques_dos where id_oferta='.$ofertaId.';');
        return $rangomeses->result_array();
    }

    public function crearPorcentajePerfil($ofertaId, $GB){
        $GBT='';
        if ($GB==1) {
            $GBT='of_generador_bloques';
        }else{
            $GBT='of_generador_bloques_dos';
        }
        $this->db->query("truncate table of_perfil;"); 
        $perfil=$this->db->query('select 
            odh.anio, 
            odh.mes,
            ifnull(round(((ogb.B / (ogb.B+ogb.I+ogb.P))*100)),0) as perfilcc_b, 
            ifnull(round(((ogb.I / (ogb.B+ogb.I+ogb.P))*100)),0) as perfilcc_i, 
            ifnull(round(((ogb.P / (ogb.B+ogb.I+ogb.P))*100)),0) as perfilcc_p,
            ifnull(round((odh.B / (odh.B+odh.I+odh.P))*100),0) as porcentaje_b,
            ifnull(round((odh.I / (odh.B+odh.I+odh.P))*100),0) as porcentaje_i,
            ifnull(round((odh.P / (odh.B+odh.I+odh.P))*100),0) as porcentaje_p,
            ogb.total as consumo_total_kwh,
            ((odh.B / (odh.B+odh.I+odh.P))) * ogb.total as perfilbase_b,
            ((odh.I / (odh.B+odh.I+odh.P))) * ogb.total as perfilbase_i,
            ((odh.P / (odh.B+odh.I+odh.P))) * ogb.total as perfilbase_p,
            '.$ofertaId.' as oferta_id
            from of_datos_horarios odh
            inner join '.$GBT.' ogb on ogb.anio = odh.anio and ogb.mes = odh.mes
            where ogb.id_oferta='.$ofertaId.';');


        $perfilArr=$perfil->result_array();
        foreach($perfilArr as $p){
            $dataPerfil = array(
                'anio' => $p['anio'],
                'mes' => $p['mes'],
                'perfilcc_b_porcentaje' => $p['perfilcc_b'],
                'perfilcc_i_porcentaje' => $p['perfilcc_i'],
                'perfilcc_p_porcentaje' => $p['perfilcc_p'],
                'porcentaje_b' => $p['porcentaje_b'],
                'porcentaje_i' => $p['porcentaje_i'],
                'porcentaje_p' => $p['porcentaje_p'],
                'perfilbase_consumototal' => $p['consumo_total_kwh'],
                'perfilbase_b' => $p['perfilbase_b'],
                'perfilbase_i' => $p['perfilbase_i'],
                'perfilbase_p' => $p['perfilbase_p'],
                'oferta_id' => $p['oferta_id']
            ); 
        
            $this->db->insert('of_perfil', $dataPerfil);  
        }
        return true;
    }

    public function saveRecibosTarifas($params){
       
        $this->db->query("truncate table of_recibos_cfe;");  
        foreach($params as $p){
            $data = array(
                'of_oferta' => $p[0],
                'anio' => $p[1],
                'mes' => $p[2],
                'tarifa' => $p[3]
            ); 
        
            $this->db->insert('of_recibos_cfe', $data);  
        }
        return true;
    }

    public function savePorcentajeReqCel($params){
       
        $this->db->query("truncate table of_porcentaje_req_cel;");  
        foreach($params as $p){
            $data = array(
                'of_oferta' => $p[0],
                'anio' => $p[1],
                'mes' => $p[2],
                'tarifa' => $p[3]
            ); 
        
            $this->db->insert('of_recibos_cfe', $data);  
        }
        return true;
    }

    public function crearFacturacionCFESSB($ofertaId, $GB, $params){
        $GBT='';
        if ($GB==1) {
            $GBT='of_generador_bloques';
        }else{
            $GBT='of_generador_bloques_dos';
        }
        $div=$this->db->query("select division from of_divisiones where of_divisiones_id = ".$params["selDivision"].";");
        $divDato="";
        foreach($div->result_array() as $d){
            $divDato=$d["division"];
        }
        $this->db->query("truncate table of_calculo_facturacion_cfessb;");  
        $query="select
        ".$ofertaId." as id_oferta,
        t4.anio,
        t4.mes,
        t4.total,
        t4.consumoBaseKWH,
        t4.consumoIntermediaKWH,
        t4.consumoPuntaKWH,
        t4.consumoTotalKWH,
        t4.demandaMaximaKW,
        t4.demanda_maxima_puntaKW,
        t4.demandaMovilKW,
        t4.demandaDistribucionKW,
        t4.energiaReactivaKVARH,
        t4.factorPotencia,
        t4.cargoBonificacion,
        t4.energiaBaseMXNKWH,
        t4.energiaBaseMXNKWHI,
        t4.energiaBaseMXNKWHP,
        t4.capacidadMXNKW,
        t4.distribucionMXNKW,
        t4.distribucionMXNKWH,
        t4.transmisionMXNKWH,
        t4.OperacionCenaceMXNKWH,
        t4.scnmemMXNKWH,
        t4.energiaBaseMXN,
        t4.energiaIntermediaMXN,
        t4.energiaPuntaMXN,
        t4.energiaTotalMXN,
        t4.capacidadMXN,
        t4.distribucionMXN,
        t4.transmisionmxn,
        t4.operacionCenaceMXN,
        t4.SCNMEMMXN,
        t4.operacionSB, 
        t4.subtotalFacturacionCFESSBMXN,
        t4.penalizacionBonificacionporFPMXN,
        t4.subtotalFacturacionCFESSBMXN2,
        (if(t4.subtotalFacturacionCFESSBMXN2=0,0,(t4.subtotalFacturacionCFESSBMXN+t4.penalizacionBonificacionporFPMXN)/t4.consumoTotalKWH)) as tarifaMXNKWH,
        t4.tarifaReciboMXNKWH
        from (
        select t3.anio,t3.mes,t3.total,t3.consumoBaseKWH,t3.consumoIntermediaKWH,t3.consumoPuntaKWH,t3.consumoTotalKWH,t3.demandaMaximaKW,t3.demanda_maxima_puntaKW,
        t3.demandaMovilKW,
        t3.demandaDistribucionKW,
        t3.energiaReactivaKVARH,
        t3.factorPotencia,
        t3.cargoBonificacion,
        t3.energiaBaseMXNKWH,
        t3.energiaBaseMXNKWHI,
        t3.energiaBaseMXNKWHP,
        t3.capacidadMXNKW,
        t3.distribucionMXNKW,
        t3.distribucionMXNKWH,
        t3.transmisionMXNKWH,
        t3.OperacionCenaceMXNKWH,
        t3.scnmemMXNKWH,
        t3.energiaBaseMXN,
        t3.energiaIntermediaMXN,
        t3.energiaPuntaMXN,
        t3.energiaTotalMXN,
        t3.capacidadMXN,
        t3.distribucionMXN,
        t3.transmisionmxn,
        t3.operacionCenaceMXN,
        t3.SCNMEMMXN,
        t3.operacionSB,
        (t3.energiaTotalMXN+t3.capacidadMXN+t3.distribucionMXN+t3.transmisionmxn+t3.operacionCenaceMXN+t3.SCNMEMMXN+t3.operacionSB) as subtotalFacturacionCFESSBMXN,
        ((t3.energiaTotalMXN+t3.capacidadMXN+t3.distribucionMXN+t3.transmisionmxn+t3.operacionCenaceMXN+t3.SCNMEMMXN)*t3.cargoBonificacion) as penalizacionBonificacionporFPMXN,
        (if('".$params["perfil"]."'='Base',(t3.energiaTotalMXN+t3.capacidadMXN+t3.distribucionMXN+t3.transmisionmxn+t3.operacionCenaceMXN+t3.SCNMEMMXN+t3.operacionSB),if(t3.tarifaReciboMXNKWH>0,t3.tarifaReciboMXNKWH * t3.consumoTotalKWH,(t3.energiaTotalMXN+t3.capacidadMXN+t3.distribucionMXN+t3.transmisionmxn+t3.operacionCenaceMXN+t3.SCNMEMMXN+t3.operacionSB) + ((t3.energiaTotalMXN+t3.capacidadMXN+t3.distribucionMXN+t3.transmisionmxn+t3.operacionCenaceMXN+t3.SCNMEMMXN)*t3.cargoBonificacion)))) as subtotalFacturacionCFESSBMXN2,
        (t3.tarifaReciboMXNKWH) as tarifaReciboMXNKWH
        from
        (
        select 
        t2.anio,t2.mes,t2.total,t2.consumoBaseKWH,t2.consumoIntermediaKWH,t2.consumoPuntaKWH,t2.consumoTotalKWH,t2.demandaMaximaKW,t2.demanda_maxima_puntaKW,
        t2.demandaMovilKW,
        t2.demandaDistribucionKW,
        t2.energiaReactivaKVARH,
        t2.factorPotencia,
        if(t2.factorPotencia=0,0,if(t2.factorPotencia>=90,-(1/4)*(1-(90/t2.factorPotencia)),(3/5)*((90/t2.factorPotencia)-1))) as cargoBonificacion,
        t2.energiaBaseMXNKWH,
        t2.energiaBaseMXNKWHI,
        t2.energiaBaseMXNKWHP,
        t2.capacidadMXNKW,
        (select `mxn/kwh` from of_tarifa_distribucion where tarifa = '".$params["selTarifa"]."' and division='".$divDato."' and anio=t2.anio) as distribucionMXNKW,
        if(consumoTotalKWH>0,((select `mxn/kwh` from of_tarifa_distribucion where tarifa = '".$params["selTarifa"]."' and division='".$divDato."' and anio=t2.anio)*t2.demandaDistribucionKW)/consumoTotalKWH,0) as distribucionMXNKWH,
        ( select tarifaPrecio from of_tarifa_transmision where anio=t2.anio and tarifa='".$params["selTarifa"]."') as transmisionMXNKWH,
        (select tarifa from of_tarifa_operacion where anio = t2.anio) as OperacionCenaceMXNKWH,
        (select tarifa from of_tarifa_scnmem where anio = t2.anio) as scnmemMXNKWH,
        t2.energiaBaseMXNKWH * t2.consumoBaseKWH as energiaBaseMXN,
        t2.consumoIntermediaKWH * t2.energiaBaseMXNKWHI as energiaIntermediaMXN,
        t2.consumoPuntaKWH * t2.energiaBaseMXNKWHP as energiaPuntaMXN,
        ((t2.energiaBaseMXNKWH * t2.consumoBaseKWH)+(t2.consumoIntermediaKWH * t2.energiaBaseMXNKWHI)+(t2.consumoPuntaKWH * t2.energiaBaseMXNKWHP)) as energiaTotalMXN,
        (t2.capacidadMXNKW * (if(t2.demanda_maxima_puntaKW=0 and t2.demandaMaximaKW=0,t2.demandaMovilKW,if(t2.demandaMaximaKW<>0 and t2.demanda_maxima_puntaKW=0,t2.demandaMaximaKW,if(t2.demanda_maxima_puntaKW>t2.demandaMaximaKW,t2.demandaMaximaKW,t2.demanda_maxima_puntaKW))))) as capacidadMXN,
        ((select `mxn/kwh` from of_tarifa_distribucion where tarifa = '".$params["selTarifa"]."' and division='".$divDato."' and anio=t2.anio) * t2.demandaDistribucionKW) as distribucionMXN,
        (( select tarifaPrecio from of_tarifa_transmision where anio=t2.anio and tarifa='".$params["selTarifa"]."') * t2.consumoTotalKWH) as transmisionmxn,
        ((select tarifa from of_tarifa_operacion where anio = t2.anio)* t2.consumoTotalKWH) as operacionCenaceMXN,
        ((select tarifa from of_tarifa_scnmem where anio = t2.anio) * t2.consumoTotalKWH) as SCNMEMMXN,
        (if(t2.consumoTotalKWH = 0, 0, (select `mxn/kwh` from of_tarifa_operacion_sb where anio = t2.anio and division='".$divDato."' and tarifa = '".$params["selTarifa"]."'))) as operacionSB,
        t2.tarifaReciboMXNKWH
        from (
        select 
        anio,mes,total,consumoBaseKWH,consumoIntermediaKWH,consumoPuntaKWH,consumoTotalKWH,demandaMaximaKW,demanda_maxima_puntaKW,
        consumoTotalKWH / (tarifa * total) as demandaMovilKW,
        if(demandaMaximaKW=0,(consumoTotalKWH / (tarifa * total)),if(demandaMaximaKW<(consumoTotalKWH / (tarifa * total)),demandaMaximaKW,(consumoTotalKWH / (tarifa * total)))) as demandaDistribucionKW,
        if(kvarh>0,kvarh,0) as energiaReactivaKVARH,
        if(kvarh=0,0,if(consumoTotalKWH=0,0,(100*consumoTotalKWH)/(sqrt(pow(consumoTotalKWH,2)+pow(kvarh,2))))) as factorPotencia,
        energiaBaseMXNKWH,
        energiaBaseMXNKWHI,
        energiaBaseMXNKWHP,
        capacidadMXNKW,
        tarifaReciboMXNKWH
        from (
        select 
        odh.anio, 
        odh.mes,
        (odh.B+odh.I+odh.P) as total,
        if('".$params["perfil"]."'='Base',op.perfilbase_b,if(ogb.B > 0,ogb.B, op.perfilbase_b)) as consumoBaseKWH,
        if('".$params["perfil"]."'='Base',op.perfilbase_i,if(ogb.I > 0,ogb.I, op.perfilbase_i)) as consumoIntermediaKWH,
        if('".$params["perfil"]."'='Base',op.perfilbase_p,if(ogb.P > 0,ogb.P, op.perfilbase_p)) as consumoPuntaKWH,
        (if('".$params["perfil"]."'='Base',op.perfilbase_b,if(ogb.B > 0,ogb.B, op.perfilbase_b)))+(if('".$params["perfil"]."'='Base',op.perfilbase_i,if(ogb.I > 0,ogb.I, op.perfilbase_i)))+(if('".$params["perfil"]."'='Base',op.perfilbase_p,if(ogb.P > 0,ogb.P, op.perfilbase_p))) as consumoTotalKWH,
        ogb.demanda_max as demandaMaximaKW,
        if('".$params["perfil"]."'='Base',ogb.demanda_max,if(ogb.demanda_max_pu > 0,ogb.demanda_max_pu,ogb.demanda_max)) as demanda_maxima_puntaKW,
         (select precio from of_tarifa_division_precio where division = '".$params["selTarifa"]."') as tarifa ,
         ogb.kvarh,
         ote.`mxn/kwh` as energiaBaseMXNKWH,
        otei.`mxn/kwh` as energiaBaseMXNKWHI,
        otep.`mxn/kwh` as energiaBaseMXNKWHP,
        otc.valor as capacidadMXNKW,
        orc.tarifa as tarifaReciboMXNKWH
        from of_datos_horarios odh
        inner join ".$GBT." ogb on ogb.anio = odh.anio and ogb.mes = odh.mes
        inner join of_perfil op on odh.anio = op.anio and odh.mes=op.mes
        inner join of_tarifa_energia ote on ote.anio=odh.anio and ote.mes=odh.mes and ote.division='".$divDato."' and ote.tarifasigla = '".$params["selTarifa"]."' and ote.tafiratipo='Base'
        inner join of_tarifa_energia otei on otei.anio=odh.anio and otei.mes=odh.mes and otei.division='".$divDato."' and otei.tarifasigla = '".$params["selTarifa"]."' and otei.tafiratipo='INTERMEDIA'
        inner join of_tarifa_energia otep on otep.anio=odh.anio and otep.mes=odh.mes and otep.division='".$divDato."' and otep.tarifasigla = '".$params["selTarifa"]."' and otep.tafiratipo='PUNTA'
        inner join of_tarifa_capacidad otc on otc.anio=odh.anio and otc.mes=odh.mes and otc.division='".$divDato."' and otc.tarifa = '".$params["selTarifa"]."'
        inner join of_recibos_cfe orc on orc.anio = odh.anio and orc.mes=odh.mes
        where ogb.id_oferta=".$ofertaId."
        ) as t1) as t2
        ) as t3
        ) as t4
         ;";
        
        $datos=$this->db->query($query);

        $datosArr=$datos->result_array();
        foreach($datosArr as $p){
            $dataCFESSB = array(
                'of_oferta' => $p['id_oferta'],
                'anio' => $p['anio'],
                'mes' => $p['mes'],
                'total' => $p['total'],
                'consumoBaseKWH' => $p['consumoBaseKWH'],
                'consumoIntermediaKWH' => $p['consumoIntermediaKWH'],
                'consumoPuntaKWH' => $p['consumoPuntaKWH'],
                'consumoTotalKWH' => $p['consumoTotalKWH'],
                'demandaMaximaKW' => $p['demandaMaximaKW'],
                'demanda_maxima_puntaKW' => $p['demanda_maxima_puntaKW'],
                'demandaMovilKW' => $p['demandaMovilKW'],
                'demandaDistribucionKW' => $p['demandaDistribucionKW'],
                'energiaReactivaKVARH' => $p['energiaReactivaKVARH'],
                'factorPotencia' => $p['factorPotencia'],
                'cargoBonificacion' => $p['cargoBonificacion'],
                'energiaBaseMXNKWH' => $p['energiaBaseMXNKWH'],
                'energiaBaseMXNKWHI' => $p['energiaBaseMXNKWHI'],
                'energiaBaseMXNKWHP' => $p['energiaBaseMXNKWHP'],
                'capacidadMXNKW' => $p['capacidadMXNKW'],
                'distribucionMXNKW' => $p['distribucionMXNKW'],
                'distribucionMXNKWH' => $p['distribucionMXNKWH'],
                'transmisionMXNKWH' => $p['transmisionMXNKWH'],
                'OperacionCenaceMXNKWH' => $p['OperacionCenaceMXNKWH'],
                'scnmemMXNKWH' => $p['scnmemMXNKWH'],
                'energiaBaseMXN' => $p['energiaBaseMXN'],
                'energiaIntermediaMXN' => $p['energiaIntermediaMXN'],
                'energiaPuntaMXN' => $p['energiaPuntaMXN'],
                'energiaTotalMXN' => $p['energiaTotalMXN'],
                'capacidadMXN' => $p['capacidadMXN'],
                'distribucionMXN' => $p['distribucionMXN'],
                'transmisionmxn' => $p['transmisionmxn'],
                'operacionCenaceMXN' => $p['operacionCenaceMXN'],
                'SCNMEMMXN' => $p['SCNMEMMXN'],
                'operacionSB' => $p['operacionSB'],
                'subtotalFacturacionCFESSBMXN' => $p['subtotalFacturacionCFESSBMXN'],
                'penalizacionBonificacionporFPMXN' => $p['penalizacionBonificacionporFPMXN'],
                'subtotalFacturacionCFESSBMXN2' => $p['subtotalFacturacionCFESSBMXN2'],
                'tarifaMXNKWH' => $p['tarifaMXNKWH'],
                'tarifaReciboMXNKWH' => $p['tarifaReciboMXNKWH']
            ); 
            
            $res=$this->db->insert('of_calculo_facturacion_cfessb', $dataCFESSB);  
            
        }
        return true;
    }

    public function crearFacturacion1($ofertaId, $GB, $params){
        $GBT='';
        if ($GB==1) {
            $GBT='of_generador_bloques';
        }else{
            $GBT='of_generador_bloques_dos';
        }
        $div=$this->db->query("select division from of_divisiones where of_divisiones_id = ".$params["selDivision"].";");
        $divDato="";
        foreach($div->result_array() as $d){
            $divDato=$d["division"];
        }

        $this->db->query("truncate table of_calculo_facturacion_1;");  
        $query="insert into of_calculo_facturacion_1
        select 
        null,
        ogb.anio,
        ogb.mes,
        ogb.id_oferta,
        odh.B + odh.I + odh.P as total,
        ogb.total as consumoKWH,
        (ogb.total*(1+( select ppt/100 from of_ppt_ppnt where division_id=".$params["selDivision"]."))) as consumoPPTKWH,
        ((ogb.total*(1+( select ppt/100 from of_ppt_ppnt where division_id=".$params["selDivision"]."))) * (1+( select ppnt/100 from of_ppt_ppnt where division_id=".$params["selDivision"]."))) as consumoPPTPPNTKWH
        from of_datos_horarios odh
       inner join ".$GBT." ogb on ogb.anio = odh.anio and ogb.mes = odh.mes
       where ogb.id_oferta=".$ofertaId.";";
        $res=$this->db->query($query);  
        return true;
    }























    ///// de aqui para abajo, lo viejo (no me grites) ///////////////////////////////////////////////
    
    public function getInfoWorkCenter($idworkcenter) {

         $energy = $this->load->database('energy', TRUE);

         
         $verAdminWC = $idworkcenter["AdminWorkCenter"];
         //$verAdminWC = $idworkcenter["AdminWorkCenter"];

         if (count($verAdminWC)>0) {
            $energy->select("sta.cat_corp_subsidiary,sta.id_Ener_station,sta.Ener_station,sta.id_Ener_account_order,O.Ener_account_order ");
        $energy->from("Ener_station sta");
        $energy->join("Ener_account_order O", "sta.id_Ener_account_order = O.id_Ener_account_order");
        $energy->where_in("sta.cat_corp_subsidiary",  $verAdminWC);
        //$energy->where("sta.cat_corp_subsidiary",  $idworkcenter["WorkCenter"]);

        
        
        $infoWorkcenter = $energy->get();
         }

         else{

                if ($idworkcenter["WorkCenter"] == 1) {
                $energy->select("sta.cat_corp_subsidiary,sta.id_Ener_station,sta.Ener_station,sta.id_Ener_account_order,O.Ener_account_order ");
                $energy->from("Ener_station sta");
                $energy->join("Ener_account_order O", "sta.id_Ener_account_order = O.id_Ener_account_order");
                $infoWorkcenter = $energy->get();
                }
                else{
                $energy->select("sta.id_Ener_station,sta.Ener_station,sta.id_Ener_account_order,O.Ener_account_order ");
                $energy->from("Ener_station sta");
                $energy->join("Ener_account_order O", "sta.id_Ener_account_order = O.id_Ener_account_order");
                $energy->where("sta.cat_corp_subsidiary",  $idworkcenter["WorkCenter"]);
                
                $infoWorkcenter = $energy->get();

                }

    }

        //$this->logging->lfile('application/logs/logws/'.date("DmyHis").'daos.txt');

        //$this->logging->lwrite($energy->last_query());
        
        return $infoWorkcenter->result_array();
    }
    

    ///
    public function getInfoWorkCenterLic($idworkcenter) {

         $energy = $this->load->database('energy', TRUE);

         
         $verAdminWC = $idworkcenter["AdminWorkCenter"];
         //$verAdminWC = $idworkcenter["AdminWorkCenter"];

         if (count($verAdminWC)>0) {
            $energy->select("sta.cat_corp_subsidiary,sta.id_Ener_station,sta.Ener_station,sta.id_Ener_account_order,O.Ener_account_order ");
        $energy->from("Ener_station sta");
        $energy->join("Ener_account_order O", "sta.id_Ener_account_order = O.id_Ener_account_order");
        $energy->where_in("sta.cat_corp_subsidiary",  $verAdminWC);
        //$energy->where("sta.cat_corp_subsidiary",  $idworkcenter["WorkCenter"]);

        
        
        $infoWorkcenter = $energy->get();
         }

         else{

         if ($idworkcenter["WorkCenter"] == 1) {
        $energy->select("sta.cat_corp_subsidiary,sta.id_Ener_station,sta.Ener_station,sta.id_Ener_account_order,O.Ener_account_order ");
        $energy->from("Ener_station sta");
        $energy->join("Ener_account_order O", "sta.id_Ener_account_order = O.id_Ener_account_order");
        $energy->order_by("sta.id_Ener_station", "asc");
        $infoWorkcenter = $energy->get();
         }
        else{
        $energy->select("sta.cat_corp_subsidiary,sta.id_Ener_station,sta.Ener_station,sta.id_Ener_account_order,O.Ener_account_order ");
        $energy->from("Ener_station sta");
        $energy->join("Ener_account_order O", "sta.id_Ener_account_order = O.id_Ener_account_order");
        $energy->where("sta.cat_corp_subsidiary",  $idworkcenter["WorkCenter"]);
        
        $infoWorkcenter = $energy->get();

        }

    }

        //$this->logging->lfile('application/logs/logws/'.date("DmyHis").'daos.txt');

        //$this->logging->lwrite($energy->last_query());
        
        return $infoWorkcenter->result_array();
    }
    ///

    public function getInfoWorkCenterDam($idworkcenter) {

         $energy = $this->load->database('weather', TRUE);

         if ($idworkcenter["WorkCenter"] == 1) {
        $energy->select("id_weather_dam,weather_dam_name");
        $energy->from("weather_dam");
        $infoWorkcenter = $energy->get();
         }
        else{
        $energy->select("id_weather_dam,weather_dam_name");
        $energy->from("weather_dam");
        $energy->where("cat_corp_subsidiary",  $idworkcenter["WorkCenter"]);
        
        $infoWorkcenter = $energy->get();

        }
        
        return $infoWorkcenter->result_array();
    }

    //alejandro 
    public function getInfoWorkCenterDam2($idworkcenter) {

        $energy = $this->load->database('weather', TRUE);

        if ($idworkcenter["WorkCenter"] == 1) {
       /*$energy->select("id_weather_dam,weather_dam_name");
       $energy->from("weather_dam");
       $energy->where("id_weather_dam",9);
       $energy->orWhere("id_weather_dam",11);
       $infoWorkcenter = $energy->get();*/

            
            $infoWorkcenter = $energy->query("select id_weather_dam,weather_dam_name from weather_dam where id_weather_dam in (9,11)");



        }
       else{
       /*$energy->select("id_weather_dam,weather_dam_name");
       $energy->from("weather_dam");
       $energy->where("cat_corp_subsidiary",  $idworkcenter["WorkCenter"]);
       $energy->where("id_weather_dam",9);
       //$energy->orWhere("id_weather_dam = ",11);
       
       $infoWorkcenter = $energy->get();*/

       
            $infoWorkcenter = $energy->query("select id_weather_dam,weather_dam_name from weather_dam where id_weather_dam in (9,11) and cat_corp_subsidiary = ".$idworkcenter["WorkCenter"]." ");

       }
       
       return $infoWorkcenter->result_array();
   }
    
    
    public function getInfoStation($idworkcenter) {

         $energy = $this->load->database('energy', TRUE);


         $verAdminWC = $idworkcenter["AdminWorkCenter"];
         //$verAdminWC = $idworkcenter["AdminWorkCenter"];

         if (count($verAdminWC)>0) {

        $energy->select("`sta`.`cat_corp_subsidiary`,R.id_Ener_unit,R.Ener_rel_acronym,E.Ener_unit,R.id_Ener_rel_stationunit");
        $energy->from("Ener_station sta");
        $energy->join("Ener_account_order O", "sta.id_Ener_account_order = O.id_Ener_account_order");
        $energy->join("Ener_rel_stationunit R", "sta.id_Ener_station = R.id_Ener_station");
        $energy->join("Ener_unit E", "R.id_Ener_unit = E.id_Ener_unit");
        $energy->where_in("sta.cat_corp_subsidiary",  $verAdminWC);
        //$energy->where("sta.cat_corp_subsidiary",  $idworkcenter["WorkCenter"]);
        $stationValues = $energy->get();
         }

            else
            {
         if ($idworkcenter["WorkCenter"] == 1) {
        $energy->select("sta.cat_corp_subsidiary,R.id_Ener_unit,R.Ener_rel_acronym,E.Ener_unit,R.id_Ener_rel_stationunit");
        $energy->from("Ener_station sta");
        $energy->join("Ener_account_order O", "sta.id_Ener_account_order = O.id_Ener_account_order");
        $energy->join("Ener_rel_stationunit R", "sta.id_Ener_station = R.id_Ener_station");
        $energy->join("Ener_unit E", "R.id_Ener_unit = E.id_Ener_unit");
        
        $stationValues = $energy->get();
         }
        else{
        $energy->select("R.id_Ener_unit,R.Ener_rel_acronym,E.Ener_unit,R.id_Ener_rel_stationunit");
        $energy->from("Ener_station sta");
        $energy->join("Ener_account_order O", "sta.id_Ener_account_order = O.id_Ener_account_order");
        $energy->join("Ener_rel_stationunit R", "sta.id_Ener_station = R.id_Ener_station");
        $energy->join("Ener_unit E", "R.id_Ener_unit = E.id_Ener_unit");
        $energy->where("sta.cat_corp_subsidiary",  $idworkcenter["WorkCenter"]);
        
        $stationValues = $energy->get();
         }

        }
         
         // $this->logging->lfile('application/logs/logws/'.date("DmyHis").'daos.txt');

        //echo $energy->last_query();
        return $stationValues->result_array();
    }



    ///
    public function getInfoStationLic($idworkcenter) {

         $energy = $this->load->database('energy', TRUE);


         $verAdminWC = $idworkcenter["AdminWorkCenter"];
         //$verAdminWC = $idworkcenter["AdminWorkCenter"];

         if (count($verAdminWC)>0) {

        $energy->select("`sta`.`cat_corp_subsidiary`,R.id_Ener_unit,R.Ener_rel_acronym,E.Ener_unit,R.id_Ener_rel_stationunit,sta.id_Ener_station");
        $energy->from("Ener_station sta");
        $energy->join("Ener_account_order O", "sta.id_Ener_account_order = O.id_Ener_account_order");
        $energy->join("Ener_rel_stationunit R", "sta.id_Ener_station = R.id_Ener_station");
        $energy->join("Ener_unit E", "R.id_Ener_unit = E.id_Ener_unit");
        $energy->where_in("sta.cat_corp_subsidiary",  $verAdminWC);
        //$energy->where("sta.cat_corp_subsidiary",  $idworkcenter["WorkCenter"]);
        $stationValues = $energy->get();
         }

            else
            {
         if ($idworkcenter["WorkCenter"] == 1) {
        $energy->select("sta.cat_corp_subsidiary,R.id_Ener_unit,R.Ener_rel_acronym,E.Ener_unit,R.id_Ener_rel_stationunit,sta.id_Ener_station");
        $energy->from("Ener_station sta");
        $energy->join("Ener_account_order O", "sta.id_Ener_account_order = O.id_Ener_account_order");
        $energy->join("Ener_rel_stationunit R", "sta.id_Ener_station = R.id_Ener_station");
        $energy->join("Ener_unit E", "R.id_Ener_unit = E.id_Ener_unit");
        
        $stationValues = $energy->get();
         }
        else{
        $energy->select("sta.cat_corp_subsidiary,R.id_Ener_unit,R.Ener_rel_acronym,E.Ener_unit,R.id_Ener_rel_stationunit,sta.id_Ener_station");
        $energy->from("Ener_station sta");
        $energy->join("Ener_account_order O", "sta.id_Ener_account_order = O.id_Ener_account_order");
        $energy->join("Ener_rel_stationunit R", "sta.id_Ener_station = R.id_Ener_station");
        $energy->join("Ener_unit E", "R.id_Ener_unit = E.id_Ener_unit");
        $energy->where("sta.cat_corp_subsidiary",  $idworkcenter["WorkCenter"]);
        
        $stationValues = $energy->get();
         }

        }
         
         // $this->logging->lfile('application/logs/logws/'.date("DmyHis").'daos.txt');

        //$this->logging->lwrite($energy->last_query());
        return $stationValues->result_array();
    }
    ///

    public function postInfoData($idworkcenter,$datExcel,$totDatExcel,$fechainicio,$inputCentral,$inputOrden,$arrayrelunit,$editando) {

         $energy = $this->load->database('energy', TRUE);
        
            


        //$now = date('Y-m-d');
          $now = date('Y-m-d H:i:s');
            $dateMod = str_replace('/', '-', $fechainicio);
            $datenow = strtotime($dateMod);
            $datenowwithformat = date('Y-m-d H:i:s', $datenow);
        $energy->select("count(*)");
        $energy->from("Ener_ep_form");
        $energy->where("DATE(Ener_ep_form_start_date)", $datenowwithformat);
        $energy->where("id_Ener_station",  $inputCentral);
        //$energy->where("id_Ener_ep_user ",  $idworkcenter["employee_id"]);
        $ValuesGet = $energy->get();

        //$this->logging->lfile('application/logs/logws/'.date("DmyHis").'daos.txt');

        //$this->logging->lwrite($energy->last_query());

        foreach ($ValuesGet->result_array() as $row)
       
            if (($row["count(*)"]==0) || ($editando == 1)) {
       
           // $now = date('Y-m-d H:i:s');
            //$dateMod = str_replace('/', '-', $fechainicio);
            //$datenow = strtotime($dateMod);
            //$datenowwithformat = date('Y-m-d H:i:s', $datenow);
            
        $data = array(
            'Ener_ep_form_start_date' => $datenowwithformat,
            'id_Ener_station' => $inputCentral,
            'id_Ener_ep_user' => $idworkcenter["employee_id"],
            'Ener_ep_form_last_date_mod' =>  $now
                    );
         $energy->insert('Ener_ep_form',$data);
         $lastinserts = $energy->insert_id();
        

       


       for ($unidadesc=0; $unidadesc <=$totDatExcel ; $unidadesc++) { 
           
           for ($valorhora=1; $valorhora <=count($datExcel[$unidadesc]) ; $valorhora++) { 


            $tamanovalor = $datExcel[$unidadesc][strval($valorhora)];   
            if (strlen($tamanovalor)==0) {
                 $tamanovalor = 0;

            }

            if ($tamanovalor == "-") {
                $tamanovalor = 0;
            }

               $datas = array(
            'id_Ener_ep_form' => $lastinserts,
            //'id_Ener_rel_stationunit' => $arrayrelunit[$unidadesc],
            'id_Ener_rel_stationunit' => $unidadesc + 1,
            'Ener_ep_offer_sale_hour' => $valorhora,
            'Ener_ep_offer_sale_value' =>  $tamanovalor,
            'Ener_ep_offer_sale_creationdate' => $datenowwithformat 
                    );
         $energy->insert('Ener_ep_offer_sale',$datas);
           }

           if ($valorhora == 25) {
               $datas = array(
            'id_Ener_ep_form' => $lastinserts,
            'id_Ener_rel_stationunit' => $unidadesc + 1,
            //'id_Ener_rel_stationunit' => $arrayrelunit[$unidadesc],
            'Ener_ep_offer_sale_hour' => 25,
            'Ener_ep_offer_sale_value' =>  0,
            'Ener_ep_offer_sale_creationdate' => $datenowwithformat
                    );
         $energy->insert('Ener_ep_offer_sale',$datas);
           }
       }

        
        


        return $lastinserts;


        }
        else{

            return 0;

        }
    }


    /// alejandro castro
    public function postInfoDataTank($idworkcenter,$datExcel,$totDatExcel,$fechainicio,$inputCentral,$inputOrden,$arrayrelunit,$editando) {


        $ret=0;

        $weather = $this->load->database('weather', TRUE);
        $date      = $fechainicio;
        $damID     = $inputCentral;
        $now = date('Y-m-d H:i:s');
        
        $fateQuery=str_replace('/', '-', $date);
        $fateQuerym = strtotime($fateQuery);
        $fateQuerymm = date('Y-m-d', $fateQuerym);

        $weather->select("*", FALSE);
        $result = $weather->get_where("weather_min_form", "weather_min_form_date = '$fateQuerymm' and id_weather_dam = $damID")->result_array();
        
        if (count($result)==0 or ($idworkcenter["employee_id"] == 9 or $idworkcenter["employee_id"]==14)) {
            $ret=1;
            $hr=1;
            foreach($datExcel[0] as $val){
                $dateMod='';
                if ($hr == 24 || $hr==25) {
                    $dateMod = str_replace('/', '-', $date.' 00:00:00');
                }else{
                    $dateMod = str_replace('/', '-', $date.' '.$hr.':00:00');
                }
                
                $datenow = strtotime($dateMod);
                $datenowwithformat = date('Y-m-d H:i:s', $datenow);
                $datas = array(
                    'id_weather_dam' => $damID,
                    'id_weather_min_form_user' => $idworkcenter["employee_id"],
                    'weather_min_form_date' => $datenowwithformat,
                    'weather_min_form_value' => $val,
                    'weather_min_form_month_value' =>  0,
                    'weather_min_form_creado' => $now
                            );
                
                 print_r($weather->insert('weather_min_form',$datas));
                 $hr=$hr+1;
            }
            
        }


        return $ret; 
   }    




///
    public function postInfoDataValida($idworkcenter,$fechainicio,$inputCentral,$inputOrden) {

         $energy = $this->load->database('energy', TRUE);
        
            


        //$now = date('Y-m-d');
        $now = date('Y-m-d H:i:s');
        $dateMod = str_replace('/', '-', $fechainicio);
        $datenow = strtotime($dateMod);
        $datenowwithformat = date('Y-m-d H:i:s', $datenow);
        $energy->select("count(*)");
        $energy->from("Ener_ep_form");
        $energy->where("DATE(Ener_ep_form_start_date)", $datenowwithformat);
        $energy->where("id_Ener_station",  $inputCentral);
        //$energy->where("id_Ener_ep_user ",  $idworkcenter["employee_id"]);
        $ValuesGet = $energy->get();

        //$this->logging->lfile('application/logs/logws/'.date("DmyHis").'daos.txt');

        //$this->logging->lwrite($energy->last_query());

        foreach ($ValuesGet->result_array() as $row)

       return $row["count(*)"];
    }
///  


///alejandro castro
public function postInfoDataValidaDam($idworkcenter,$fechainicio,$inputCentral,$inputOrden) {

    $energy = $this->load->database('weather', TRUE);
   
       


   //$now = date('Y-m-d');
   $now = date('Y-m-d H:i:s');
   $dateMod = str_replace('/', '-', $fechainicio);
   $datenow = strtotime($dateMod);
   $datenowwithformat = date('Y-m-d H:i:s', $datenow);
   $energy->select("count(*)");
   $energy->from("weather_min_form");
   $energy->where("DATE(weather_min_form_date)", $datenowwithformat);
   $energy->where("id_weather_dam",  $inputCentral);
   //$energy->where("id_Ener_ep_user ",  $idworkcenter["employee_id"]);
   $ValuesGet = $energy->get();

   //$this->logging->lfile('application/logs/logws/'.date("DmyHis").'daos.txt');

   //$this->logging->lwrite($energy->last_query());

   foreach ($ValuesGet->result_array() as $row)

  return $row["count(*)"];
}



public function postInfoUpdateData($idworkcenter,$datExcel,$totDatExcel,$fechainicio,$inputCentral,$inputOrden,$arrayrelunit,$resultdataid) {

        
         

          $energy = $this->load->database('energy', TRUE);
        
        $queryejec = "UPDATE Ener_ep_offer_sale SET Ener_ep_offer_sale_value = CASE";
       
            
        $tothoras = 0;
        $queryvalu = "";
        $queryid ="";

        

        //$this->logging->lwrite(json_encode($datExcel));
        //$this->logging->lwrite(json_encode($resultdata));

       for ($unidadesc=0; $unidadesc <=$totDatExcel ; $unidadesc++) { 

         
         
        
          
           for ($valorhora=1; $valorhora <=count($datExcel[$unidadesc]) ; $valorhora++) { 
              
              $tamanovalor = $datExcel[$unidadesc][strval($valorhora)]; 
              if ($tamanovalor == "-") {
                $tamanovalor = 0;
            }
              if (strlen($tamanovalor)==0) {
              //$energy->set('Ener_ep_offer_sale_value',0,false);
              //$queryvalu = $queryvalu.'("0",'.$resultdata[$tothoras]["id_Ener_ep_offer_sale"].'),';

                $queryvalu =$queryvalu. ' WHEN id_Ener_ep_offer_sale ='.$resultdataid[$tothoras].' THEN "0"';
                $queryid = $queryid.$resultdataid[$tothoras].','; 
              }
              else{
               //$energy->set('Ener_ep_offer_sale_value',$datExcel[$unidadesc][strval($valorhora)],false);

              // $queryvalu = $queryvalu.'("'.$datExcel[$unidadesc][strval($valorhora)].'","'.$resultdata[$tothoras]["id_Ener_ep_offer_sale"].'"),';
                $queryvalu = $queryvalu.' WHEN id_Ener_ep_offer_sale ='.$resultdataid[$tothoras].' THEN '.$tamanovalor.'';
                $queryid = $queryid.$resultdataid[$tothoras].',';
           }
               //$energy ->where('id_Ener_ep_offer_sale', $resultdata[$tothoras]["id_Ener_ep_offer_sale"]);
               //$energy ->update('Ener_ep_offer_sale');

            $tothoras++;
           
           
           }

           $queryid = substr($queryid, 0, -1);
        
        $queryejec =  $queryejec.$queryvalu." END "." WHERE id_Ener_ep_offer_sale  in (".$queryid.")";

//        $this->logging->lwrite($queryejec);

        $querye = $energy->query($queryejec);
        $queryvalu ="";
        $queryejec = "UPDATE Ener_ep_offer_sale SET Ener_ep_offer_sale_value = CASE";
        $queryid ="";
       }

       
        
    
       

        return  TRUE;
    }


    public function postInfoUpdateDataSorder($idworkcenter,$datExcel,$totDatExcel,$fechainicio,$inputCentral,$inputOrden,$arrayrelunit,$resultdata) {

          $energy = $this->load->database('energy', TRUE);
        
            
            
        $tothoras = 0;

       for ($unidadesc=0; $unidadesc <=$totDatExcel ; $unidadesc++) { 
           
           for ($valorhora=1; $valorhora <=count($datExcel[$unidadesc]) ; $valorhora++) { 
            $tamanovalor = $datExcel[$unidadesc][strval($valorhora)]; 

            if ($tamanovalor == "-") {
                $tamanovalor = 0;
            }  
            if (strlen($tamanovalor)==0) {
              $energy->set('Ener_ov_offer_sale_value',0,false);
              }
              else{
               $energy->set('Ener_ov_offer_sale_value',$datExcel[$unidadesc][strval($valorhora)],false);
           }
               
               $energy ->where('id_Ener_ov_offer_sale', $resultdata[$tothoras]["id_Ener_ov_offer_sale"]);
               $energy ->update('Ener_ov_offer_sale');

            $tothoras++;
           
           
           }

           
       }

        
        echo $datExcel;
       

        return TRUE;
    }





public function getInfoDatas($idworkcenter,$fechainicio,$inputCentral) {

        

         $energy = $this->load->database('energy', TRUE);

         $dateMod = str_replace('/', '-', $fechainicio);
         $time = strtotime($dateMod);

         $newformat = date('Y-m-d',$time);
        
        $energy->select("EEO.id_Ener_ep_offer_sale,EEF.id_Ener_ep_form,EEO.id_Ener_rel_stationunit,ERS.Ener_rel_acronym,EU.Ener_unit,EEO.Ener_ep_offer_sale_hour, EEO.Ener_ep_offer_sale_value");
        
        $energy->join("Ener_ep_offer_sale EEO", "EEF.id_Ener_ep_form = EEO.id_Ener_ep_form");
        $energy->join("Ener_rel_stationunit ERS", "ERS.id_Ener_rel_stationunit = EEO.id_Ener_rel_stationunit");
        $energy->join("Ener_unit EU", "EU.id_Ener_unit = ERS.id_Ener_unit");
        
        //$energy->where("id_Ener_ep_user ",  $idworkcenter["employee_id"]);

        $energy->order_by("EEO.id_Ener_rel_stationunit","asc");
        $energy->order_by("EEO.Ener_ep_offer_sale_hour","asc");

        
        

        $ValuesGet = $energy->get_where("Ener_ep_form EEF", "EEF.id_Ener_ep_form = (Select max(id_Ener_ep_form) From Ener_ep_form where DATE(Ener_ep_form_start_date) = '$newformat' and `id_Ener_station` = '$inputCentral')");

        //$this->logging->lfile('application/logs/logws/'.date("DmyHis").'daos.txt');

        //$this->logging->lwrite($energy->last_query());
         
        
        return $ValuesGet->result_array();
 
        


      
}
/// alejandro castro
public function getInfoDatasTank($idworkcenter,$fechainicio,$inputCentral) {

    $weather = $this->load->database('weather', TRUE);
    $now = date('Y-m-d H:i:s');
    $dateMod = str_replace('/', '-', $fechainicio);
    $datenow = strtotime($dateMod);
    $datenowwithformat = date('Y-m-d H:i:s', $datenow);
    $weather->select("*");
    $weather->from("weather_min_form");
    $weather->where("DATE(weather_min_form_date)", $datenowwithformat);
    $weather->where("id_weather_dam",  $inputCentral);
    $ValuesGet = $weather->get();
    return $ValuesGet->result_array();
}



    public function getInfoDatasSorder($idworkcenter,$fechainicio,$inputCentral) {

         $energy = $this->load->database('energy', TRUE);

         $dateMod = str_replace('/', '-', $fechainicio);
         $time = strtotime($dateMod);

         $newformat = date('Y-m-d',$time);
         $empadoid = $idworkcenter["employee_id"];
        
        $energy->select("EEO.id_Ener_ov_offer_sale,EEF.id_Ener_ov_form,EEO.id_Ener_rel_stationunit,ERS.Ener_rel_acronym,EU.Ener_unit,EEO.Ener_ov_offer_sale_hour, EEO.Ener_ov_offer_sale_value");
        $energy->from("Ener_ov_form EEF");
        $energy->join("Ener_ov_offer_sale EEO", "EEF.id_Ener_ov_form = EEO.id_Ener_ov_form");
        $energy->join("Ener_rel_stationunit ERS", "ERS.id_Ener_rel_stationunit = EEO.id_Ener_rel_stationunit");
        $energy->join("Ener_unit EU", "EU.id_Ener_unit = ERS.id_Ener_unit");

         $energy->where("EEF.id_Ener_ov_form = (SELECT MAX(EEF.id_Ener_ov_form) FROM Ener_ov_form EEF WHERE DATE(EEF.Ener_ov_form_start_date) <= '$newformat' AND DATE(EEF.Ener_ov_form_end_date) >= '$newformat' AND EEF.id_Ener_station = $inputCentral)");
        $energy->order_by("EEO.id_Ener_rel_stationunit","asc");
        $energy->order_by("EEO.Ener_ov_offer_sale_hour","asc");
        
       
       

        
    
        

        $ValuesGet = $energy->get();

        

        //$this->logging->lfile('application/logs/logws/'.date("DmyHis").'oas.txt');

//      $this->logging->lwrite($energy->last_query());
        
        return $ValuesGet->result_array();
 
        


      
    }


    public function getInfoDataseProduced($idworkcenter,$inputCentral) {

         $energy = $this->load->database('energy', TRUE);
         $now = date('Y-m-d');

         
        
        $energy->select("*");
        $energy->from("Ener_ep_form");
        $energy->where("DATE(Ener_ep_form_last_date_mod)", $now);
        $energy->where("id_Ener_station",  $inputCentral);
        $energy->where("id_Ener_ep_user ",  $idworkcenter["employee_id"]);
        $ValuesGet = $energy->get();

        
        return $ValuesGet->result_array();
 
        


      
    }


    

public function postInfoDataSorder($params) {

    $now          = $this->getCurrentDate();
    $dateStart    = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $params["fechainicio"])));
    $dateEnd      = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $params["fechafin"])));
    $insertValues = array();

    $data = array(
       'Ener_ov_form_start_date'    => $dateStart,
       'Ener_ov_form_end_date'      => $dateEnd,
       'id_Ener_station'            => $params["inputCentral"],
       'id_Ener_ov_user'            => $this->session->userdata("userInfo")["employee_id"],
       'Ener_ov_form_last_date_mod' => $now);
    
    $lastInserts = $this->add('Ener_ov_form',$data, FALSE, "energy");
    
    foreach($params["headerExcel"] as $kHead => $unitI){
        
        $unitId       = explode("-", $unitI);
        $unitValues   = $params["datExcel"][$kHead];
        
        if(count($unitValues) == 24){$unitValues[25] = 0;}
        
        foreach($unitValues as $hour => $val){
            $valueOffer     = (strlen($val) == 0 || $val == "-") ? 0 : floatval($val);
            $insertValues[] = array(
                'id_Ener_ov_form'                 => $lastInserts,
                'id_Ener_rel_stationunit'         => intval(str_replace("U","0",$unitId[count($unitId) - 1])),
                'Ener_ov_offer_sale_hour'         => $hour,
                'Ener_ov_offer_sale_value'        => $valueOffer,
                'Ener_ov_offer_sale_creationdate' => $now
            );
        }
    }
    
    $this->addBatch('Ener_ov_offer_sale',$insertValues, FALSE, "energy");
    
    return 0;
}



////
 public function postInfoDataElicenses($idworkcenter,$dataLicencias) {

         $energy = $this->load->database('energy', TRUE);
        
           $rangorepetido=0; 

         $jObjLic = json_decode($dataLicencias);

         if (count($jObjLic->valoreslic) == 0) 
         {
              return array(400, 0);
         }

         else
         {
            
            
            for ($recorre=0; $recorre < count($jObjLic->valoreslic); $recorre++) 
            { 
              
           $now = date('Y-m-d H:i:s');
                        $dateMod = str_replace('/', '-', $jObjLic->valoreslic[$recorre]->fechainicio);
                        $datenow = strtotime($dateMod);
                        $datenowwithformat = date('Y-m-d H:i:s', $datenow);
                        $dateMod2 = str_replace('/', '-', $jObjLic->valoreslic[$recorre]->fechafinal);
                        $datenow2 = strtotime($dateMod2);
                        $datenowwithformat2 = date('Y-m-d H:i:s', $datenow2);


                $where_date = "((date_start BETWEEN '".$datenowwithformat."' AND '".$datenowwithformat2."') OR (date_end BETWEEN '".$datenowwithformat."' AND '".$datenowwithformat2."'))";
                $energy->select("count(*)");
                $energy->from("Ener_licenses_unit");
                $energy->where($where_date);
                $energy->where("station_id", $jObjLic->valoreslic[$recorre]->estacion);
                $energy->where("unit_id",  $jObjLic->valoreslic[$recorre]->unidad);
                $energy->where("active",  "1");
                $ValuesGet = $energy->get();

               // $this->logging->lfile('application/logs/logws/'.date("DmyHis").'nomas.txt');

                //$this->logging->lwrite($energy->last_query());


                $now = date('Y-m-d H:i:s');
                        $dateMod = str_replace('/', '-', $jObjLic->valoreslic[$recorre]->fechainicio);
                        $datenow = strtotime($dateMod);
                        $datenowwithformat = date('Y-m-d H:i:s', $datenow);
                        $dateMod2 = str_replace('/', '-', $jObjLic->valoreslic[$recorre]->fechafinal);
                        $datenow2 = strtotime($dateMod2);
                        $datenowwithformat2 = date('Y-m-d H:i:s', $datenow2);

                 foreach ($ValuesGet->result_array() as $row)


               
                    if ($row["count(*)"]==0) 
                    {

                        

                        $datas = array(
                    'station_id' => $jObjLic->valoreslic[$recorre]->estacion,
                    'unit_id' => $jObjLic->valoreslic[$recorre]->unidad,
                    'date_start' => $datenowwithformat,
                    'date_end' =>   $datenowwithformat2,
                    'num_license' => $jObjLic->valoreslic[$recorre]->licencia,
                    'active' => 1,
                    'user_creation' => $idworkcenter["employee_id"],
                    'date_creation' => $now,
                    'user_modification' => $idworkcenter["employee_id"], 
                    'date_modification' => $now, 
                    'observations' => "" 
                            );
                 $energy->insert('Ener_licenses_unit',$datas);

                 

                    }

                    else
                    {
                        $rangorepetido++;
                        $jObjLic->valoreslic[$recorre]->procesado = "1";
                       //$energy->set('date_start',$datenowwithformat);
                       //$energy->set('date_end',$datenowwithformat2);
                       //$energy->set('num_license',$jObjLic->valoreslic[$recorre]->licencia);
                       //$energy->set('active',1);
                       //$energy->set('user_modification',$idworkcenter["employee_id"]);
                       //$energy->set('date_modification',$now);
                       //$energy->where("station_id", $jObjLic->valoreslic[$recorre]->estacion);
                       //$energy->where("unit_id",  $jObjLic->valoreslic[$recorre]->unidad);
                       //$energy ->update('Ener_licenses_unit');

                        //$this->logging->lfile('application/logs/logws/'.date("DmyHis").'DAos.txt');

                        //$this->logging->lwrite($energy->last_query());
                        
                    }


             }
        //$energy->select("CONCAT((ERS.Ener_rel_acronym),(EU.Ener_unit)) as unidades,DATE_FORMAT(ELU.date_start,'%d/%m/%Y') as fechainicio,DATE_FORMAT(ELU.date_end,'%d/%m/%Y') as fechafin,ELU.num_license", FALSE);
        //$energy->from("Ener_licenses_unit ELU");
        //$energy->join("Ener_unit EU", "ELU.unit_id = EU.id_Ener_unit");
        //$energy->join("Ener_station ES", "ELU.station_id = ES.cat_corp_subsidiary");
        //$energy->join("Ener_rel_stationunit ERS", "ERS.id_Ener_station = ES.id_Ener_station AND ERS.id_Ener_unit = ELU.unit_id ");
        //$energy->where_in("ELU.active", 1);
        //$energy->order_by("ERS.Ener_rel_acronym", "asc");
        //$infoWorkcenter = $energy->get();
         
        //$this->logging->lfile('application/logs/logws/'.date("DmyHis").'logos.txt');

        //$this->logging->lwrite($energy->last_query());
        //return $infoWorkcenter->result_array();
             
            return array($rangorepetido, $jObjLic);

         }

        
        //return  $jObjLic->valoreslic[0]->estacion;
         //return count($jObjLic->valoreslic);
    }


    public function postActualInfoDataElicenses($idworkcenter,$idunidadactualiar,$actualizafei,$actualizafefin,$estacionval,$unidadval) {

         $energy = $this->load->database('energy', TRUE);
        
            

/////
                        $now = date('Y-m-d H:i:s');
                        $dateMod = str_replace('/', '-', $actualizafei);
                        $datenow = strtotime($dateMod);
                        $datenowwithformat = date('Y-m-d H:i:s', $datenow);
                        $dateMod2 = str_replace('/', '-', $actualizafefin);
                        $datenow2 = strtotime($dateMod2);
                        $datenowwithformat2 = date('Y-m-d H:i:s', $datenow2);


                $where_date = "((date_start BETWEEN '".$datenowwithformat."' AND '".$datenowwithformat2."') OR (date_end BETWEEN '".$datenowwithformat."' AND '".$datenowwithformat2."'))";
                $energy->select("count(*)");
                $energy->from("Ener_licenses_unit");
                $energy->where($where_date);
                $energy->where("station_id", $estacionval);
                $energy->where("unit_id",  $unidadval);
                $energy->where("active",  "1");
                
                $ValuesGet = $energy->get();

               $this->logging->lfile('application/logs/logws/'.date("DmyHis").'nomas.txt');

                $this->logging->lwrite($energy->last_query());

                 foreach ($ValuesGet->result_array() as $row)

                    $totalcount = $row["count(*)"];
               
                    if ($totalcount == 0) 
                    {

/////


                        
                        
                       $energy->set('date_start',$datenowwithformat);
                       $energy->set('date_end',$datenowwithformat2);
                       $energy->set('user_modification',$idworkcenter["employee_id"]);
                       $energy->set('date_modification',$now);
                       $energy->where("id_Ener_licenses_unit", $idunidadactualiar);
                       $energy ->update('Ener_licenses_unit');

                       // $this->logging->lfile('application/logs/logws/'.date("DmyHis").'DAos.txt');

                        //$this->logging->lwrite($energy->last_query());
                        
                    return 1;

                }
                else
                {
                    /////
                    $now = date('Y-m-d H:i:s');
                        $dateMod = str_replace('/', '-', $actualizafei);
                        $datenow = strtotime($dateMod);
                        $datenowwithformat = date('Y-m-d H:i:s', $datenow);
                        $dateMod2 = str_replace('/', '-', $actualizafefin);
                        $datenow2 = strtotime($dateMod2);
                        $datenowwithformat2 = date('Y-m-d H:i:s', $datenow2);


                $where_date = "((date_start BETWEEN '".$datenowwithformat."' AND '".$datenowwithformat2."') OR (date_end BETWEEN '".$datenowwithformat."' AND '".$datenowwithformat2."'))";
                $energy->select("count(*)");
                $energy->from("Ener_licenses_unit");
                $energy->where($where_date);
                $energy->where("id_Ener_licenses_unit", $idunidadactualiar);
                
                
                $ValuesGet = $energy->get();

                

                 foreach ($ValuesGet->result_array() as $row)
                    ////
                    if ($totalcount == $row["count(*)"]) 
                    {
                        $energy->set('date_start',$datenowwithformat);
                       $energy->set('date_end',$datenowwithformat2);
                       $energy->set('user_modification',$idworkcenter["employee_id"]);
                       $energy->set('date_modification',$now);
                       $energy->where("id_Ener_licenses_unit", $idunidadactualiar);
                       $energy ->update('Ener_licenses_unit');

                       return 1;
                    }
                    else
                    {
                        return 0;
                    }

                }
             

        
        //return  $jObjLic->valoreslic[0]->estacion;
         //return count($jObjLic->valoreslic);
    }

    public function getInfoDataElicenses($idworkcenter) 
    {
        $energy = $this->load->database('energy', TRUE);
        $energy->select("CONCAT((ERS.Ener_rel_acronym),(EU.Ener_unit)) as unidades,DATE_FORMAT(ELU.date_start,'%d/%m/%Y %H:%i') as fechainicio,DATE_FORMAT(ELU.date_end,'%d/%m/%Y %H:%i') as fechafin,ELU.num_license", FALSE);
        $energy->from("Ener_licenses_unit ELU");
        $energy->join("Ener_unit EU", "ELU.unit_id = EU.id_Ener_unit");
        $energy->join("Ener_station ES", "ELU.station_id = ES.cat_corp_subsidiary");
        $energy->join("Ener_rel_stationunit ERS", "ERS.id_Ener_station = ES.id_Ener_station AND ERS.id_Ener_unit = ELU.unit_id ");
        $energy->where_in("ELU.active", 1);
        $energy->order_by("ERS.Ener_rel_acronym", "asc");
        $infoWorkcenter = $energy->get();
         
        $this->logging->lfile('application/logs/logws/'.date("DmyHis").'logos.txt');

        $this->logging->lwrite($energy->last_query());
        return $infoWorkcenter->result_array();
    }

    public function getInfoDataElicensesopciones($idworkcenter,$buscarpor,$inputCentralval,$inputUnidadesval,$fechainicioval,$fechafinval,$optradioval,$numlicinputval) 
    {
        

        $now = date('Y-m-d H:i:s');
                        $dateMod = str_replace('/', '-', $fechainicioval);
                        $datenow = strtotime($dateMod);
                        $datenowwithformat = date('Y-m-d H:i:s', $datenow);
                        $dateMod2 = str_replace('/', '-', $fechafinval);
                        $datenow2 = strtotime($dateMod2);
                        $datenowwithformat2 = date('Y-m-d H:i:s', $datenow2);



        $energy = $this->load->database('energy', TRUE);
        $energy->select("ELU.id_Ener_licenses_unit,CONCAT((ERS.Ener_rel_acronym),(EU.Ener_unit)) as unidades,DATE_FORMAT(ELU.date_start,'%d/%m/%Y %H:%i') as fechainicio,DATE_FORMAT(ELU.date_end,'%d/%m/%Y %H:%i') as fechafin,ELU.num_license,ELU.active,ELU.station_id,ELU.unit_id", FALSE);
        $energy->from("Ener_licenses_unit ELU");
        $energy->join("Ener_unit EU", "ELU.unit_id = EU.id_Ener_unit");
        $energy->join("Ener_station ES", "ELU.station_id = ES.id_Ener_station");
        $energy->join("Ener_rel_stationunit ERS", "ERS.id_Ener_station = ES.id_Ener_station AND ERS.id_Ener_unit = ELU.unit_id ");
        
        if ($buscarpor == 0) 
        {
            
        
        $energy->where_in("ELU.station_id", $inputCentralval);
            
        if ($inputUnidadesval!=0) {
        $energy->where_in("ELU.unit_id", $inputUnidadesval);
        }
        $energy->where("DATE(ELU.date_start) >=", $datenowwithformat);
        $energy->where("DATE(ELU.date_start) <=", $datenowwithformat2);
        $energy->where("DATE(ELU.date_end) >=", $datenowwithformat);
        $energy->where("DATE(ELU.date_end) <=", $datenowwithformat2);
        if ($optradioval!=2) {
        $energy->where_in("ELU.active", $optradioval);
        }

        }
        else
        {
         $energy->where("ELU.num_license", $numlicinputval);  
        }


        $energy->order_by("ERS.Ener_rel_acronym", "asc");
        $infoWorkcenter = $energy->get();
         
       
        return $infoWorkcenter->result_array();
    }



    public function getInfoDataElicensesopcionesTodas($idworkcenter,$buscarpor) 
    {
        

       $jsonunidades = json_decode($buscarpor);



        $energy = $this->load->database('energy', TRUE);
        $energy->select("ELU.id_Ener_licenses_unit,CONCAT((ERS.Ener_rel_acronym),(EU.Ener_unit)) as unidades,DATE_FORMAT(ELU.date_start,'%d/%m/%Y %H:%i') as fechainicio,DATE_FORMAT(ELU.date_end,'%d/%m/%Y %H:%i') as fechafin,ELU.num_license,ELU.active,ELU.station_id,ELU.unit_id", FALSE);
        $energy->from("Ener_licenses_unit ELU");
        $energy->join("Ener_unit EU", "ELU.unit_id = EU.id_Ener_unit");
        $energy->join("Ener_station ES", "ELU.station_id = ES.id_Ener_station");
        $energy->join("Ener_rel_stationunit ERS", "ERS.id_Ener_station = ES.id_Ener_station AND ERS.id_Ener_unit = ELU.unit_id ");
        for ($recorre=0; $recorre < count($jsonunidades); $recorre++) { 

            if ($recorre == 0) 
            {
           $energy->where("ELU.station_id", $jsonunidades[$recorre]->id_Ener_station);
           //$energy->where("ELU.unit_id", $jsonunidades[$recorre]->id_Ener_station);
            }

           $energy->or_where("ELU.station_id", $jsonunidades[$recorre]->id_Ener_station);
           //$energy->where("ELU.unit_id", $jsonunidades[$recorre]->id_Ener_station);

        }

        $energy->where_in("ELU.active", 1);
        $energy->order_by("ERS.Ener_rel_acronym", "asc");
        $infoWorkcenter = $energy->get();
         
        $this->logging->lfile('application/logs/logws/'.date("DmyHis").'Today.txt');

        $this->logging->lwrite($energy->last_query());
        return $infoWorkcenter->result_array();  
       
        
    }

////

public function postInfoDataWturbine($idworkcenter,$fechainicio,$inputCentral,$inputValor,$inputValorMes) {

         $energy = $this->load->database('weather', TRUE);
        
            $now = date('Y-m-d H:i:s');

            $dateMod = str_replace('/', '-', $fechainicio);
            $datenow = strtotime($dateMod);
            $datenowwithformat = date('Y-m-d H:i:s', $datenow);
            
            
        $data = array(
            
            
            'id_weather_dam' => $inputCentral,
            'id_weather_min_form_user' => $idworkcenter["employee_id"],
            'weather_min_form_date' => $datenowwithformat,
            'weather_min_form_value' =>  $inputValor,
            'weather_min_form_month_value' =>  $inputValorMes,
            'weather_min_form_creado' =>  $now
                    );
         $energy->insert('weather_min_form',$data);
         $lastinserts = $energy->insert_id();
        

       


        return $lastinserts;
    }


    public function postInfoDataWturbineupdate($idworkcenter,$fechainicio,$inputCentral,$inputValor,$inputValorMes) {

         $energy = $this->load->database('weather', TRUE);
        
            $now = date('Y-m-d');

            $dateMod = str_replace('/', '-', $fechainicio);
            $datenow = strtotime($dateMod);
            $datenowwithformat = date('Y-m-d', $datenow);
            


            $energy->set('weather_min_form_value',$inputValor,false);
            $energy->set('weather_min_form_month_value',$inputValorMes,false);
               $energy->where("id_weather_dam", $inputCentral);
               $energy->where("DATE(weather_min_form_date)", $datenowwithformat); 
               $energy->where("id_weather_min_form_user", $idworkcenter["employee_id"]);
               $energy ->update('weather_min_form');

            
        
        

       


        return 1;
    }



    public function getInfoDataWturbine($idworkcenter,$fechainicio,$inputCentral) {

         $energy = $this->load->database('weather', TRUE);
        
            $now = date('Y-m-d');

            $dateMod = str_replace('/', '-', $fechainicio);
            $datenow = strtotime($dateMod);
            $datenowwithformat = date('Y-m-d', $datenow);
            
            
        

       $infoWorkcenter = $energy->query("SELECT weather_min_form_value,weather_min_form_month_value, CASE WHEN DATE(weather_min_form_date)!= DATE(CURDATE()) THEN IF (MONTH(weather_min_form_date) = MONTH(CURDATE()),1,0) WHEN MONTH(weather_min_form_date) = MONTH(CURDATE()) THEN 1 ELSE 0 END AS weather_min_form_date FROM (`weather_min_form`) WHERE `id_weather_dam` = '".$inputCentral."' AND DATE(weather_min_form_date) = '".$datenowwithformat."' AND `id_weather_min_form_user` = '".$idworkcenter["employee_id"]."'");
        
        

       // $this->logging->lfile('application/logs/logws/'.date("DmyHis").'Today.txt');

        //$this->logging->lwrite($energy->last_query());

        $row = $infoWorkcenter->row(); 
        $resulRow = -1;

        if (count($infoWorkcenter->result_array())!=0) {

            $resultFecha =  $row->weather_min_form_date;  

            if ($resultFecha == 0) {
                $valordelmes = $row->weather_min_form_month_value;
            }

            else
            {
              $valordelmes = $row->weather_min_form_month_value;
            }

             


            $resulRow = [0,$row->weather_min_form_value,$valordelmes];


        }
        else{

            $infoWorkcenterMonth = $energy->query("SELECT weather_min_form_date AS ultima ,weather_min_form_month_value, CASE WHEN DATE( MAX(weather_min_form_date))!= DATE(CURDATE()) THEN IF (MONTH( MAX(weather_min_form_date)) = MONTH(CURDATE()),1,0) WHEN MONTH( MAX(weather_min_form_date)) = MONTH(CURDATE()) THEN 1 ELSE 0 END AS tipofecha  FROM (`weather_min_form`) WHERE id_weather_min_form = (SELECT MAX(id_weather_min_form) FROM (`weather_min_form`) WHERE `id_weather_dam` = '".$inputCentral."' AND `id_weather_min_form_user` = '".$idworkcenter["employee_id"]."'
)");

             $row = $infoWorkcenterMonth->row(); 
        //$this->logging->lfile('application/logs/logws/'.date("DmyHis").'Today.txt');

        //$this->logging->lwrite($energy->last_query());

             $resultFechaM =  $row->tipofecha;  

              if ($resultFechaM == 0) {
                $valordelmes = 0.0;
            }

            else
            {
              $valordelmes = $row->weather_min_form_month_value;
            }


             $resulRow = [1,$valordelmes];
        }

        return $resulRow;
        
        
        
    }

    public function getInfoDatesWturbine($idworkcenter,$inputCentral) {

         $energy = $this->load->database('energy', TRUE);
        
            
            
            
        $energy->select_max("Ener_ov_form_end_date");
        $energy->from("Ener_ov_form");
        $energy->where("id_Ener_station", $inputCentral);
        //$energy->where("id_Ener_ov_user", $idworkcenter["employee_id"]);

        $infoWorkcenter = $energy->get();

        $row = $infoWorkcenter->row(); 
        $resulRow = -1;

        if (strlen($row->Ener_ov_form_end_date)>=10) {
            $resulRow = $row->Ener_ov_form_end_date;
            $resulRow = date('d/m/Y', strtotime($resulRow . ' +1 day'));

        }
        else{

             $resulRow = -1;
        }

        return $resulRow;
        
        
        
    }




    
}