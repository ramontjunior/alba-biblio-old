<?php 
	session_start(); 
	
	if ( isset($_SESSION['id']) && $_SESSION['nome'] ){
		$id = $_SESSION['id'];
		$nome = $_SESSION['nome'];
		header("Location: livro.php?usr_id=$id&usr_nome=$nome");
	}else{ 
		header("Location: index.html");
	}
?> 