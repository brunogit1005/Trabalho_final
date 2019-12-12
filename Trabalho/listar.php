<?php



	require_once("../classeLayout/classeCabecalhoHTML.php");
	require_once("cabecalho.php");
	
	
	require_once("../classeLayout/classeTabela.php");
	
	require_once("conexao.php");
	require_once("classeControllerBD.php");
	
	$condicao = null;
	$ordenacao = null;
	
	require_once("configuracoes_listar.php");
	

	
	if($_GET["t"]=="usuario"){
		require_once("form_usuario.php");
	}
	
	
	if($_GET["t"]=="jogo"){
		require_once("form_jogo.php");
	}
	

	if($_GET["t"]=="classificacao"){
		require_once("form_classificacao.php");
	}

	if($_GET["t"]=="genero"){
		require_once("form_genero.php");
	}

	
	if($_GET["t"]=="linguagem"){
		require_once("form_linguagem.php");
	}



	
	$c = new ControllerBD($conexao);
	
	$r = $c->selecionar($colunas,$t,$ordenacao,$condicao," LIMIT 0,5");
	
	while($linha = $r->fetch(PDO::FETCH_ASSOC)){
		$matriz[] = $linha;
	}
	
	$t = new Tabela($matriz,$t[0][0]);
	$t->exibe();
?>
