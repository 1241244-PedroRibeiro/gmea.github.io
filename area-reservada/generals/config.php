<?php

if ($_SERVER['SERVER_NAME']=="localhost") {
	// Servidor local/desenvolvimento
	$bd_host="localhost";
	$bd_user="root";
	$bd_password="";
	$bd_database="gmea";
}
else {
	// Servidor de produção
	$bd_host="localhost";
	$bd_user="usr21";
	$bd_password="5y2DtWIW";
	$bd_database="usr21";
}

$conexao = mysqli_connect($bd_host, $bd_user, $bd_password, $bd_database);
if (!$conexao) {
    die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
}

?>