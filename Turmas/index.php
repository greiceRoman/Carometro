<?php
	include_once("classes/GerenciaArquivo.class.php");
	$ga = new GerenciaArquivo();

	$ga->setDiretorio('imagens');


	if(isset($_POST["submit"])){
		$cacento = array( "á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç", "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç" );
		$sacento = array( "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c", "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C" );
	   	
		$pasta_ano = $_POST["pastaAno"];
		$diretorio = $ga->getDiretorio() . "/" . $pasta_ano;
		
		if(is_dir($diretorio)){//Ricardo Brancher-> Verifica se o ano já foi criado
			echo "<script type='text/javascript'>";
			echo "alert('Este Ano ja existe!')";
			echo "</script>";
		}else{
			mkdir($ga->getDiretorio()."/".$pasta_ano);
		}	
		

		if($_FILES["arquivoImgTurma"]["size"] != 0){
			$ga->upload($_FILES["arquivoImgTurma"], $pasta_ano, $diretorio);
			$antigo = $_FILES["arquivoImgTurma"]["name"];
			$extensao = pathinfo($antigo);
			$novo = $pasta_ano . "." . $extensao["extension"];	
			
		}
	}
	if (isset($_GET["acao"]) && $_GET["acao"] == "deleta") {
		$ga->deletaTurma($_GET["file"]);
		
	}
	$arquivos = $ga->lerDiretorio();
	function formatarNomeTurma($nome) {
		$nome = str_replace("_", " ", $nome);
		return $nome;
	}
?>
<html>
	<head>
		<title>Car&ocirc;metro</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="css/style.css" rel="stylesheet" media="screen">
		<link href="css/print.css" rel="stylesheet" media="print">
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/javascript.js"></script>
		<script src="js/index.js"></script>
	</head>
	<body>
		<div class="header">
			<a href="index.php" class="no_print"><img src="img/ifrsbento.JPG" id="logoIfrs" /></a>
			<div class="titulo_header pull-right">
				<h2>Car&ocirc;metro</h2>
			</div>
		</div>
		<div class="content">
			<table class="table table-hover">
				<tr class="no_print">
					<th>&nbsp;</th>
					<th>Nome da Turma</th>
					<th>Excluir</th>
				</tr>
				<?php 
					if(is_array($arquivos)){
						foreach($arquivos as $arquivo){
							if($arquivo["extensao"] == ""){

								if(file_exists("imagens/" . $arquivo["nome"] . ".JPEG")){
									echo "<td><img src='imagens/" . $arquivo["nome"] . ".JPEG' style='width: 50px; height: 50px;'' /></td>";

								}
								
								echo "<td>" . $arquivo['link'] . "</td>";
								//AQUI//
								echo "<td><a class='btn excluir' href='index.php?acao=deleta&file=".$arquivo['nome']."' title='Excluir'><i class='icon-trash'></i></a>";
								echo "</td></tr>";
							}
						}
					}
				?>
			</table>
			<form name="form_turma" action="index.php" method="post" onsubmit="return validaTurmaAno();" enctype="multipart/form-data" class="no_print">
				<h3> Incluir Turma</h3>
				
				<div class="input-prepend" >
					<span class="add-on">Ano da Turma</span>
					<input type="text" name="pastaAno" placeholder="Digite o ano" class="span3" style="height: 30px;width:150px;">
				</div>
				<div class="fileupload fileupload-new" data-provides="fileupload">
					<div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;"></div>
					<div>
						<span class="btn btn-file">
							<span class="fileupload-new">Selecionar</span>
							<span class="fileupload-exists">Substituir</span>
							<input type="file" name="arquivoImgTurma" id="arquivoImgTurma" />
						</span>
						<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remover</a>
					</div>
				</div>
				<input type="submit" value="Criar Turma" name="submit" class="btn btn-success">
			</form>
		</div>
		<div class="footer well no_print">
			Eduardo Schenato &amp; Rafael Canal&nbsp;&copy;
		</div>
	</body>
</html>
