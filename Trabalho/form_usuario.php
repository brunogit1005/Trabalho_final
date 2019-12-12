<html>
<title>Shoryuken</title>
<link rel="stylesheet" type="text/css" href="css/main.css">
</html>
<?php
	require_once("../classeForm/classeInput.php");
	
	require_once("../classeForm/classeForm.php");
	
	require_once("../classeForm/classeButton.php");
if(isset($_POST["id"])){
	$c = new ControllerBD($conexao);
	$colunas=array("id_usuario","nome","login","senha","data_nasc","rg","cpf","cidade","endereco","permissao","telefone");
	$tabelas[0][0]="usuario";
	$tabelas[0][1]=null;
	$ordenacao = null;
	$condicao = $_POST["id"];
	
	$stmt = $c->selecionar($colunas,$tabelas,$ordenacao,$condicao);
	$linha = $stmt->fetch(PDO::FETCH_ASSOC);
	$value_id_usuario = $linha["id_usuario"];
	$value_nome = $linha["nome"];
	$value_login = $linha["login"];
    $value_senha = $linha["senha"];
    $value_data_nasc = $linha["data_nasc"];
    $value_rg = $linha["rg"];
    $value_cpf = $linha["cpf"];
    $value_cidade = $linha["cidade"];
    $value_endereco = $linha["endereco"];
    $value_permissao = $linha["permissao"];
    $value_telefone = $linha["telefone"];
   
	$action = "altera.php?tabela=usuario";
}
else{
	$action = "insere.php?tabela=usuario";
	$value_id_usuario="";
	$value_nome="";
	$value_login="";
    $value_senha="";
    $value_data_nasc="";
    $value_rg="";
    $value_cpf="";
    $value_cidade="";
    $value_endereco="";
    $value_permissao="";
    $value_telefone="";
   
}
	$v = array("action"=>$action,"method"=>"post");
	$f = new Form($v);
	
	
	$v = array("type"=>"text","name"=>"NOME","placeholder"=>"NOME ..","value"=>$value_nome);
	$f->add_input($v);	
	$v = array("type"=>"email","name"=>"LOGIN","placeholder"=>"login...","value"=>$value_login);
	$f->add_input($v);	
    $v = array("type"=>"password","name"=>"SENHA","placeholder"=>"SENHA...","value"=>$value_senha);
    $f->add_input($v);	
    $v = array("type"=>"date","name"=>"DATA_NASC","placeholder"=>"DATA NASCIMENTO...","value"=>$value_data_nasc);
    $f->add_input($v);	
    $v = array("type"=>"number","name"=>"RG","placeholder"=>"RG...","value"=>$value_rg);
    $f->add_input($v);	
    $v = array("type"=>"text","name"=>"CPF","placeholder"=>"CPF...","value"=>$value_cpf);
    $f->add_input($v);	
    $v = array("type"=>"text","name"=>"CIDADE","placeholder"=>"CIDADE...","value"=>$value_cidade);
    $f->add_input($v);	
    $v = array("type"=>"text","name"=>"ENDERECO","placeholder"=>"ENDEREÇO...","value"=>$value_endereco);
	$f->add_input($v);	
	if($_SESSION["usuario"]["permissao"] == 2){
    $v = array("type"=>"number","name"=>"PERMISSAO","placeholder"=>"PERMISSAO...","value"=>$value_permissao);
	$f->add_input($v);	
	}
    $v = array("type"=>"number","name"=>"TELEFONE","placeholder"=>"TELEFONE...","value"=>$value_telefone);
    $f->add_input($v);	
	$v = array("type"=>"button","class"=>"cadastrar","texto"=>"CADASTRAR");
	$f->add_button($v);	
?>
<h3>Formulário - Configurações dos Usuarios</h3>
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
				data: {tabela: "usuario"},
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
						tabela: "usuario" 
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
									0:{0:"usuario",1:null},
									
								},
						colunas:{0:"id_usuario",1:"nome",2:"login",3:"data_nasc",4:"rg",5:"cpf",6:"cidade",7:"endereco",8:"telefone"}, 
						pagina: b
					  },
				success: function(matriz){
					//console.log(matriz);
					$("tbody").html("");
					for(i=0;i<matriz.length;i++){
						tr = "<tr>";
						tr += "<td>"+matriz[i].id_usuario+"</td>";
						tr += "<td>"+matriz[i].nome+"</td>";
						tr += "<td>"+matriz[i].login+"</td>";
						tr += "<td>"+matriz[i].data_nasc+"</td>";
						tr += "<td>"+matriz[i].rg+"</td>";
						tr += "<td>"+matriz[i].cpf+"</td>";
						tr += "<td>"+matriz[i].cidade+"</td>";
						tr += "<td>"+matriz[i].endereco+"</td>";
						tr += "<td>"+matriz[i].telefone+"</td>";
						if(permissao=='2'){
							tr += "<td><button value='"+matriz[i].id_usuario+"' class='remover'>Remover</button>";
							tr += "<button value='"+matriz[i].id_usuario+"' class='alterar'>Alterar</button></td>";
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
				data: {id: id_alterar, tabela: "usuario"},
				success: function(dados){
					$("input[name='ID_USUARIO']").val(dados.ID_USUARIO);
					$("input[name='NOME']").val(dados.NOME);
					$("input[name='LOGIN']").val(dados.LOGIN);
					$("input[name='SENHA']").val(dados.SENHA);
					$("input[name='DATA_NASC']").val(dados.DATA_NASC);
					$("input[name='RG']").val(dados.RG);
					$("input[name='CPF']").val(dados.CPF);
					$("input[name='CIDADE']").val(dados.CIDADE);
					$("input[name='ENDERECO']").val(dados.ENDERECO);
					$("input[name='PERMISSAO']").val(dados.PERMISSAO);
					$("input[name='TELEFONE']").val(dados.TELEFONE);
					
					$(".cadastrar").attr("class","alterando");
					$(".alterando").html("ALTERAR");
				}
			});
		});
			
			$(document).on("click",".alterando",function(){
				
				$.ajax({
					url:"altera.php?tabela=usuario",
					type: "post",
					data: {
						ID_USUARIO: id_alterar,
						NOME: $("input[name='NOME']").val(),
						LOGIN: $("input[name='LOGIN']").val(),
						SENHA: $("input[name='SENHA']").val(),
						DATA_NASC: $("input[name='DATA_NASC']").val(),
						RG: $("input[name='RG']").val(),
						CPF: $("input[name='CPF']").val(),
						CIDADE: $("input[name='CIDADE']").val(),
						ENDERECO: $("input[name='ENDERECO']").val(),
						PERMISSAO: $("input[name='PERMISSAO']").val(),
						TELEFONE: $("input[name='TELEFONE']").val()
						
						
					 },
					beforeSend:function(){
						$("button").attr("disabled",true);
					},
					success: function(d){
						$("button").attr("disabled",false);
						if(d=='1'){
							$("#status").html("Usuario alterado com sucesso!");
							$("#status").css("color","green");
							$(".alterando").attr("class","cadastrar");
							$(".cadastrar").html("CADASTRAR");
							$("input[name='ID_USUARIO']").val("");
							$("input[name='NOME']").val("");
							$("input[name='LOGIN']").val("");
							$("input[name='SENHA']").val("");
							$("input[name='DATA_NASC']").val("");
							$("input[name='RG']").val("");
							$("input[name='CPF']").val("");
							$("input[name='CIDADE']").val("");
							$("input[name='ENDERECO']").val("");
							$("input[name='PERMISSAO']").val("");
							$("input[name='TELEFONE']").val("");
							
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
				url: "insere.php?tabela=usuario",
				type: "post",
				data: {
						NOME: $("input[name='NOME']").val(),
						LOGIN: $("input[name='LOGIN']").val(),
                        SENHA: $("input[name='SENHA']").val(),
                        DATA_NASC: $("input[name='DATA_NASC']").val(),
                        RG: $("input[name='RG']").val(),
                        CPF: $("input[name='CPF']").val(),
                        CIDADE: $("input[name='CIDADE']").val(),
                        ENDERECO: $("input[name='ENDERECO']").val(),
                        PERMISSAO: $("input[name='PERMISSAO']").val(),
                        TELEFONE: $("input[name='TELEFONE']").val()
                        

					 },
				beforeSend:function(){
					$("button").attr("disabled",true);
				},
				success: function(d){
					$("button").attr("disabled",false);
					if(d=='1'){
						$("#status").html("usuario inserida com sucesso!");
						$("#status").css("color","green");
						carrega_botoes();
						paginacao(pagina_atual);
					}
					else if(d=='0'){
						$("#status").html("usuario Não inserida! Você não tem permissão!");
						$("#status").css("color","red");
					}
					else{
						console.log(d);
						$("#status").html("usuario Não inserida! Código já existe!");
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