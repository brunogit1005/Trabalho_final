<?php
session_start();
include("conexao.php");
if($_SESSION["usuario"]["permissao"]=="2"){
	if(!empty($_POST)){
		include("classeControllerBD.php");
		
		$c = new ControllerBD($conexao);
		
		$c->inserir($_POST,$_GET["tabela"]);
		echo "1";
	}
}
else{
	echo "0";
}






?>