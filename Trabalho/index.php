<?php
	require_once("../classeLayout/classeCabecalhoHTML.php");
	require_once("cabecalho.php");
	
	require_once("../classeLayout/classeTabela.php");
	
	include_once("conexao.php");
	require_once("classeControllerBD.php");
	
?>
<html lang="pt-BR">
<head>
<link rel="shortcut icon" href="img/ryu.ico" />
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link href="css/css.css" rel="stylesheet">
  <script src="JS/jquery.min.js"></script>
  <script src="JS/bootstrap.min.js">
  </script>
<style>
  
  .bg-1 { 
    background-color: black; /* Green */
    color: #ffffff;
  }
  .bg-2 { 
    background-color: #474e5d; /* Dark Blue */
    color: #ffffff;
  }
  .bg-3 { 
    background-color: #ffffff; /* White */
    color: black;
  }
  .bg-4 { 
    background-color: black; /* Black Gray */
    color: #fff;
  }
  .container-fluid {
    padding-top: 70px;
    padding-bottom: 70px;
  }
  .btn{
	  background-color: black;
	  border-color:black;
	  overflow: hidden;
  }
  
  </style>

	
<meta charset="UTF-8" />

		<title>Shoryuken</title>
		<link rel="shortcut icon" href="favicon.ico" >
		<script src="js/jquery-ui.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/main.css">
		<script type="text/javascript">
</script>

<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
			<br/>

		<form action="listar_todos_jogos.php" method="post">

			<div class='carousel' data-height='80%' data-width='500px' data-effect='size' data-stop_on_hover='true'>

<?php 
/*$select = $conexao->prepare("SELECT * FROM jogo");
$select->execute();
$fetch = $select->fetchAll();
foreach($fetch as $jogo){
	
	echo '<a href ="listar_jogos.php?var='.$jogo['NOME_JOGO'].'"><img src="img/'.$jogo['NOME_JOGO'].'.jpg'.'"></a></br>';

}
*/
?>

<div class="container-fluid bg-1 text-center">
  <h3 class="margin">Quem Somos nós?</h3>
  <img src="img/akuma.gif" alt="akuma gif" style="width:430px;height:300px;"><br/><br/>
  <h3>Nós somos o site SHORYUKEN. Uma loja com um intuito de crescer no mercado, com vendas de jogos.</h3>
</div>

<!-- Third Container (Grid) -->
<div class="container-fluid bg-3 text-center">    
  <h1 class="margin">EM BREVE NA LOJA</h1><br>
  <div class="row">
    <div class="col-sm-4">
  <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo1">Ocultar</button><br/><br/>
  <div id="demo1" class="collapse in">
	  <p>Jogue a melhor combinação entre velocidade e força em DOOM Eternal, batalhando em diversas dimensões com esse novo capítulo do combate intenso em primeira pessoa.</p><br/></br></br>
	  </div>
      <img src="img/doom.jpg" class="test"  title="DOOM!"  class="img-responsive margin" style="width:100%" alt="Image">
    </div>
    <div class="col-sm-4"> 
	<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo2">Ocultar</button><br/><br/>
  <div id="demo2" class="collapse in">
      <p>Cyberpunk 2077 é uma história de ação e aventura em mundo aberto que se passa em Night City, uma megalópole obcecada pelo poder, glamour e modificações biológicas.</p><br/></br></br>
	  </div> 
	  <img src="img/cyberpunk.jpg" class="test"  title="CYBERPUNK!"   class="img-responsive margin" style="width:100%" alt="Image">
    </div>
    <div class="col-sm-4"> 
	<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#demo3">Ocultar</button><br/><br/>
  <div id="demo3" class="collapse in">
      <p>Para conseguir sobreviver, explore a grande e devastada Jericho City. Lute contra ameaças violentas em combates brutais e implacáveis, cortando e dilacerando seus adversários</p><br/></br></br>
	  </div>  
	  <img src="img/thesurge2.jpg" class="test"  title="THE SURGE 2!"   class="img-responsive margin" style="width:100%" alt="Image">
    </div>
  </div>
</div>
<!-- Footer -->
<footer class="container-fluid bg-4 text-center">
  <p>Email: Shoryuken@Ryu.com</a></p>
  <p>Telefone: 7777-7777</a></p> 
  <p>© 2019 Shoryuken Interactive Entertainment LLC</a></p> 
</footer>

</body>
</html>