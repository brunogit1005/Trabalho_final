<!DOCTYPE html>
<html>
<head>
<title>Shoryuken</title>
	<meta charset="utf-8" />
	<script src="js/jquery-3.4.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script>
		
		$(function(){
			paginacao(0);
			
			$(document).on("click",".alterar",function(){
				id = $(this).attr("value");
				$.ajax({
					url: "carrega_cadastro_alterar.php",
					type: "post",
					data: {id: id},
					success: function(vetor){
						$("input[name='nome']").val(vetor.nome);
						$("input[name='email']").val(vetor.email);
						
					}
				});
				
			});
			
			function paginacao(p){
				
				$.ajax({
					url: "carrega_dados.php",
					type:"post",
					data:{pg: p},
					success:function(matriz){
						$("#tb").html("");
						for(i=0;i<matriz.length;i++){
							linha = "<tr class='alterar' value='" + matriz[i].id_cadastro + "'>";
							linha += "<td>" + matriz[i].nome + "</td>";
							linha += "<td>" + matriz[i].email + "</td>";
							linha += "<td>" + matriz[i].sexo + "</td>";
							linha +="</tr>";
							$("#tb").append(linha);
						}
					}
				});
			}
			
			
			$(".pg").click(function(){
				p = $(this).val();
				p = (p-1)*5;
				paginacao(p);
			});
			
			$("#cadastrar").click(function(){
				$.ajax({
					url: "insere_cadastro.php",
					type: "post",
					data: {
							nome: $("input[name='nome']").val(),
							email: $("input[name='email']").val(),
							sexo: $("input[name='sexo']:checked").val(),
						  },
					success: function(d){
						if(d=='1'){
							$("#status").html("Cadastro realizado com sucesso!");
						}
						else{
							console.log(d);
						}
					}
				});
			});
		});
	</script>
</head>
<body>

	<h1>Cadastro</h1>
	<hr />
	<div id="status"></div>
	<hr />
	<form>
	
		<input type="text" name="nome" placeholder="nome..." />
		<br /><br />
		<input type="email" name="email" placeholder="email..." />
		<br /><br />
		Sexo: <input type="radio" name="sexo" value="m" />Masculino 
			  <input type="radio" name="sexo" value="f" />Feminino 
		<br /><br />
		<input type="number" name="salario" placeholder="Salário..." min='0' step="0.01" />
		<br /><br />
		<button type="button" id="cadastrar">Cadastrar</button>
	</form>
	<hr />
	<table border='1'>
		<thead>	
			<tr><th>Nome</th><th>Email</th><th>Sexo</th><th>Salário</th></tr>
		</thead>
		<tbody id="tb">
		</tbody>
	</table>
	<br />
	<?php
		include("paginacao_cadastro.php");
	?>
</body>
</html>