<!DOCTYPE html>

<html>
<head>
	<meta charset="UTF-8">
	<title>Gerenciador de Corridas</title>
</head>
<body>
	<div style='display:block;'>
		<form action="index.php" method="post"  enctype="multipart/form-data">
		    <fieldset>
		        <legend>Envie um arquivo com a lista de voltas</legend>

		        <input type="file" name="raceInfo" placeholder="Selecionar arquivo">

		        <button type="submit" class="pure-button pure-button-primary">Enviar</button>
		    </fieldset>
		</form>
	</div>
	
	<div style='display:block;'>
		<table>
			<thead>
				<tr>
					<th>Hora</th>
					<th>Piloto</th>
					<th>Nº Volta</th>
					<th>Tempo da Volta</th>
					<th>Velocidade Média</th>
				</tr>
			</thead>
			<?php foreach($raceInfo['result'] as $pilotPosition) :?>			
			<tr>
				<td> <?php $lap->hora ?></td>
				<td> <?php $lap->piloto ?></td>
				<td> <?php $lap->volta ?></td>
				<td> <?php $lap->tempo ?></td>
				<td> <?php $lap->velocidade ?></td>
			</tr>
			<?php endforeach; ?>
		</table>
	</div>
</body>
</html>