<?php

class LapManagerController {

    public function turnFileIntoArray($fileName){
    	if($fileName){
    		$raceInfo=file($fileName);
    		if($raceInfo){
    			foreach($raceInfo as $line_num => $lap){
    				$arrayLap[$line_num]=array_filter(explode(' ',preg_replace('!\s+!', ' ', $lap)));
    			}
    		}
    	}
    	return $arrayLap;
    }

    public function processFile($file){
        $arrayLap=$this->turnFileIntoArray($file);
        unset($arrayLap[0]);
        var_dump($arrayLap);
    	$polePosition=array_filter($arrayLap, array($this, 'calculatesPolePosition');
        $lapQty=array_filter($arrayLap, array($this, 'calculatesLapQty');
        $totalRaceTime=array_filter($arrayLap, array($this, 'calculatesTotalRaceTime');
        $bestLapByPilot=array_filter($arrayLap, array($this, 'calculateBestLapByPilot');
        $bestLap=array_filter($arrayLap, array($this, 'calculateBestLap');
        $averageSpeed=array_filter($arrayLap, array($this, 'calculateAverageSpeed');
        $averageSpeed=array_filter($arrayLap, array($this, 'calculateAverageSpeed');
    }
}