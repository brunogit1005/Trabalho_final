<?php

require_once("../classeLayout/classeCabecalhoHTML.php");
require_once("cabecalho.php");
include("conexao.php");

 $id_usuario = $_SESSION["usuario"]["id_usuario"];


    

    $select = $conexao->prepare("SELECT *
    FROM compra 
    INNER JOIN compra_jogo 
    ON compra.id_compra = compra_jogo.id_compra
    INNER JOIN jogo 
    ON jogo.id_jogo = compra_jogo.id_jogo
    INNER JOIN usuario
    ON usuario.id_usuario = compra.id_usuario
    LIKE '$id_usuario' ORDER BY NOME_JOGO
     ");


	$select->execute();
	$fetch = $select->fetchAll();

	if(isset($fetch)){
    foreach($fetch as $jogo){
		echo "<div class = 'titulolista'>";
		echo 'Nome do Jogo: '.$jogo['NOME_JOGO'].'</br>';
		echo '<a href ="listar_jogos.php?var='.$jogo['NOME_JOGO'].'"><img src="img/'.$jogo['NOME_JOGO'].'.jpg'.'""width="250" height="350"></a></br>';
    echo "<br/ > <hr />";
    echo"</div>";
  }
}

else{
  echo"Não a jogos comprados ";
}

?>
<!DOCTYPE html>
<html>
<title>Shoryuken</title>
<link rel="stylesheet" type="text/css" href="css/main.css">
<head>
<title> Seus jogos </title>
</head>
<body>
</br>
</br>
</body>
</html>