function validaTurmaAno(){
	//aqui
	if (!checkExt(document.forms["form_turma"].elements["arquivoImgTurma"])) {
		return false;
	}
	//aqui
	var valor = document.forms["form_turma"].elements["pasta"].value;
	var length = valor.length;
    	var element = null;
	for (var inicio = 0; inicio < length; inicio++) {
		var fim = inicio + 1;
		element = valor.slice(inicio, fim);
		if(element == " "){
			valor = valor.replace(element, "_");
		}
		
		if(element == "@" || element == ">" || element == "<" || element == "$" || element == "%" || element == "#" || element == "!"
			 || element == "&" || element == "*"  || element == "("  || element == ")" || element == "-"  || element == "+"
			 || element == "/" || element == ":" || element == ";" || element == "," || element == "|" || element == "´" || element == "~"
			 || element == "`" || element == "^" || element == "¨" || element == "="){
				alert("Informe o ano corretamente");
				return false;
		}
	}
	if(valor == ""){
		alert(" Campo em Branco. Preencha o campo corretamente!");
		return false;
	} else {
		return true;
	}
}

function validaAluno(){
	if (!checkExt(document.forms["form_aluno"].elements["arquivoImg"])) {
		return false;
	}
	var valor = document.forms["form_aluno"].elements["aluno"].value;
	
	var length = valor.length;
    	var element = null;
	for (var inicio = 0; inicio < length; inicio++) {
		var fim = inicio + 1;
		element = valor.slice(inicio, fim);
		if(element == " "){
			valor = valor.replace(element, "_");
		}
		if(element == "@" || element == ">" || element == "<" || element == "$" || element == "%" || element == "#" || element == "!"
			 || element == "&" || element == "*"  || element == "("  || element == ")" || element == "-"  || element == "+"
			 || element == "/" || element == ":" || element == ";" || element == "," || element == "|" || element == "´" || element == "~"
			 || element == "`" || element == "^" || element == "¨" || element == "="){
				alert("Informe o nome do aluno corretamente");
				return false;
		}
	}
	if(valor == ""){
		alert(" Campo em Branco. Preencha o campo corretamente!");
		return false;
	} else{
		return true;
	}	


	if(document.forms["form_aluno"].elements["arquivoImg"].value == ""){
		alert("Escolha uma foto para o aluno");
		return false;
	} else{
		return true;
	}
}

function checkExt(element) {
   var fup = element;
   var fileName = fup.value;
   var ext = fileName.substring(fileName.lastIndexOf('.') + 1);

	if(ext == "JPEG" || ext == "jpeg" || etx == "JPG" || etx == "jpg"){
	    return true;
	}else{
	    alert("Somente imagens JPEG ou JPG");
	    return false;  
	}
}
