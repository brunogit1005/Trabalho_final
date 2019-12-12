<html>
<title>Shoryuken</title>
<link rel='shortcut icon' href='img/favicon.ico' />
<link rel="stylesheet" type="text/css" href="css/main.css">
</html>
<?php
require_once("../classeLayout/classeCabecalhoHTML.php");
require_once("cabecalho.php");
include("conexao.php");

 $usuario = $_SESSION["usuario"]["nome"];


    $sql = "SELECT * 
    FROM usuario
    where nome like'$usuario'";

    


    $stdm = $conexao->prepare($sql);

    $stdm->execute();

    while($linha = $stdm->fetch()){
        $nome = $linha["NOME"];
        $data = $linha["DATA_NASC"];
        $rg = $linha["RG"];
        $cpf = $linha["CPF"];
        $cidade = $linha["CIDADE"];
        $endereco = $linha["ENDERECO"];
        $telefone = $linha["TELEFONE"];
            }

?>
<!DOCTYPE html>
<html>
<head>
<title> perfil de usuario </title>
</head>
<body>

<?php
  if($_SESSION["usuario"]["permissao"] == 2){
    echo'<img src="img/perfil.jpg">';
  }
  if($_SESSION["usuario"]["permissao"] == 1){
    echo'<img src="img/perfil_usuario.jpg">';
  }
  
  if($_SESSION["usuario"]["permissao"] == 2){
    echo'<br>Essa conta é de um ADMINISTRADOR';
  }

  else{
    echo'<brEessa conta é de um USUARIO';
  }

?>
</br>
</br>

Nome:<i><?php echo"$nome"?></i>
        </br>

<i> Data Nascimento:<?php echo"$data"?></i> 
</br>

<i> RG:<?php echo"$rg"?></i> 
</br>

<i> Cpf:<?php echo"$cpf"?></i> 
</br>
<i> Cidade:<?php echo"$cidade"?></i> 
</br>
<i> Endereço:<?php echo"$endereco"?></i> 
</br>
<i> Telefone:<?php echo"$rg"?></i> 
</br>



</br>
<a href="listar.php?t=usuario">Alterar informaçoes da sua conta
    
</a>









</body>