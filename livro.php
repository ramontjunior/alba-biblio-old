<?php 
	include "config.php";
	
	$usr_nome = $_GET["usr_nome"];
	$usr_id = $_GET["usr_id"];
	
	session_start();
	
	if( isset($_SESSION['id']) && isset($_SESSION['nome']) ){
	
		if( (($_SESSION['id']) == $usr_id)  && (($_SESSION['nome']) == $usr_nome) ){
		$stmt = $con->prepare("select * from contato where usuarios_id = ? order by nome asc");
		
		$stmt->bindParam(1,$usr_id);
		
		$stmt->execute();

	#OBS.: O html esta dentro dos if's acima para testar se a sessao criada er igual ao id passado via get
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		
		<title>Bem vindo <?php echo $usr_nome ?></title>
		
		<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="screen">
		<link href="css/bootstrap-responsive.css" rel="stylesheet" type="text/css" media="screen">
		
		<!--<script src="http://code.jquery.com/jquery-latest.js"></script>-->
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
		
		<style type="text/css">
			#table{
				text-align: center;
			}
			.span4{
				text-align: center;
			}
			#esq{
				text-align: right;
			}
			#dire{
				text-align: right
			}
		</style>
		
	</head>
	<body>
		
		
		<div class="row">
			
			<div class="span4">
				<div class="visible-desktop">
					<!-- Botao p adc ctt pelo pc-->
					<a href="#adcctt" role="button" class="btn btn-primary" data-toggle="modal">Novo Contato</a>
				</div>
				<!-- Botao p adc ctt pelo celular ou tablet-->
				<div class="hidden-desktop">
					<a href="dm_adcctt.html"><button class="btn btn-primary">Novo Contato</button></a>
				</div>
			</div>
			<div class="span4">
				<p class="text-success">
					<h1> Seus Contatos</h1>
				</p>
			</div>
			<div class="span4" id="esq">
				<!-- Botao para pesquisar no formulario -->
				<a href="#pesquisa" role="button" class="btn btn-primary" data-toggle="modal">Pesquisar</a>
				<!-- Botao para sair -->
				<a href="logout.php" class="text-error">
					<button class="btn btn-danger">Sair</button>
				</a>
				
			</div>
			
		</div>
		<div class="row">
				<div class="span12"><br /></div>
		</div>
		<div class="row-fluid">
			
			<div class="span1"></div>
			
			<div class="span10">
			    
			    <table class="table table-hover" id="table">
				    <thead>
					    <tr>
						    <th>Nome</th>
						    <th>Endereço</th>
						    <th>Telefones</th>
						    <th>E-mails</th>
					    </tr>
				    </thead>
				    <tbody>
						<?php foreach ($stmt as $linha){?>
						
						    <tr>
							    <td><?php echo $linha['nome'] ?></td>
							    <td><?php echo $linha['endereco'] ?></td>
							    <td>
							    	<?php
							    		echo $linha['telefone1'] . "<br />";
										echo $linha['telefone2'] . "<br />";
										echo $linha['telefone3'] . "<br />";
							    	?>
							     </td>
							     <td>
							    	<?php
							    		echo $linha['email1'] . "<br />";
										echo $linha['email2'] . "<br />";
										echo $linha['email3'] . "<br />";
							    	?>
							     </td>
							     <td>
							     	<a href="delctt.php?ctt_id=<?php echo $linha['id'] ?>">
							     		<input value="Deletar" type="button" class="btn btn-danger" />
							     	</a>
							     	<br />
							     	<a href="formeditactt.php?ctt_id=<?php echo $linha['id'] ?>">
							     		<input value="Editar" type="button" class="btn btn-success" />
							     	</a>
							     </td>
						    </tr>
					   <?php } ?>
						
				    </tbody>
			    </table>
			    
			    <div class="row-fluid">
			    	
			    	<div class="span3"></div>
			    	<div class="span6">
			    		
			    	</div>
			    	<div class="span3"></div>
			    	
			    </div>
			    
				
			</div>
			
			<div class="span1"></div>
 			
 			<!-- Adc contato 
 			
			Modal -->
			<div id="adcctt" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-header">
				    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				    <h3 id="myModalLabel">Adicionar um novo contato</h3>
			  	</div>
				<div class="modal-body">
			    	<!-- Formulario p adc ctt  -->
					<form method="post" action="adc_contato.php">
						<fieldset>
							<input name="nome" placeholder="Insira o nome" class="input-large" required="" type="text">
							<input name="endereco" placeholder="Insira o endereço" class="input-large" type="text">
							<br />
							<input name="telefone1" placeholder="Insira o telefone" class="input-medium" maxlength="10" required="" type="number">
							<input name="telefone2" placeholder="Insira outro telefone" class="input-medium" maxlength="10" type="number">
							<input name="telefone3" placeholder="Insira outro telefone" class="input-medium" maxlength="10" type="number">
							<br />
							<input name="email1" placeholder="Insira o email" class="input-medium" required="" type="email">
							<input name="email2" placeholder="Insira outro email" class="input-medium" type="email">
							<input name="email3" placeholder="Insira outro email" class="input-medium" type="email">
							<br />
							<div class="row-fluid">
							<div class="span4"></div>
							<div class="span4">
							
							<input type="submit" class="btn btn-success" value="Cadastrar" />
							<input type="reset" class="btn btn-danger" value="Limpar" />
							
							</div>
								<div class="span4"></div>
							</div>
						</fieldset>
					</form>
			    
				</div>
			</div>
			
			<!-- Pesquisa de contatos -->
			
			<div id="pesquisa" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-header">
				    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				    <h3 id="myModalLabel">Buscar um contato</h3>
			  	</div>
				<div class="modal-body">
			    	<!-- Formulario p pesquisar contato  -->
					<form method="post" action="buscactt.php?usr_nome=<?php echo $usr_nome ?>&usr_id=<?php echo $usr_id ?>" class="form-search">
					   <label>Buscar por: </label>
					    <select name="coluna">
							<option value="nome">Nome</option>
							<option value="endereco">Endereço</option>
							<option value="email">Email</option>
							<option value="telefone">Telefone</option>
						</select>
						<br />
					    <input name="buscactt" type="text" placeholder="Buscar contatos" class="input-medium search-query">
						<button type="submit" class="btn">Busca</button>
						
				    </form>
			    
				</div>
			</div>
			
		</div>
	</body>
</html>

<?php
	
	}else{
		header("Location: erro.html");
	}
}else{
	header("Location: erro.html");
}
	
?>