<?php

include ('classes/LapManagerModel.php');

class LapManagerController {

   public function processFile($file){
        $model=new LapManagerModel();
        $raceResult=$model->raceResult($file);
        return $raceResult;
    }
}