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
		$colunas=array("id_linguagem","idioma");
		$tabelas[0][0]="linguagem";
		$tabelas[0][1]=null;
		$ordenacao = null;
		$condicao = $_POST["id"];
		
		$stmt = $c->selecionar($colunas,$tabelas,null,null);
		$linha = $stmt->fetch(PDO::FETCH_ASSOC);
		$value_id_linguagem = $linha["id_linguagem"];
        $value_idioma= $linha["idioma"];
		$action = "altera.php?tabela=linguagem";
	}
	else{
		$action = "insere.php?tabela=linguagem";
		$value_id_linguagem="";
		$value_idioma="";
		
    }
    //---------------------------------------------------------------------------------------------

	
	$v = array("action"=>"insere.php?tabela=linguagem","method"=>"post");
    $f = new Form($v);
	
	

	$v = array("type"=>"text","name"=>"IDIOMA","placeholder"=>"IDIOMA.","value"=>$value_idioma);
	$f->add_input($v);
	$v = array("type"=>"button","class"=>"cadastrar","texto"=>"CADASTRAR");
	$f->add_button($v);	
    
?>
<div id="status"></div>
<hr />
<?php
	echo "<fieldset>";
	echo "<h3>Formulário - Configurações das Linguagens</h3>";
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
				data: {tabela: "linguagem"},
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
						tabela: "linguagem" 
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
									0:{0:"linguagem",1:null},
									
								},
						colunas:{0:"id_linguagem",1:"idioma"}, 
						pagina: b
					  },
				success: function(matriz){
					//console.log(matriz);
					$("tbody").html("");
					for(i=0;i<matriz.length;i++){
						tr = "<tr>";
						tr += "<td>"+matriz[i].id_linguagem+"</td>";
						tr += "<td>"+matriz[i].idioma+"</td>";
						if(permissao=='2'){
							tr += "<td><button value='"+matriz[i].id_linguagem+"' class='remover'>Remover</button>";
							tr += "<button value='"+matriz[i].id_linguagem+"' class='alterar'>Alterar</button></td>";
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
				data: {id: id_alterar, tabela: "linguagem"},
				success: function(dados){
					$("input[name='ID_LINGUAGEM']").val(dados.ID_LINGUAGEM);
					$("input[name='IDIOMA']").val(dados.IDIOMA);
					$(".cadastrar").attr("class","alterando");
					$(".alterando").html("ALTERAR");
				}
			});
		});
			
			$(document).on("click",".alterando",function(){
				
				$.ajax({
					url:"altera.php?tabela=linguagem",
					type: "post",
					data: {
						ID_LINGUAGEM: id_alterar,
						IDIOMA: $("input[name='IDIOMA']").val()
						
					 },
					beforeSend:function(){
						$("button").attr("disabled",true);
					},
					success: function(d){
						$("button").attr("disabled",false);
						if(d=='1'){
							$("#status").html("Idioma Alterado com sucesso!");
							$("#status").css("color","green");
							$(".alterando").attr("class","cadastrar");
							$(".cadastrar").html("CADASTRAR");
							$("input[name='ID_LINGUAGEM']").val("");
							$("input[name='IDIOMA']").val("");
							paginacao(pagina_atual);
						}
						else{
							console.log(d);
							$("#status").html("Idioma Não Alterado! Código já existe!");
							$("#status").css("color","red");
						}
					}
				});
			});
			
			//defina a seguinte regra para o botao de envio
			$(document).on("click",".cadastrar",function(){
			
			$.ajax({
				url: "insere.php?tabela=linguagem",
				type: "post",
				data: {
                    
                        IDIOMA: $("input[name='IDIOMA']").val()
					 },
				beforeSend:function(){
					$("button").attr("disabled",true);
				},
				success: function(d){
					$("button").attr("disabled",false);
					if(d=='1'){
						console.log(1)
						$("#status").html("Idioma inserido com sucesso!");
						$("#status").css("color","green");
						carrega_botoes();
						paginacao(1);
					}
					else if(d=='0'){
						$("#status").html("Idioma Não inserido! Você não tem permissão!");
						$("#status").css("color","red");
					}
					else{
						console.log(d);
						$("#status").html("Idioma Não inserido! Código já existe!");
						$("#status").css("color","red");
					}
				}
			});
		});
		
	});
</script>
</body>
</html>