<?php
class GerenciaArquivo {
	private $diretorio;
	
	public function __construct(){
		$this->diretorio = '';
	}
	public function setDiretorio($diretorio){
		$this->diretorio = $diretorio;
	}
	public function getDiretorio(){
		return $this->diretorio;
	}
	public function deleta($arquivo, $location){
		unlink($this->diretorio."/".$arquivo);
		header("location: " . $location);
	}
	public function deletaTurma($dir, $redirect = "index.php"){
		$dh = opendir($this->diretorio . "/" . $dir);
  		while ($arquivo = readdir($dh)) {
      		if ($arquivo != "." && $arquivo != "..") {
          		$caminho = $this->diretorio . "/" . $dir . "/" . $arquivo;
          		if (!is_dir($caminho)) {	
              		unlink($caminho);
          		} else {
              		$this->deletaTurma($dir . "/" . $arquivo);
        		}
     		}
  		}
  	
  		closedir($dh);
  
  		if (rmdir($this->diretorio . "/" . $dir)){
  			return true;
  		} else {
      		return false;
  		}
	}

	public function copia($arquivo){
		$info = pathinfo($this->diretorio."/".$arquivo);
		copy($this->diretorio."/".$arquivo,$this->diretorio."/".$info["filename"]."_copia.".$info["extension"]);
		header("location: index.php");
	}
	
	public function renomeia($antigo, $novo){
		$novo = str_replace(" ", "_", $novo);
		$cacento = array( "б", "а", "в", "г", "д", "й", "и", "к", "л", "н", "м", "о", "п", "у", "т", "ф", "х", "ц", "ъ", "щ", "ы", "ь", "з", "Б", "А", "В", "Г", "Д", "Й", "И", "К", "Л", "Н", "М", "О", "П", "У", "Т", "Ф", "Х", "Ц", "Ъ", "Щ", "Ы", "Ь", "З" );
		$sacento = array( "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c", "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C" );
	   	$novo = str_replace($cacento, $sacento, $novo);
		if(rename($this->diretorio."/".$antigo, $this->diretorio."/".$novo)){}
	}
	
	public function upload($arquivo, $nome, $location){
		if($arquivo["type"] == "image/jpeg" || 
		$arquivo["type"] == "image/jpg" || 
		$arquivo["type"] == "image/gif" || 
		$arquivo["type"] == "image/png"){
			$extensao = explode("/", $arquivo["type"]);
			$antigo = $arquivo["name"];
			$novoNome = str_replace(" ", "_", ucwords($nome)). "." . $extensao[1];
			move_uploaded_file($arquivo["tmp_name"], $this->diretorio . "/" . $novoNome);
			//header("location: " . $location);
		}
	}
	public function lerDiretorio(){
		$arquivos = scandir($this->diretorio);
		arsort($arquivos);//Ricardo Brancher-> Ordenei o array para exibir do mais recente.
		$dados = array();
		unset($arquivos[0]);
		unset($arquivos[1]);
		foreach($arquivos as $arquivo){
				// Testa se a pasta ou o arquivo й oculto e pula para a prуxima iteraзгo.
				if (substr($arquivo, 0, 1) == '.') {
					continue;
				}
				$info = pathinfo($this->diretorio."/".$arquivo);
				$dado['nome'] = $arquivo;
				if(is_file($this->diretorio."/".$arquivo)){
					$arq = str_replace("_", " ", $info['filename']);
					$dado['tamanho'] = filesize($this->diretorio."/".$arquivo);
					$dado['extensao'] = $info['extension'];
					$dado['imagem'] = $arquivo;
					$dado['link'] = $arq;
				}
				else{
					$arq = str_replace("_", " ", $arquivo);
					$dado['tamanho'] = null;
					$dado['extensao'] = null;
					$dado['imagem'] = null;
					$dado['link'] = "<a class='act-success' href='turmas.php?pasta=".$info['filename']."'>" . $arq . "</a>";
					$dado['link2'] = "<a class='act-success' href='aluno.php?pasta=".$info['dirname']."/".$info['filename']."'>". $arq . "</a>";//Ricardo Brancher-> Crie o link2 passando o diretorio atual mais o nome da pasta como parametro para aluno.php
				
				}
				
				$dados[] = $dado;
			
		}
		return $dados;
	}
}
?>
