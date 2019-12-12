<html>
<title>Shoryuken</title>
<link rel='shortcut icon' href='img/favicon.ico' />
<link rel="stylesheet" type="text/css" href="css/main.css">
</html>
<style>

</style>
<?php
	require_once("../classeLayout/classeCabecalhoHTML.php");
	require_once("cabecalho.php");
	
	require_once("../classeLayout/classeTabela.php");
	
	include_once("conexao.php");
	require_once("classeControllerBD.php");
	
?>



<?php 
	$pagina_atual= filter_input(INPUT_GET,'pagina',FILTER_SANITIZE_NUMBER_INT);

	$pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

	//limite de Jogo por pagina
	$qnt_result_pg = 3;

	$inicio = ($qnt_result_pg * $pagina) - $qnt_result_pg;

	//select na tabela jogo com a limitaçao de jogo por pagina 
	$select = $conexao->prepare("SELECT * FROM jogo limit $inicio,$qnt_result_pg");
	$select->execute();
	$fetch = $select->fetchAll();

	foreach($fetch as $jogo){
		
		
		echo "<div class = 'titulolista'>
		Jogo: ".$jogo['NOME_JOGO']."</br>
		</div>";
		//href na imagem vai para uma pagina com o nome do jogo igual a var que no caso e o nome do jogo 
		

		
		echo '<a href ="listar_jogos.php?var='.$jogo['NOME_JOGO'].'">
		<img src="img/'.$jogo['NOME_JOGO'].'.jpg'.'"width="250" height="350" data-toggle="tooltip" data-placement="right" title="'.$jogo['NOME_JOGO'].'"!"></a></br>
		'
		;
		echo'<p>';
		echo 'Preço: R$'.number_format($jogo['PRECO'],2,",",".");
		echo '</p>';
		echo'<p>';
		echo'<a href="carrinho.php?add=carrinho&id='.$jogo['ID_JOGO'].'">Adicionar ao Carrinho </a>';
		echo '</p>';
		echo "<br/ > <hr />";
	}
	$result_pg= "SELECT COUNT(ID_JOGO) AS num_result FROM jogo";
	$resultado_pg = mysqli_query($conn, $result_pg);
	$row_pg = mysqli_fetch_assoc($resultado_pg);
	//echo $row_pg['num_result'];

	$quantidade_pg = ceil($row_pg['num_result']/$qnt_result_pg );

	$max_links = 2;
	echo'<p>';
	//vai para a primeira pagina 
	echo"<a href='listar_todos_jogos.php?pagina=1'>primeira</a>   ";

	//faz a contagem de pagina anteriores 
	
	for($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++){
		if($pag_ant >= 1){
		echo"<a href='listar_todos_jogos.php?pagina=$pag_ant'>$pag_ant</a> ";
		}
	}
	

	echo "$pagina ";

	//faz a contagem de pagina depois 
	for($pag_dep = $pagina + 1; $pag_dep<= $pagina + $max_links; $pag_dep++){
		if($pag_dep <= $quantidade_pg){
		echo"<a href='listar_todos_jogos.php?pagina=$pag_dep'>$pag_dep</a> ";
		}
	}
	//vai para a ultima pagina
	echo"<a href='listar_todos_jogos.php?pagina=$quantidade_pg'>ultima</a>  ";
	echo '</p>';
?>
