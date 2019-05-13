<!DOCTYPE html>

<html>
<head>	
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Gerenciador de Corridas</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
</head>
<body>
	<div class="container">
		<div class="py-5 text-center">
	        <h2>Relatório de Análise de Corrida</h2>
	        <p class="lead">Envie um arquivo com a lista de voltas para que o sistema calcule o resultado. Formatos aceitos: .log, .txt. Favor, seguir o exemplo <a href="exemplo.log" target="_blank">aqui</a></p>
	      </div>
		<div class='row'>
			<div class="col-md-3">
				<form action="index.php" method="post"  enctype="multipart/form-data">
				    <div class="form-group">
				    	<label>Selecionar arquivo</label>
				        <input type="file" class="form-control-file mb-2" name="raceInfo" required>
				        <?php
				        	if(isset($_FILES['raceInfo'])){
								$fileValidation=new FileValidation();
								$result=$fileValidation->checkForErrors();
								
								if($result["result"]===true)
								{
								  	$lapManager=new LapManagerController();
									$raceResult=$lapManager->processFile($_FILES['raceInfo']['tmp_name']);
								}
								else{
									echo '<div class="alert alert-danger" role="alert">';
									echo $result["message"];
									echo '</div>';
								}
							}
				        ?>
				    </div>
				    <button type="submit" class="btn btn-primary">Enviar</button>
				</form>
			</div>
			<div class="col-md-9">
				<table id="race_result" >
					<thead>
						<tr>
							<th>Posição Chegada</th>
							<th>Código Piloto</th>
							<th>Nome Piloto</th>
							<th>Qtde Voltas Completadas</th>
							<th>Tempo Total de Prova</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if(isset($raceResult))
						{
							foreach($raceResult["pilot"] as $code=>$pilotResult) :
						?>			
							<tr>
								<td> <?php echo $pilotResult["position"]; ?></td>
								<td> <?php echo $code; ?></td>
								<td> <?php echo $pilotResult["pilotName"]; ?></td>
								<td> <?php echo $pilotResult["lapQty"]; ?></td>
								<td> <?php echo $pilotResult["totalRaceTime"]; ?></td>
							</tr>
						<?php 
							endforeach; 
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script> 
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
	<script>
		$(document).ready(function() {
		    $('#race_result').DataTable( {
		        columnDefs: [ {
		            targets: [ 0 ],
		            orderData: [ 0, 1 ]
		        } ]
		    } );
		} );
	</script>
</body>
</html>