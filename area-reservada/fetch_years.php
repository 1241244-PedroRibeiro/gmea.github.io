<?php
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (isset($_POST['num_socio'])) {
    $num_socio = $mysqli->real_escape_string($_POST['num_socio']);

    $query = "SELECT DATE_FORMAT(data_added, '%Y') as ano_adicionado FROM socios WHERE num_socio='$num_socio'";
    $result = $mysqli->query($query);

    if ($result) {
        $row = $result->fetch_assoc();
        if ($row) {
            $ano_adicionado = $row['ano_adicionado'];
            $ano_atual = date('Y');

            $years = '';
            for ($year = $ano_adicionado; $year <= $ano_atual; $year++) {
                $years .= "<option value='$year'>$year</option>";
            }

            echo $years;
        }
    } else {
        echo "Erro na consulta: " . $mysqli->error;
    }
}
?>
