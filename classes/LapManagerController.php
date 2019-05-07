<?php

class LapManagerController {

    public function turnFileIntoArray($fileName){
    	if($fileName){
    		$raceInfo=file($fileName);
    		if($raceInfo){
    			foreach($raceInfo as $line_num => $lap){
    				$arrayLap[$line_num]=explode('	',$lap);
    			}
    		}
    	}
    	return $arrayLap;
    }

    public function processFile($file){
    	$arrayLap=$this->turnFileIntoArray($file);
    	var_dump($arrayLap);
    }
}