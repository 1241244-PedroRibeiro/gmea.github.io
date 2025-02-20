<?php

	// Servidor local/desenvolvimento
	$bd_host="localhost";
	$bd_user="root";
	$bd_password="";
	$bd_database="gmea";


$conexao = mysqli_connect($bd_host, $bd_user, $bd_password, $bd_database);
if (!$conexao) {
    die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
}

?>