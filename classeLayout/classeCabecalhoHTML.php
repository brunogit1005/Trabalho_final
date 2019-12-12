<?php
	class CabecalhoHTML{
		private $menu;
		public function exibe(){
			
			echo "<!DOCTYPE html>
			<html>
			   <head>
				  <meta charset='utf-8' />
				  <style>
					  select, textarea, input{margin:5px;}	
					  
					  	
				  </style>
				  <link rel='shortcut icon' href='img/favicon.ico' />
				  <link rel='stylesheet' href='css/bootstrap.min.css'>
				  <link rel='stylesheet' type='text/css' href='css/main.css'>
				  <script src='js/jquery-3.4.1.min.js'></script>
			   </head>
			   <body>
			   <nav>
			  ";
				echo "<ul>";
					echo " <li><a href='index.php'>Shoryuken</a> </li>";
					echo " <li><a href='listar_todos_jogos.php'>Todos os Jogos</a></li>";

			if($this->menu!=null){
				foreach($this->menu as $tabela=>$texto){
					echo " <li><a href='listar.php?t=$tabela'>$texto</a> </li>";
				}				
				
			
				if ($_SESSION["usuario"]["permissao"]=="1"){
				echo "<li><a href='carrinho.php'>Carrinho</a></li>";
				}

				if ($_SESSION["usuario"]["permissao"]=="1"){
					echo "<li><a href='jogos_comprados.php'>Seus Jogos</a></li>";
					}
				echo "<li><a href='perfil.php'>Perfil</a> </li>";

				if(isset($_SESSION["usuario"]["permissao"])){
					echo "<li><a href='logout.php'>SAIR</a></li>";
				}

		
				
				echo "</nav>
				<hr />
				</ul>";
				
				}
		}
		
		public function add_menu($tabela){
			$this->menu = $tabela;
		}
		
		
	}
?>

