<html>
<title>Shoryuken</title>
<link rel="stylesheet" type="text/css" href="css/main.css">
</html>
<?php
	require_once("../classeForm/classeInput.php");
	
	require_once("../classeForm/classeForm.php");
	
	require_once("../classeForm/classeButton.php");
	require_once("../classeForm/classeInput.php");
	require_once("../classeForm/classeOption.php");
	require_once("../classeForm/classeSelect.php");

	if(isset($_POST["id"])){
		$c = new ControllerBD($conexao);
		$colunas=array("id_jogo","id_classificacao","id_genero","id_linguagem","nome_jogo","preco","avaliacao","empresa","descricao");
		$tabelas[0][0]="jogo";
		$tabelas[0][1]=null;
		$ordenacao = null;
		$condicao = $_POST["id"];
		
		$stmt = $c->selecionar($colunas,$tabelas,$ordenacao,$condicao);
		$linha = $stmt->fetch(PDO::FETCH_ASSOC);
		$value_id_jogo = $linha["id_jogo"];
        $selected_id_classificacao = $linha["id_classificacao"];
		$selected_id_genero = $linha["id_genero"];
		$selected_id_linguagem = $linha["id_linguagem"];
		$value_nome_jogo = $linha["nome_jogo"];
		$value_preco = $linha["preco"];
		$value_avaliacao = $linha["avaliacao"];
		$value_empresa = $linha["empresa"];
		$value_descricao = $linha["descricao"];
		$action = "altera.php?tabela=jogo";
	}
	else{
		$action = "insere.php?tabela=jogo";
		$value_id_jogo="";
        $selected_id_classificacao="";
		$selected_id_genero="";
		$selected_id_linguagem="";
		$value_nome_jogo="";
		$value_preco="";
		$value_avaliacao="";
		$value_empresa="";
		$value_descricao="";
		
    }
    //---------------------------------------------------------------------------------------------

	
    //seleção dos valores que irão criar o <select> de Classificacao//////
    $select = "SELECT ID_CLASSIFICACAO AS value, CLASSI_INDICATIVA AS texto FROM classificacao ORDER BY CLASSI_INDICATIVA";
	
	$stmt = $conexao->prepare($select);
	$stmt->execute();
	
	while($linha=$stmt->fetch()){
		$matriz_classificacao[] = $linha;
	}

    //---------------------------------------------------------------------------------------------

	//seleção dos valores que irão criar o <select> de Genero//////
	$select = "SELECT ID_GENERO AS value, TIPO AS texto FROM genero ORDER BY TIPO";
	
	$stmt = $conexao->prepare($select);
	$stmt->execute();
	
	while($linha=$stmt->fetch()){
		$matriz_genero[] = $linha;
    }

	//---------------------------------------------------------------------------------------------
	//---------------------------------------------------------------------------------------------

	//seleção dos valores que irão criar o <select> de Linguagem//////
	$select = "SELECT ID_LINGUAGEM AS value, IDIOMA AS texto FROM linguagem ORDER BY IDIOMA";
	
	$stmt = $conexao->prepare($select);
	$stmt->execute();
	
	while($linha=$stmt->fetch()){
		$matriz_linguagem[] = $linha;
    }

    //---------------------------------------------------------------------------------------------

	
	$v = array("action"=>"insere.php?tabela=jogo","method"=>"post");
    $f = new Form($v);
	
	
    $v = array("name"=>"ID_CLASSIFICACAO","label"=>"IDADE");
	$f->add_select($v,$matriz_classificacao);
    
    $v = array("name"=>"ID_GENERO","label"=>"GENERO");
	$f->add_select($v,$matriz_genero);

	$v = array("name"=>"ID_LINGUAGEM","label"=>"IDIOMA");
	$f->add_select($v,$matriz_linguagem);

	$v = array("type"=>"text","name"=>"NOME_JOGO","placeholder"=>"NOME JOGO..","value"=>$value_nome_jogo);
	$f->add_input($v);

	$v = array("type"=>"number","name"=>"PRECO","placeholder"=>"PREÇO..","value"=>$value_preco);
    $f->add_input($v);


	$v = array("type"=>"text","name"=>"EMPRESA","placeholder"=>"EMPRESA..","value"=>$value_empresa);
	$f->add_input($v);
	
	$v = array("type"=>"text","name"=>"DESCRICAO","placeholder"=>"DESCRICAO..","value"=>$value_descricao);
    $f->add_input($v);

	$v = array("type"=>"button","class"=>"cadastrar","texto"=>"CADASTRAR");
	$f->add_button($v);	
    
?>
<div id="status"></div>
<hr />
<?php
	echo "<fieldset>";
	echo "<h3>Formulário - Configurações dos Jogos</h3>";
	echo "<br />";

		$f->exibe();
		
	echo "</fieldset>";
?>
<script>
	<?php 
		if($_SESSION["usuario"]["permissao"]==2){
			echo "permissao=2;";
		}
		else{
			echo "permissao=1;";
		}
	?>
	pagina_atual = 0;
	//quando o documento estiver pronto...
	$(function(){
		
		carrega_botoes();
		
		function carrega_botoes(){
			
			$.ajax({
				url: "quantidade_botoes.php",
				type: "post",
				data: {tabela: "jogo"},
				success: function(q){
					console.log(q);
					$("#botoes").html("");
					for(i=1;i<=q;i++){
						botao = " <button type='button' class='pg'>" + i + "</button>";
						$("#botoes").append(botao);
					}
				}
			});
		}
		
		$(document).on("click",".remover",function(){
			id_remover = $(this).val();
			
			$.ajax({
				url: "remover.php",
				type: "post",
				data: {
						id: id_remover,
						tabela: "jogo" 
					  },
				success: function(d){					
					if(d=='1'){
						$("#status").html("Removido com sucesso");
						carrega_botoes();
						qtd = $("tbody tr").length;
						if(qtd=="1"){
							pagina_atual--;
						}
						paginacao(pagina_atual);
					}
					else if(d=="0"){
						$("#status").html("Você não tem permissão para remover este dado.");
					}
					else {
						console.log(d);
						$("#status").html("Você não está logado.");
					}	
				}
			});
		});
		
		$(document).on("click",".pg",function(){
			valor_botao = $(this).html();
			pagina_atual = valor_botao;
			paginacao(valor_botao);
		});
		
		function paginacao(b){
			
			$.ajax({
				url: "carrega_dados.php",
				type: "post",
				data: {
						tabelas:{
									0:{0:"jogo",1:"classificacao"},
									1:{0:"jogo",1:"genero"},
									2:{0:"jogo",1:"linguagem"}
								},
						colunas:{0:"id_jogo",1:"classi_indicativa",2:"tipo",3:"idioma",4:"nome_jogo",5:"preco",6:"empresa",7:"descricao"}, 
						pagina: b
					  },
				success: function(matriz){
					//console.log(matriz);
					$("tbody").html("");
					for(i=0;i<matriz.length;i++){
						tr = "<tr>";
						tr += "<td>"+matriz[i].id_jogo+"</td>";
						tr += "<td>"+matriz[i].nome_jogo+"</td>";
						tr += "<td>"+matriz[i].preco+"</td>";
						tr += "<td>"+matriz[i].idioma+"</td>";
						tr += "<td>"+matriz[i].descricao+"</td>";
						tr += "<td>"+matriz[i].classi_indicativa+"</td>";
						tr += "<td>"+matriz[i].tipo+"</td>";
						tr += "<td>"+matriz[i].empresa+"</td>";
						
						if(permissao=='2'){
							tr += "<td><button value='"+matriz[i].id_jogo+"' class='remover'>Remover</button>";
							tr += "<button value='"+matriz[i].id_jogo+"' class='alterar'>Alterar</button></td>";
						}
						tr += "</tr>";	
						$("tbody").append(tr);
					}
				}
			});
		}
		
		$(document).on("click",".alterar",function(){ 
			id_alterar = $(this).val();			
			$.ajax({
				url: "get_dados_form.php",
				type: "post",
				data: {id: id_alterar, tabela: "jogo"},
				success: function(dados){
					$("input[name='ID_JOGO']").val(dados.ID_JOGO);
					$("select[name='ID_CLASSIFICACAO']").val(dados.ID_CLASSIFICACAO);
					$("select[name='ID_GENERO']").val(dados.ID_GENERO);
					$("select[name='ID_LINGUAGEM']").val(dados.ID_LINGUAGEM);
					$("input[name='NOME_JOGO']").val(dados.NOME_JOGO);
					$("input[name='PRECO']").val(dados.PRECO);
					$("input[name='EMPRESA']").val(dados.EMPRESA);
					$("input[name='DESCRICAO']").val(dados.DESCRICAO);
					$(".cadastrar").attr("class","alterando");
					$(".alterando").html("ALTERAR");
				}
			});
		});
			
			$(document).on("click",".alterando",function(){
				
				$.ajax({
					url:"altera.php?tabela=jogo",
					type: "post",
					data: {
						ID_JOGO: id_alterar,
						ID_CLASSIFICACAO:$("select[name='ID_CLASSIFICACAO']").val(),
						ID_GENERO:$("select[name='ID_GENERO']").val(),
						ID_LINGUAGEM:$("select[name='ID_LINGUAGEM']").val(),
						NOME_JOGO: $("input[name='NOME_JOGO']").val(),
						PRECO: $("input[name='PRECO']").val(),
						LINGUAGEM: $("input[name='LINGUAGEM']").val(),
						EMPRESA: $("input[name='EMPRESA']").val(),
						DESCRICAO: $("input[name='DESCRICAO']").val()
						
					 },
					beforeSend:function(){
						$("button").attr("disabled",true);
					},
					success: function(d){
						$("button").attr("disabled",false);
						if(d=='1'){
							$("#status").html("Usuario Alterada com sucesso!");
							$("#status").css("color","green");
							$(".alterando").attr("class","cadastrar");
							$(".cadastrar").html("CADASTRAR");
							$("select[name='ID_CLASSIFICACAO']").val("");
							$("select[name='ID_GENERO']").val("");
							$("select[name='ID_LINGUAGEM']").val("");
							$("input[name='NOME_JOGO']").val("");
							$("input[name='PRECO']").val("");
							$("input[name='LINGUAGEM']").val("");
							$("input[name='EMPRESA']").val("");
							$("input[name='DESCRICAO']").val("");
							
							paginacao(pagina_atual);
						}
						else{
							console.log(d);
							$("#status").html("Usuario Não Alterado! Código já existe!");
							$("#status").css("color","red");
						}
					}
				});
			});
			
			//defina a seguinte regra para o botao de envio
			$(document).on("click",".cadastrar",function(){
			
			$.ajax({
				url: "insere.php?tabela=jogo",
				type: "post",
				data: {
						ID_CLASSIFICACAO:$("select[name='ID_CLASSIFICACAO']").val(),
						ID_GENERO:$("select[name='ID_GENERO']").val(),
						ID_LINGUAGEM:$("select[name='ID_LINGUAGEM']").val(),
						NOME_JOGO: $("input[name='NOME_JOGO']").val(),
						PRECO: $("input[name='PRECO']").val(),
                        LINGUAGEM: $("input[name='LINGUAGEM']").val(),
                        EMPRESA: $("input[name='EMPRESA']").val(),
                        DESCRICAO: $("input[name='DESCRICAO']").val()
					 },
				beforeSend:function(){
					$("button").attr("disabled",true);
				},
				success: function(d){
					$("button").attr("disabled",false);
					if(d=='1'){
						$("#status").html("Jogo inserida com sucesso!");
						$("#status").css("color","green");
						carrega_botoes();
						paginacao(1);
					}
					else if(d=='0'){
						$("#status").html("Jogo Não inserida! Você não tem permissão!");
						$("#status").css("color","red");
					}
					else{
						console.log(d);
						$("#status").html("Jogo Não inserida! Código já existe!");
						$("#status").css("color","red");
					}
				}
			});
		});
		
	});
</script>
</body>
</html>