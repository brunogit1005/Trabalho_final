<?php
     
    
    require_once("conexao.php");
    include("../classeLayout/classeCabecalhoHTML.php");
    include("Cabecalho.php");

    
  
   

    if(!isset($_SESSION['itens']))
    {
        $_SESSION['itens'] = array();
    }

    if(isset($_GET['add']) && $_GET['add'] == "carrinho")
    {
        /* adiciona ao carrinho */
        $idjogo = $_GET['id'];
        if(!isset($_SESSION['itens'][$idjogo])){
            $_SESSION['itens'][$idjogo] = 1;
        }
        

    }
    

if(count($_SESSION['itens']) == 0){
    echo'<img src="img/carrinho.png" class="img-responsive margin" style="width:10%" alt="Image">';
    echo '<h1>Carrinho Vazio</h1> <br><a href ="listar_todos_jogos.php">Adicionar ao carrinho </a>';
    
    
}
else  
{
    //array vazio
   $_SESSION['dados'] = array();


    foreach($_SESSION['itens'] as $idjogo => $quantidade ){
    $select = $conexao->prepare("SELECT * FROM jogo WHERE id_jogo=?");
    $select->bindParam(1,$idjogo);
	$select->execute();
    $jogo = $select->fetchAll();
    $preco  = $jogo[0]["PRECO"];



        echo
        'Nome: '.$jogo[0]["NOME_JOGO"].'<br/>
        Preço: '.number_format($jogo[0]["PRECO"],2,",",".").'<br/>
        <a href = "remover_jogos.php?remover=carrinho&id='.$idjogo.'">Remover</a>
        <hr/>
        ';
        //prenche o array vazio 
        array_push(
        $_SESSION['dados'],
        array('id_jogo' => $idjogo,
               'preco'=> $preco 
        )

    
        );
     
       
    }


    
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" language="javascript">
function Ocultar(){
    var ref_select = document.getElementById('ref_select');
    var ref_input = document.getElementById('ref_input');
    
if (ref_select.value != "boleto")
ref_input.disabled = false;
else
ref_input.disabled = true;

if (ref_input.value != "")
ref_select.disabled = false;
else
ref_select.disabled = false;
}

</script>
<title></title>
</head>
<body>
<?php 
    if(isset($quantidade)){
    echo"
        <form action=\"finalizar.php\" method=\"POST\">
    <select name=\"MODO_PAGAMENTO\" id=\"ref_select\" onchange=\"Ocultar();\">
    <option value=\"cartao\">Cartão</option>
    <option value=\"boleto\">Boleto</option>
    </select>
    <br /><br />
    <input type=\"text\" name=\"NUM_CARTAO\" id=\"ref_input\" placeholder=\"Número do Cartão\" required onkeyup=\"Ocultar();\"/>
    <button type=\"submit\" value=\"Submit\">Finalizar Compras</button>
    </form>
    ";}
?>
</body>
</html>
