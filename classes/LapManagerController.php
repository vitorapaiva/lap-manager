<?php

class LapManagerController {

    public function saveFile($file)
    {
    	try{    		
	        $file_extension = strtolower(substr($_FILES['raceInfo']['name'],-4)); 
			$new_name = strtotime(date("Y.m.d-H.i.s")).$file_extension;
			$dir = 'uploads/';
			if(move_uploaded_file($_FILES['raceInfo']['tmp_name'], $dir.$new_name)){
				return $dir.$new_name;
			}
			return false;
    	}
    	catch(Exception $e){
    		echo $e->message;
    		return false;
    	}
    }

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
    	$fileName=$this->saveFile($file);
    	$arrayLap=$this->turnFileIntoArray($fileName);
    	var_dump($arrayLap);
    }
}