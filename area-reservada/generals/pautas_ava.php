<?php
session_start();
require 'vendor/autoload.php'; // Certifique-se de que o autoload está no caminho correto
include "config.php";
use Dompdf\Dompdf;
use Dompdf\Options;

$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (empty($_SESSION["session_id"]) || $_SESSION["type"] < 3) {
    header("Location: ../index.php");
    exit;
}

if (isset($_GET['semestre'])) {
    $semestre = (int)$_GET['semestre'];
}

// Consulta SQL para obter todas as turmas
$sql_turmas = "SELECT cod_turma, nome_turma FROM turmas_gerais";
$result_turmas = $mysqli->query($sql_turmas);

$html = '<style>
            table {
                width: 100%;
                table-layout: fixed;
                border-collapse: collapse;
            }
            th, td {
                border: 1px solid black;
                word-wrap: break-word;
                padding: 5px;
                text-align: center;
            }
            th {
                background-color: #f2f2f2;
            }
            .gray {
                background-color: gray;
            }
        </style>';

if ($result_turmas->num_rows > 0) {
    while ($turma = $result_turmas->fetch_assoc()) {
        $cod_turma = $turma['cod_turma'];
        $nome_turma = $turma['nome_turma'];

        $html .= "<h2>Turma: $nome_turma</h2>";

        // Consulta SQL para obter os alunos da turma atual
        $sql = "SELECT *
                FROM alunos a 
                JOIN users1 u ON a.user = u.user 
                WHERE a.turma = '$cod_turma'";

        $result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
            $html .= '<table>
                    <thead>
                        <tr>
                            <th style = "font-size: 14px;" rowspan="3">N.º</th>
                            <th style = "font-size: 14px;" rowspan="3">Nome do Aluno</th>
                            <th style = "font-size: 14px;" colspan="2" rowspan="2">FORMAÇÃO MUSICAL</th>
                            <th style = "font-size: 14px;" colspan="5">CLASSES DE CONJUNTO</th>
                            <th style = "font-size: 14px;" colspan="3" rowspan="2">INSTRUMENTO</th>
                            <th style = "font-size: 14px;" colspan="3" rowspan="2">2º INSTRUMENTO</th>
                        </tr>
                        <tr>
                            <th colspan="2">Coro</th>
                            <th colspan="3">Orquestra</th>
                        </tr>
                        <tr>
                            <th style = "font-size: 10px;">Grau/Nível</th>
                            <th style = "font-size: 10px;">Avaliação</th>
                            <th style = "font-size: 10px;">Grau/Nível</th>
                            <th style = "font-size: 10px;">Avaliação</th>
                            <th style = "font-size: 10px;">Instrumento</th>
                            <th style = "font-size: 10px;">Grau/Nível</th>
                            <th style = "font-size: 10px;">Avaliação</th>
                            <th style = "font-size: 10px;">Instrumento</th>
                            <th style = "font-size: 10px;">Grau/Nível</th>
                            <th style = "font-size: 10px;">Avaliação</th>
                            <th style = "font-size: 10px;">Instrumento</th>
                            <th style = "font-size: 10px;">Grau/Nível</th>
                            <th style = "font-size: 10px;">Avaliação</th>
                        </tr>
                    </thead>
                    <tbody>';

            // Preenchendo a tabela com os dados obtidos
            while ($row = $result->fetch_assoc()) {
                // Remove o 'a' do campo 'user'
                $numero = str_replace('a', '', $row['user']);

                $html .= '<tr>
                        <td style = "font-size: 14px;">' . $numero . '</td>
                        <td style = "font-size: 14px;">' . $row['nome'] . '</td>';

                if($row['cod_fm'] != 0) {
                    $user = $row['user'];
                    // Obtendo o grau/nível da formação musical
                    $grau_fm_id = $row['grau_fm'];
                    $query_grau = "SELECT nome_grau FROM graus WHERE id_grau = $grau_fm_id";
                    $result_grau = $mysqli->query($query_grau);
                    if ($result_grau->num_rows > 0) {
                        $row_grau = $result_grau->fetch_assoc();
                        $grau_fm_nome = $row_grau['nome_grau'];
                    } else {
                        $grau_fm_nome = "N/A";
                    }

                    $html .= '<td style = "font-size: 12px;">' . $grau_fm_nome . '</td>'; // Grau/Nível Formação Musical
                    // Restante das colunas em branco
                    $cod_fm = $row['cod_fm'];
                    $query_nivel = "SELECT nivel FROM pautas_avaliacao WHERE user = '$user' AND disciplina = '$cod_fm' AND semestre = '$semestre'";
                    $result_nivel = $mysqli->query($query_nivel);
                    if ($result_nivel->num_rows > 0) {
                        $row_nivel = $result_nivel->fetch_assoc();
                        $nivel = $row_nivel['nivel'];
                    } else {
                        $nivel = "N/A";
                    }
                    $html .= '<td style = "font-size: 14px;"><b>' . $nivel . '</b></td>'; // Grau/Nível Formação Musical
                } else {
                    $html .= '<td class="gray"></td>';
                    $html .= '<td class="gray"></td>';
                }

                if($row['cod_coro'] != 0) {
                    // Obtendo o grau/nível da formação musical
                    $grau_coro_id = $row['grau_coro'];
                    $query_grau = "SELECT nome_grau FROM graus WHERE id_grau = $grau_coro_id";
                    $result_grau = $mysqli->query($query_grau);
                    if ($result_grau->num_rows > 0) {
                        $row_grau = $result_grau->fetch_assoc();
                        $grau_coro_nome = $row_grau['nome_grau'];
                    } else {
                        $grau_coro_nome = "N/A";
                    }
                    $html .= '<td style = "font-size: 12px;">' . $grau_coro_nome . '</td>'; // Grau/Nível Formação Musical
                    // Restante das colunas em branco
                    $cod_coro = $row['cod_coro'];
                    $query_nivel = "SELECT nivel FROM pautas_avaliacao WHERE user = '$user' AND disciplina = '$cod_coro' AND semestre = '$semestre'";
                    $result_nivel = $mysqli->query($query_nivel);
                    if ($result_nivel->num_rows > 0) {
                        $row_nivel = $result_nivel->fetch_assoc();
                        $nivel = $row_nivel['nivel'];
                    } else {
                        $nivel = "N/A";
                    }
                    $html .= '<td style = "font-size: 14px;"><b>' . $nivel . '</b></td>'; // Grau/Nível Formação Musical
                } else {
                    $html .= '<td class="gray"></td>';
                    $html .= '<td class="gray"></td>';
                }

                if($row['cod_orq'] != 0) {
                    // Obtendo o grau/nível da formação musical
                    $cod_in_orq = $row['cod_in_orq'];
                    $query_in_orq = "SELECT nome_dis FROM cod_dis WHERE cod_dis = $cod_in_orq";
                    $result_in_orq = $mysqli->query($query_in_orq);
                    if ($result_in_orq->num_rows > 0) {
                        $row_in_orq = $result_in_orq->fetch_assoc();
                        $nome_in_orq = $row_in_orq['nome_dis'];
                    } else {
                        $nome_in_orq = "N/A";
                    }
                    $html .= '<td style = "font-size: 12px;">' . $nome_in_orq . '</td>'; // Grau/Nível Formação Musical
                    // Obtendo o grau/nível da formação musical
                    $grau_orq_id = $row['grau_orq'];
                    $query_grau = "SELECT nome_grau FROM graus WHERE id_grau = $grau_orq_id";
                    $result_grau = $mysqli->query($query_grau);
                    if ($result_grau->num_rows > 0) {
                        $row_grau = $result_grau->fetch_assoc();
                        $grau_orq_nome = $row_grau['nome_grau'];
                    } else {
                        $grau_orq_nome = "N/A";
                    }
                    $html .= '<td style = "font-size: 12px;">' . $grau_orq_nome . '</td>'; // Grau/Nível Formação Musical
                    // Restante das colunas em branco
                    $cod_orq = $row['cod_orq'];
                    $query_nivel = "SELECT nivel FROM pautas_avaliacao WHERE user = '$user' AND disciplina = '$cod_orq' AND semestre = '$semestre'";
                    $result_nivel = $mysqli->query($query_nivel);
                    if ($result_nivel->num_rows > 0) {
                        $row_nivel = $result_nivel->fetch_assoc();
                        $nivel = $row_nivel['nivel'];
                    } else {
                        $nivel = "N/A";
                    }
                    $html .= '<td style = "font-size: 14px;"><b>' . $nivel . '</b></td>'; // Grau/Nível Formação Musical
                } else {
                    $html .= '<td class="gray"></td>';
                    $html .= '<td class="gray"></td>';
                    $html .= '<td class="gray"></td>';
                }

                if($row['cod_in1'] != 0) {
                    // Obtendo o grau/nível da formação musical
                    $cod_in1 = $row['cod_in1'];
                    $query_in1 = "SELECT nome_dis FROM cod_dis WHERE cod_dis = $cod_in1";
                    $result_in1 = $mysqli->query($query_in1);
                    if ($result_in1->num_rows > 0) {
                        $row_in_1 = $result_in1->fetch_assoc();
                        $nome_in_1 = $row_in_1['nome_dis'];
                    } else {
                        $nome_in_1 = "N/A";
                    }
                    $html .= '<td style = "font-size: 12px;">' . $nome_in_1 . '</td>'; // Grau/Nível Formação Musical
                    // Obtendo o grau/nível da formação musical
                    $grau_in1_id = $row['grau_in1'];
                    $query_grau = "SELECT nome_grau FROM graus WHERE id_grau = $grau_in1_id";
                    $result_grau = $mysqli->query($query_grau);
                    if ($result_grau->num_rows > 0) {
                        $row_grau = $result_grau->fetch_assoc();
                        $grau_in1_nome = $row_grau['nome_grau'];
                    } else {
                        $grau_in1_nome = "N/A";
                    }
                    $html .= '<td style = "font-size: 12px;">' . $grau_in1_nome . '</td>'; // Grau/Nível Formação Musical
                    // Restante das colunas em branco
                    $query_nivel = "SELECT nivel FROM pautas_avaliacao WHERE user = '$user' AND disciplina = '$cod_in1' AND semestre = '$semestre'";
                    $result_nivel = $mysqli->query($query_nivel);
                    if ($result_nivel->num_rows > 0) {
                        $row_nivel = $result_nivel->fetch_assoc();
                        $nivel = $row_nivel['nivel'];
                    } else {
                        $nivel = "N/A";
                    }
                    $html .= '<td style = "font-size: 14px;"><b>' . $nivel . '</b></td>'; // Grau/Nível Formação Musical
                } else {
                    $html .= '<td class="gray"></td>';
                    $html .= '<td class="gray"></td>';
                    $html .= '<td class="gray"></td>';
                }

                if($row['cod_in2'] != 0) {
                    // Obtendo o grau/nível da formação musical
                    $cod_in2 = $row['cod_in2'];
                    $query_in2 = "SELECT nome_dis FROM cod_dis WHERE cod_dis = $cod_in2";
                    $result_in2 = $mysqli->query($query_in2);
                    if ($result_in2->num_rows > 0) {
                        $row_in_2 = $result_in2->fetch_assoc();
                        $nome_in_2 = $row_in_2['nome_dis'];
                    } else {
                        $nome_in_2 = "N/A";
                    }
                    $html .= '<td style = "font-size: 12px;">' . $nome_in_2 . '</td>'; // Grau/Nível Formação Musical
                    // Obtendo o grau/nível da formação musical
                    $grau_in2_id = $row['grau_in2'];
                    $query_grau = "SELECT nome_grau FROM graus WHERE id_grau = $grau_in2_id";
                    $result_grau = $mysqli->query($query_grau);
                    if ($result_grau->num_rows > 0) {
                        $row_grau = $result_grau->fetch_assoc();
                        $grau_in2_nome = $row_grau['nome_grau'];
                    } else {
                        $grau_in2_nome = "N/A";
                    }
                    $html .= '<td style = "font-size: 12px;">' . $grau_in2_nome . '</td>'; // Grau/Nível Formação Musical
                    // Restante das colunas em branco
                    $query_nivel = "SELECT nivel FROM pautas_avaliacao WHERE user = '$user' AND disciplina = '$cod_in2' AND semestre = '$semestre'";
                    $result_nivel = $mysqli->query($query_nivel);
                    if ($result_nivel->num_rows > 0) {
                        $row_nivel = $result_nivel->fetch_assoc();
                        $nivel = $row_nivel['nivel'];
                    } else {
                        $nivel = "N/A";
                    }
                    $html .= '<td style = "font-size: 14px;"><b>' . $nivel . '</b></td>'; // Grau/Nível Formação Musical
                } else {
                    $html .= '<td class="gray"></td>';
                    $html .= '<td class="gray"></td>';
                    $html .= '<td class="gray"></td>';
                }

                $html .= '</tr>';
            }

            $html .= '</tbody></table><div style="page-break-after: always;"></div>';
        } else {
            $html .= "Nenhum aluno encontrado na turma $cod_turma.<div style='page-break-after: always;'></div>";
        }
    }
} else {
    $html .= "Nenhuma turma encontrada.";
}

$mysqli->close();

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->setPaper('A4', 'landscape');
$dompdf->loadHtml($html);
$dompdf->render();
$dompdf->stream("pautas_avaliacao" . $semestre-2 . "semestre.pdf", array("Attachment" => false));
?>
