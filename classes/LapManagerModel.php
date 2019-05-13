<?php


class LapManagerModel {

    private function turnFileIntoArray($fileName){
        if($fileName){
            $raceInfo=file($fileName);
            if($raceInfo){
                foreach($raceInfo as $line_num => $lap){
                    $arrayFile[$line_num]=array_filter(explode(' ',preg_replace('!\s+!', ' ', $lap)));
                }
            }
        }
        if(is_array($arrayFile)){
            unset($arrayFile[0]);
            return $arrayFile;
        }
        return false;
    }

    private function organizeResult(array $arrayFile){
        $arrayRace=[];
        $maxLapNumber=0;
        foreach($arrayFile as $line){
            $dateTime=$line[0];
            $pilotCode=$line[1];
            $pilotName=$line[3];
            $lapNumber=$line[4];
            $lapDuration=$line[5];
            $lapAverageSpeed=$line[6];
            if(!isset($arrayRace["pilot"][$pilotCode]["pilotName"])){
                $arrayRace["pilot"][$pilotCode]["pilotName"]=$pilotName;
            }
            $arrayRace["pilot"][$pilotCode]["lap"][$lapNumber]["dateTime"]=$dateTime;
            $arrayRace["pilot"][$pilotCode]["lap"][$lapNumber]["lapDuration"]=$lapDuration;
            $arrayRace["pilot"][$pilotCode]["lap"][$lapNumber]["lapAverageSpeed"]=$lapAverageSpeed;
            if($lapNumber>=$maxLapNumber){
                $maxLapNumber=$lapNumber;
            }
            $arrayRace["lastLap"]=$maxLapNumber;
        }
        return $arrayRace;
    }

    private function calculatesPolePosition(array $arrayRace){
        $lastPlace=count($arrayRace["pilot"]);
        $lastLap=$arrayRace["lastLap"];
        foreach($arrayRace["pilot"] as $code => $resultLap){   
            $arrayRace["pilot"][$code]["position"]=$lastPlace;         
            foreach($arrayRace["pilot"] as $codeAdversary => $resultLapAdversary){
                if(isset($resultLap["lap"][$lastLap]) && $code!=$codeAdversary){
                    if(!isset($resultLapAdversary["lap"][$lastLap])){ //se o adversario nem completou a ultima volta
                        $arrayRace["pilot"][$code]["position"]=$arrayRace["pilot"][$code]["position"]-1;
                    }
                    if(isset($resultLapAdversary["lap"][$lastLap]) && $resultLap["lap"][$lastLap]["dateTime"]<$resultLapAdversary["lap"][$lastLap]["dateTime"]){ //se o adversario completou mas em tempo maior
                        $arrayRace["pilot"][$code]["position"]=$arrayRace["pilot"][$code]["position"]-1;
                    }
                }
            }
        }
        return $arrayRace;
    }

    private function calculatesLapQty(array $arrayRace){
        foreach($arrayRace["pilot"] as $code => $resultLap){   
            $arrayRace["pilot"][$code]["lapQty"]=count($arrayRace["pilot"][$code]["lap"]);
        }
        return $arrayRace;
    }

    private function calculatesTotalRaceTime(array $arrayRace){
        $totalRaceTime='00:00:00';
        foreach($arrayRace["pilot"] as $code => $resultLap){   
            if(isset($resultLap["lap"][1])){                
                $firstLapDateTime=new DateTime($resultLap["lap"][1]["dateTime"]);
                $lastLapDateTime=new DateTime($resultLap["lap"][$arrayRace["pilot"][$code]["lapQty"]]["dateTime"]);
                $lapDateTimeDiff=$firstLapDateTime->diff($lastLapDateTime);
                $totalRaceTime=$lapDateTimeDiff->format("%H:%I:%S");           
            }
            $arrayRace["pilot"][$code]["totalRaceTime"]=$totalRaceTime;
        }
        return $arrayRace;
    }

    private function calculateBestLapByPilot(array $arrayRace){
        //implementar futuramente
    }

    private function calculateBestLap(){
        //implementar futuramente
    }

    private function calculateAverageSpeed(){
        //implementar futuramente
    }

    private function calculateTimeAfterFirst(){
        //implementar futuramente
    }

    public function raceResult($file){
        $arrayFile=$this->turnFileIntoArray($file);
        $arrayRace=$this->organizeResult($arrayFile);
        $arrayRace=$this->calculatesLapQty($arrayRace);
        $arrayRace=$this->calculatesPolePosition($arrayRace);
        $arrayRace=$this->calculatesTotalRaceTime($arrayRace);
        return $arrayRace;
    }

}