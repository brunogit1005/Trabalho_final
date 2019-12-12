<?php
session_start();
if(isset($_SESSION["usuario"]["permissao"])){
	if($_SESSION["usuario"]["permissao"]==2){
		include("conexao.php");
		include("classeControllerBD.php");
		
		
		$ctrl = New ControllerBD($conexao);
		$ctrl->remover($_POST["id"],$_POST["tabela"]);
		echo "1";
	}
	else{
		echo "0";
	}
}
else {
	echo "-1";
}
?>