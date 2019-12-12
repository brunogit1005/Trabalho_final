<?php

include("conexao.php");

session_start();


$vetor["id_usuario"] = $_SESSION["usuario"]["id_usuario"];

$vetor["modo_pagamento"]  = $_POST["MODO_PAGAMENTO"];

if($_POST["MODO_PAGAMENTO"] == "cartao"){
    $vetor["num_cartao"]  = $_POST["NUM_CARTAO"];
}
else{
    $vetor["num_boleto"]  = "5245232342323";
}



if($_SESSION["usuario"]["permissao"]=="1"){
	if(!empty($_POST)){
		include("classeControllerBD.php");
		
		$c = new ControllerBD($conexao);
		
        $id_compra = $c->inserir($vetor,"compra");
        
        foreach($_SESSION["itens"] as $i=>$v){
            $vetor =null;
            $vetor["id_compra"] = $id_compra;
            $vetor["id_jogo"] = $i;
            $c->inserir($vetor,"compra_jogo");
        }
        echo "Compra realizada com sucesso
        <a href='index.php'>voltar para o inicio</a>
        
        ";
        unset($_SESSION["itens"]);       
        
	}
}
else{
	echo "0";
}
?>