<html>
<title>Shoryuken</title>
<link rel='shortcut icon' href='img/favicon.ico' />
<link rel="stylesheet" type="text/css" href="css/main.css">
</html>
<?php


 include("../classeLayout/classeCabecalhoHTML.php");
 include("Cabecalho.php");


$jogo = $_GET["var"];
$_SESSION["var"] = $jogo; 
include("conexao.php");
//var vindo da href do listar todos os jogos  

//select com inner join para pegar informaçoes de outras tabelas  
	$sql = "SELECT * 
    FROM jogo
    inner join classificacao
    on jogo.id_classificacao = classificacao.id_classificacao 
    inner join genero 
    on jogo.id_genero = genero.id_genero
    inner join linguagem 
    on jogo.id_linguagem = linguagem.id_linguagem
    where nome_jogo like'$jogo'";
    
	
	$stdm = $conexao->prepare($sql);

    $stdm->execute();
    
//while para pegar todas as informaçoes com esse var 
	while($linha = $stdm->fetch()){
        $id_jogo = $linha["ID_JOGO"];
        $nome_jogo = $linha["NOME_JOGO"];
        $descricao = $linha["DESCRICAO"];
        $classificacao = $linha["CLASSI_INDICATIVA"];
        $tipo = $linha["TIPO"];
        $idioma = $linha["IDIOMA"];
        $preco = $linha["PRECO"];
    }
    
    echo"
    <div class = 'titulojogos'>
    <span class='fonte'><span class='vermelho'>".$nome_jogo."
    </div>
    <div class = 'imgjogos'>
    
    </span><br/><img src='img/$nome_jogo.jpg' width='600' height='750'/>
    </div>
    <br/>
    <div class = 'titulo'>
    <a href=\"carrinho.php?add=carrinho&id=$id_jogo\">Adicionar ao Carrinho </a>
    <h1>Descrição</h1>
    </div>
    <div class = 'descjogos'>
    </br>$descricao </br>
    </div>
    <br/>
    <div class = 'informacoes'>
    
    </br>Classificacao :$classificacao </br>
    </br>Gênero :$tipo</br>
    </br>Linguagem :$idioma </br>
    </br>Preço : $preco</br>

    </div>"
    

    
    
    
    

    ?>
    		
