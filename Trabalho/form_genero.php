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
		$colunas=array("id_genero","tipo");
		$tabelas[0][0]="genero";
		$tabelas[0][1]=null;
		$ordenacao = null;
		$condicao = $_POST["id"];
		
		$stmt = $c->selecionar($colunas,$tabelas,null,null);
		$linha = $stmt->fetch(PDO::FETCH_ASSOC);
		$value_id_genero = $linha["id_genero"];
        $value_tipo= $linha["tipo"];
		$action = "altera.php?tabela=genero";
	}
	else{
		$action = "insere.php?tabela=genero";
		$value_id_genero="";
		$value_tipo="";
		
    }
    //---------------------------------------------------------------------------------------------

	
	$v = array("action"=>"insere.php?tabela=genero","method"=>"post");
    $f = new Form($v);
	
	

	$v = array("type"=>"text","name"=>"TIPO","placeholder"=>"GENERO..","value"=>$value_tipo);
	$f->add_input($v);
	$v = array("type"=>"button","class"=>"cadastrar","texto"=>"CADASTRAR");
	$f->add_button($v);	
    
?>
<div id="status"></div>
<hr />
<?php
	echo "<fieldset>";
	echo "<h3>Formulário - Configurações dos Gêneros</h3>";
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
				data: {tabela: "genero"},
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
						tabela: "genero" 
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
									0:{0:"genero",1:null},
									
								},
						colunas:{0:"id_genero",1:"tipo"}, 
						pagina: b
					  },
				success: function(matriz){
					//console.log(matriz);
					$("tbody").html("");
					for(i=0;i<matriz.length;i++){
						tr = "<tr>";
						tr += "<td>"+matriz[i].id_genero+"</td>";
						tr += "<td>"+matriz[i].tipo+"</td>";
						if(permissao=='2'){
							tr += "<td><button value='"+matriz[i].id_genero+"' class='remover'>Remover</button>";
							tr += "<button value='"+matriz[i].id_genero+"' class='alterar'>Alterar</button></td>";
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
				data: {id: id_alterar, tabela: "genero"},
				success: function(dados){
					$("input[name='ID_GENERO']").val(dados.ID_GENERO);
					$("input[name='TIPO']").val(dados.TIPO);
					$(".cadastrar").attr("class","alterando");
					$(".alterando").html("ALTERAR");
				}
			});
		});
			
			$(document).on("click",".alterando",function(){
				
				$.ajax({
					url:"altera.php?tabela=genero",
					type: "post",
					data: {
						ID_GENERO: id_alterar,
						TIPO: $("input[name='TIPO']").val()
						
					 },
					beforeSend:function(){
						$("button").attr("disabled",true);
					},
					success: function(d){
						$("button").attr("disabled",false);
						if(d=='1'){
							$("#status").html("usuario Alterada com sucesso!");
							$("#status").css("color","green");
							$(".alterando").attr("class","cadastrar");
							$(".cadastrar").html("CADASTRAR");
							$("input[name='ID_GENERO']").val("");
							$("input[name='TIPO']").val("");
							paginacao(pagina_atual);
						}
						else{
							console.log(d);
							$("#status").html("usuario Não Alterada! Código já existe!");
							$("#status").css("color","red");
						}
					}
				});
			});
			
			//defina a seguinte regra para o botao de envio
			$(document).on("click",".cadastrar",function(){
			
			$.ajax({
				url: "insere.php?tabela=genero",
				type: "post",
				data: {
						ID_GENERO: $("input[name='ID_GENERO']").val(),
                        TIPO: $("input[name='TIPO']").val()
					 },
				beforeSend:function(){
					$("button").attr("disabled",true);
				},
				success: function(d){
					$("button").attr("disabled",false);
					if(d=='1'){
						console.log(1)
						$("#status").html("Genero inserido com sucesso!");
						$("#status").css("color","green");
						carrega_botoes();
						paginacao(1);
					}
					else if(d=='0'){
						$("#status").html("Genero Não inserido! Você não tem permissão!");
						$("#status").css("color","red");
					}
					else{
						console.log(d);
						$("#status").html("Genero Não inserido! Código já existe!");
						$("#status").css("color","red");
					}
				}
			});
		});
		
	});
</script>
</body>
</html>