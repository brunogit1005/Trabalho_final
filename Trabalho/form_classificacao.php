<html>
<title>Shoryuken</title>
<link rel="stylesheet" type="text/css" href="css/main.css">
</html>
<?php
	
	
	
	require_once("../classeForm/classeInput.php");
	require_once("../classeForm/classeOption.php");
	require_once("../classeForm/classeSelect.php");
	require_once("../classeForm/classeForm.php");
	require_once("../classeForm/classeButton.php");
    include("conexao.php");
    
if(isset($_POST["id"])){
	$c = new ControllerBD($conexao);
	$colunas=array("id_classificacao","classificacao");
	$tabelas[0][0]="classificacao";
	$tabelas[0][1]=null;
	$ordenacao = null;
	$condicao = $_POST["id"];
	
	$stmt = $c->selecionar($colunas,$tabelas,$ordenacao,$condicao);
	$linha = $stmt->fetch(PDO::FETCH_ASSOC);
	$value_id_classificacao = $linha["id_classificacao"];
    $value_classi_indicativa = $linha["classi_indicativa"];
    
    $action = "altera.php?tabela=classificacao";
}
else{
	$action = "insere.php?tabela=classificacao";
	$value_id_classificacao="";
    $value_classi_indicativa="";
   
}
	
	$v = array("action"=>$action,"method"=>"post");
	$f = new Form($v);
	
	
    $v = array("type"=>"text","name"=>"CLASSI_INDICATIVA","placeholder"=>"CLASSIFICAÇAO...","value"=>$value_classi_indicativa);
    $f->add_input($v);	
	$v = array("type"=>"button","class"=>"cadastrar","texto"=>"CADASTRAR");
	$f->add_button($v);	
?>

<h3>Formulário - Configurações das Classificações</h3>
<div id="status"></div>
<hr />
<?php
	$f->exibe();
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
				data: {tabela: "classificacao"},
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
						tabela: "classificacao" 
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
									0:{0:"classificacao",1:null}
								},
						colunas:{0:"id_classificacao",1:"classi_indicativa"}, 
						pagina: b
					  },
				success: function(matriz){
					$("tbody").html("");
					for(i=0;i<matriz.length;i++){
						tr = "<tr>";
						tr += "<td>"+matriz[i].id_classificacao+"</td>";
						tr += "<td>"+matriz[i].classi_indicativa+"</td>";
						if(permissao=='2'){
							tr += "<td><button value='"+matriz[i].id_classificacao+"' class='remover'>Remover</button>";
							tr += "<button value='"+matriz[i].id_classificacao+"' class='alterar'>Alterar</button></td>";
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
				data: {id: id_alterar, tabela: "classificacao"},
				success: function(dados){
					$("input[name='ID_CLASSIFICACAO']").val(dados.ID_CLASSIFICACAO);
					$("input[name='CLASSI_INDICATIVA']").val(dados.CLASSI_INDICATIVA);
					$(".cadastrar").attr("class","alterando");
					$(".alterando").html("ALTERAR");
				}
			});
		});
			
			$(document).on("click",".alterando",function(){
				
				$.ajax({
					url:"altera.php?tabela=classificacao",
					type: "post",
					data: {
						ID_CLASSIFICACAO: id_alterar,
						CLASSI_INDICATIVA: $("input[name='CLASSI_INDICATIVA']").val()
					 },
					beforeSend:function(){
						$("button").attr("disabled",true);
					},
					success: function(d){
						$("button").attr("disabled",false);
						if(d=='1'){
							$("#status").html("Classificação Alterada com sucesso!");
							$("#status").css("color","green");
							$(".alterando").attr("class","cadastrar");
							$(".cadastrar").html("CADASTRAR");
							$("input[name='ID_CLASSIFICACAO']").val("");
							$("input[name='CLASSI_INDICATIVA']").val("");
							
							
							paginacao(pagina_atual);
						}
						else{
							console.log(d);
							$("#status").html("Classificação Não Alterada! Código já existe!");
							$("#status").css("color","red");
						}
					}
				});
			});
			
			//defina a seguinte regra para o botao de envio
			$(document).on("click",".cadastrar",function(){
			
			$.ajax({
				url: "insere.php?tabela=classificacao",
				type: "post",
				data: {
						CLASSI_INDICATIVA: $("input[name='CLASSI_INDICATIVA']").val()
                       
                        
					 },
				beforeSend:function(){
					$("button").attr("disabled",true);
				},
				success: function(d){
					$("button").attr("disabled",false);
					if(d=='1'){
						$("#status").html("Classificação inserida com sucesso!");
						$("#status").css("color","green");
						carrega_botoes();
						paginacao(pagina_atual);
                        
					}
					else if(d=='0'){
						$("#status").html("Classificação Não inserido! Você não tem permissão!");
						$("#status").css("color","red");
					}
					else{
						console.log(d);
						$("#status").html("Classificação Não inserido! Código já existe!");
						$("#status").css("color","red");
					}
				}
			});
		});
		
	});
</script>
</body>
</html>
</html>