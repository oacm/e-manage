<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FileManager
 *
 * @author oscar.f.medellin
 */
class FileManager {
    
    private $file;
    private $fileUri;
    private $path;
    private $name;
    private $extension;
    private $size;
    private $typeFile;
    private $openMode;
    
    public function __construct($fileUri, $openMode = "r", $openFile = TRUE){
        
        if(is_array($fileUri)){
            $openFile = isset($fileUri["openFile"]) ? $fileUri["openFile"] : TRUE;
            $openMode = isset($fileUri["openMode"]) ? $fileUri["openMode"] : "r";
            $fileUri  = $fileUri["fileUri"];
        }
        
        $firstDiagonal   = !(strrpos($fileUri, "\\", -1) === FALSE) ? strrpos($fileUri, "\\", -1) : strrpos($fileUri, "/", -1);
        
        $this->path      = substr($fileUri, 0, $firstDiagonal == 0 ? 0 : ++$firstDiagonal);
        $this->extension = substr($fileUri, strrpos($fileUri, ".", -1) + 1);
        $this->name      = substr($fileUri, strlen($this->path), strlen($fileUri) - strlen($this->path) - strlen($this->extension) - 1);
        $this->openMode  = $openMode;
        $this->fileUri   = $fileUri;
        
        if($openFile){
            $this->file = $this->openFile();
        }
        
    }
    
    private function fileExist($fileUri = NULL, &$urlEncode = NULL){
        
        $file = is_null($fileUri) ? $fileUri : $this->fileUri;
        
        if(!file_exists(utf8_decode($file))){
            if(!file_exists(urldecode($file))){
                return FALSE;
            }
        }
        
        $urlEncode = file_exists(utf8_decode($file)) ? utf8_decode($file) : urldecode($file);
        return TRUE;
    }
    
    public function openFile(){
        
        if(!$this->fileExist($this->fileUri, $urlEncode)){
            echo "File not exist";
            exit;
        }        
        
        $this->size = filesize($urlEncode);
        
        return fopen($urlEncode, $this->openMode);
    }
    
    public function setFileUri($fileUri){
        $this->fileUri = $fileUri;
    }
    
    public function getOpenFile(){
        return $this->file;
    }

    public function getExtension(){
        return $this->extension;
    }
    
    public function getNameFile(){
        return $this->name;
    }
    
    public function closeFile(){
        fclose($this->file);
    }
    
    public function readFile(){
        
        $stream = $this->file;
        if(($content = fread($stream, $this->size)) === FALSE){
            echo "Ocurrio un error leyendo el archivo";
            exit;
        }
        
        $this->closeFile();
        
        return $content;
    }
    
    public function renameFile($uriFile){
        rename($this->fileUri, $uriFile);
    }
    
    public function writeFile(){}
    
    public function readLine(){}
    
}