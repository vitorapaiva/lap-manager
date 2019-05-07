<?php
include ('classes/LapManagerController.php');



if(isset($_FILES['raceInfo']))
{
  $lapManager=new LapManagerController();
  $raceResult=$lapManager->processFile($_FILES['raceInfo']);
}

require('views/index.view.php');