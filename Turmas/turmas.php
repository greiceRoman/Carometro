<?php
	include_once("classes/GerenciaArquivo.class.php");
	$ga = new GerenciaArquivo();
	$ga->setDiretorio('imagens/' . $_GET["pasta"]);
		
	$arquivos = $ga->lerDiretorio();

	
	if(isset($_POST["submit"])){
		$cacento = array( "·", "‡", "‚", "„", "‰", "È", "Ë", "Í", "Î", "Ì", "Ï", "Ó", "Ô", "Û", "Ú", "Ù", "ı", "ˆ", "˙", "˘", "˚", "¸", "Á", "¡", "¿", "¬", "√", "ƒ", "…", "»", " ", "À", "Õ", "Ã", "Œ", "œ", "”", "“", "‘", "’", "÷", "⁄", "Ÿ", "€", "‹", "«" );
		$sacento = array( "a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c", "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C" );
	   	$pasta = str_replace($cacento, $sacento, $_POST["pasta"]);
		$pasta = str_replace(" ", "_", $pasta);
		
		
		$pastaurma = $_POST["pasta"];
		$diretorio = $ga->getDiretorio()."/".$pastaurma;
		
		if(is_dir($diretorio)){//Ricardo Brancher-> Criei um alert pra avisar se o diretorio ja existe(Turma)
			echo "<script type='text/javascript'>";
			echo "alert('Esta Turma ja existe! Informe outro nome.')";
			echo "</script>";
		}else{
			mkdir($ga->getDiretorio()."/".$pastaurma);
			header("location: turmas.php?pasta=".$_GET["pasta"]);
		}
		// Fim RB
		
		$arquivos = $ga->lerDiretorio();
		if($_FILES["arquivoImgTurma"]["size"] != 0){
			$ga->upload($_FILES["arquivoImgTurma"], $pastaurma, $diretorio);
			$antigo = $_FILES["arquivoImgTurma"]["name"];
			$extensao = pathinfo($antigo);
			$novo = $pasta . "." . $extensao["extension"];
			$ga->renomeia($antigo, $novo);	
		}
		
		
	}

	if(isset($_GET["acao"]) && $_GET["acao"]== "deleta"){
		$ga->deletaTurma($_GET["file"], "turmas.php?pasta=" . $_GET["pasta"]);
	}

	$arquivos = $ga->lerDiretorio();

	function formatarNomeTurma($nome){
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
			<a href="index.php"><img src="img/ifrsbento.JPG" id="logoIfrs" class="no_print"/></a>
			<div class="titulo_header pull-right">
				<h2><?php echo ucwords(str_replace("_", " ", $_GET["pasta"])); ?></h2>
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
								echo "<tr>";
								if(file_exists("imagens/" . $arquivo["nome"] . ".png")){
									echo "<td><img src='imagens/" . $arquivo["nome"] . ".png' /></td>";
								}
								else{
									echo "<td><img src='imagens/sem_simbolo.PNG' style='width: 50px; height: 50px;' /></td>";
								}
								echo "<td>" . $arquivo['link2'] . "</td>";//N√O ESQUECER DE ARRUMAR PARA ACESSAR A PASTA
								echo "<td><a class='btn excluir' href='turmas.php?pasta=".$_GET['pasta']."&acao=deleta&file=".$arquivo['nome']."' title='Excluir'><i class='icon-trash'></i></a>";
								echo "</td></tr>";
							}
						}
					}
				?>
			</table>
			<form name="form_turma" action="turmas.php?pasta=<?php echo $_GET['pasta'] ?>" method="post" onsubmit="return validaTurma();" enctype="multipart/form-data" class="no_print">
				<h3> Incluir Turma</h3>
				
				<div class="input-prepend" >
					<span class="add-on">Nome da Turma</span>
					<input type="text" name="pastaT" placeholder="Digite o nome" class="span3" style="height: 30px;width:150px;">
				</div>
				<div class="fileupload fileupload-new" data-provides="fileupload">
					<div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;"></div>
					<div>
						<span class="btn btn-file">
							<span class="fileupload-new">Selecionar</span>
							<span class="fileupload-exists">Substituir</span>
							<input type="file" name="arquivoImgTurma" />
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
