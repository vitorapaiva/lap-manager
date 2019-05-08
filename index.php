<?php
include ('classes/LapManagerController.php');



if(isset($_FILES['raceInfo']))
{
  $lapManager=new LapManagerController();
  $raceResult=$lapManager->processFile($_FILES['raceInfo']['tmp_name']);
}

require('views/index.view.php');