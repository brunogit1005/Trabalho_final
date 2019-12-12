<?php
	include("verificacao.php");
	$c = new CabecalhoHTML();
	if($_SESSION["usuario"]["permissao"]=="2"){
	$v = array(		
				"usuario"=>"Usuario",
				"jogo"=>"Jogo",
				"classificacao"=>"Classificacao",
				"genero"=>"Genero",
				"linguagem"=>"Linguagem"
				);
	$c->add_menu($v);
	$c->exibe();
	}

	if($_SESSION["usuario"]["permissao"]=="1"){
			$v = array( 
				"usuario"=>"Usuario"
			);
	$c->add_menu($v);
	$c->exibe();
		}
?>

