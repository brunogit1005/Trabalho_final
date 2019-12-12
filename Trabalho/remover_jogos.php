<?php 
    session_start();
    if(isset($_GET['remover'])&& $_GET['remover']=="carrinho"){
        $idjogos = $_GET['id'];
        unset($_SESSION['itens'][$idjogos]);
        echo '<META HTTP-EQUIV="REFRESH" CONTENT="0;URL=carrinho.php"/>';
        

    }