<?php
//Classe adaptada apartir de https://www.php.net/manual/pt_BR/features.file-upload.php#114004
class FileValidation{

	public function checkForErrors(){
		try {   

			if(!file_exists($_FILES['raceInfo']['tmp_name']) || !is_uploaded_file($_FILES['raceInfo']['tmp_name'])){
				throw new RuntimeException('Nenhum arquivo enviado.');
			}

		    if (!isset($_FILES['raceInfo']['error']) || is_array($_FILES['raceInfo']['error'])) {
		        throw new RuntimeException('Arquivo inválido.');
		    }

		    switch ($_FILES['raceInfo']['error']) {
		        case UPLOAD_ERR_OK:
		            break;
		        case UPLOAD_ERR_NO_FILE:
		            throw new RuntimeException('Nenhum arquivo enviado.');
		        case UPLOAD_ERR_INI_SIZE:
		        case UPLOAD_ERR_FORM_SIZE:
		            throw new RuntimeException('Arquivo maior que o limite.');
		        default:
		            throw new RuntimeException('Error desconhecido.');
		    }

		    if ($_FILES['raceInfo']['size'] > 1000000) {
		        throw new RuntimeException('Arquivo maior que o limite.');
		    }	


		    $finfo = new finfo(FILEINFO_MIME_TYPE);

		    if (false === $ext = array_search($finfo->file($_FILES['raceInfo']['tmp_name']),array('log' => 'text/plain','txt' => 'text/plain'),true)) {
		        throw new RuntimeException('Formato de arquivo inválido.');
		    }

		    $finfo = new SplFileInfo($_FILES['raceInfo']['name']);

		    if (false === $ext = array_search($finfo->getExtension(),array('log' ,'txt'),true)) {
		        throw new RuntimeException('Extensão de arquivo inválida.');
		    }

		    $file=file($_FILES['raceInfo']['tmp_name']);
		    if(count($file)==0){
		    	throw new RuntimeException('Linhas insuficientes.');
		    }
		    $firstLine=array_filter(explode(' ',preg_replace('!\s+!', ' ', $file[0])));
		    if(count($firstLine)!=10){
		    	throw new RuntimeException('Linha titulo fora do padrão.');
		    }

		    return ["result"=>true];

		} catch (RuntimeException $e) {

		    return ["result"=>false,
		    		"message"=>$e->getMessage()];

		}
	}
}
?>