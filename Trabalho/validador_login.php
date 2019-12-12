<?php
include("conexao.php");
include("classeControllerBD.php");
$c = new ControllerBD($conexao);
$colunas = array("id_usuario","nome","permissao");
$tabelas[0][0] = "usuario";
$tabelas[0][1] = null;
$condicoes[0]["coluna"]="login";
$condicoes[0]["valor"]=$_POST["login"];
$condicoes[1]["coluna"]="senha";
$condicoes[1]["valor"]=$_POST["senha"];
$r = $c->selecionar($colunas,$tabelas,null,$condicoes,null);
$linha = $r->fetch(PDO::FETCH_ASSOC);
if($linha!=null){
	session_start();
	$_SESSION["usuario"] = $linha;
	header("location: index.php");
}
else{
	header("location: form_login.php");
}
?>