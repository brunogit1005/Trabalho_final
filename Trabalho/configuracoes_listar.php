<?php
if(isset($_GET["t"])){
	if($_GET["t"]=="usuario"){
		
		$colunas = array(   "id_usuario as ID",
		"Nome as 'nome'",
		"login as 'Login'",
		"Data_nasc as 'Data de nascimento'",
		"rg as 'RG'",
		"cpf as 'Cpf'",
		"cidade as 'Cidade'",
		"endereco as 'Endereço'",
		"telefone as 'Telefone'",
		);				
				$t[0][0] = "usuario";
				$t[0][1] = null;
				
		if(isset($_SESSION["usuario"]["permissao"]) && $_SESSION["usuario"]["permissao"]=="1"){
			$condicao = $_SESSION["usuario"]["id_usuario"];
			
		}
	}

	else if($_GET["t"]=="jogo"){
		
		$colunas = array(   "id_jogo as ID",
							"nome_jogo as 'NOME DO JOGO'",
							"preco as 'Preço'",
							"idioma as 'Linguagem'",							
							"descricao as 'Descrição do jogo'",
							"classi_indicativa as 'Classificacao'",
							"tipo as 'gênero'",
							"empresa as 'Empresa'"
							);				
				$t[0][0] = "jogo";
				$t[0][1] = "classificacao";
				$t[1][0] = "jogo";
				$t[1][1] = "genero";
				$t[2][0] = "jogo";
				$t[2][1] = "linguagem";
	}
	
	else if($_GET["t"]=="classificacao"){
		
		$colunas = array(   "id_classificacao as ID",
									"classi_indicativa as 'Classificacao'"
									);				
				$t[0][0] = "classificacao";
				$t[0][1] = null;
	}
	
	else if($_GET["t"]=="genero"){
		
		$colunas = array(   "id_genero as ID",
							"tipo as 'Gênero'"
									);				
				$t[0][0] = "genero";
				$t[0][1] = null;
				}
	
	else if($_GET["t"]=="linguagem"){
		
		$colunas = array(   "id_linguagem as ID",
							"idioma as 'idioma'"
							);				
				$t[0][0] = "linguagem";
				$t[0][1] = null;
	}
	
	
	
}
?>