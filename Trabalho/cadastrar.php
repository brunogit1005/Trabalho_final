<?php
include("conexao.php");

// pega as informaçoes via post do cadastro.html 
$vetor["NOME"]  = $_POST["NOME"];
$vetor["LOGIN"]  = $_POST["LOGIN"];
$vetor["SENHA"]  = $_POST["SENHA"];
$vetor["DATA_NASC"]  = $_POST["DATA_NASC"];
$vetor["RG"]  = $_POST["RG"];
$vetor["PERMISSAO"] = '1';
$vetor["CPF"]  = $_POST["CPF"];
$vetor["CIDADE"]  = $_POST["CIDADE"];
$vetor["ENDERECO"]  = $_POST["ENDERECO"];
$vetor["TELEFONE"]  = $_POST["TELEFONE"];

// insere no banco de dados 
if(!empty($_POST)){
		include("classeControllerBD.php");
		
		$c = new ControllerBD($conexao);
		
		 $c->inserir($vetor,"usuario");
		 echo "Cadastro realizado com sucesso";
		 echo '<br/><br/>';
		 echo'<a href = "form_login.php">Voltar ao Login</a>';
		
}


else {
	echo"cadastro nao realizado tenete novamente";
}
		 
?>