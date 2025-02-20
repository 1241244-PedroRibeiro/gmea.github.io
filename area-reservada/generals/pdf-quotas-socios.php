<?php
session_start();
include "config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (empty($_SESSION["session_id"]) || $_SESSION["type"] != 3) {
    header("Location: ../index.php");
    exit;
}

require __DIR__ . "/vendor/autoload.php";

// Receba as variáveis dos campos ocultos do formulário
$socio = isset($_POST['socio']) ? $_POST['socio'] : '';
$nome = isset($_POST['nome']) ? $_POST['nome'] : '';
$morada1 = isset($_POST['morada1']) ? $_POST['morada1'] : '';
$morada2 = isset($_POST['morada2']) ? $_POST['morada2'] : '';
$nif = isset($_POST['nif']) ? $_POST['nif'] : '';
$obs = isset($_POST['obs']) ? $_POST['obs'] : '';
$ano = isset($_POST['ano']) ? $_POST['ano'] : '';
$quota = 12;

$quota = str_replace('€', '', number_format((float)$quota, 2, '.', '')) . '€';

$num_fatura = 'Q' . $socio;

function obterUltimaFaturaNum($conexao)
    {
        $query = "SELECT MAX(fatura_num) FROM faturas";
        $resultado = mysqli_query($conexao, $query);
        $ultimaFatura = mysqli_fetch_array($resultado)[0];
        return $ultimaFatura;
    }

// Função para gerar o código único no formato "LNNLL LNLNNL-NNNL"
function generateUniqueCode() {
    $letters = range('A', 'Z'); // Alfabeto de A a Z
    $numbers = range(0, 9);     // Números de 0 a 9

    // Gere letras aleatórias
    $random_letters1 = '';
    for ($i = 0; $i < 5; $i++) {
        $random_letters1 .= $letters[array_rand($letters)];
    }

	// Gere letras aleatórias
	$random_letters2 = '';
	for ($i = 0; $i < 5; $i++) {
		$random_letters2 .= $letters[array_rand($letters)];
	}

    // Gere números aleatórios
    $random_numbers1 = '';
    for ($i = 0; $i < 3; $i++) {
        $random_numbers1 .= $numbers[array_rand($numbers)];
    }

	// Gere números aleatórios
	$random_numbers2 = '';
	for ($i = 0; $i < 3; $i++) {
		$random_numbers2 .= $numbers[array_rand($numbers)];
	}

    // Combine as partes para formar o código único no formato desejado
    $unique_code = $random_letters1 . ' ' . $random_letters2 . $random_numbers1 . '-' . $random_numbers2;
    return $unique_code;
}

$unique_id = generateUniqueCode();

$ultimaFatura = obterUltimaFaturaNum($mysqli);

// Load vars static or dinamics
$contenidoDinamico = $nome . '_' . $num_fatura . '_' . $ultimaFatura+1;

$hoje = date('d/m/Y');

// Cargar paquete para usar el modulo de Dompdf
use Dompdf\Dompdf;
use Dompdf\Options;

// Instanciar la clase Dompdf para su posterior utilizacion
$dompdf = new Dompdf();

// habilitar imagenes remotas
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

$nome_arquivo = $contenidoDinamico . '.pdf';

$caminho_arquivo = '../faturas/' . $nome_arquivo;

file_put_contents($caminho_arquivo, $dompdf->output());


// Elemento de plantilla, en el ejempo puedes ver como pasar campos dinamicos
$htmlTemplate = '
		<style>

            @page {
                size: A4;
                margin: 0;
            }
            
            body {
                margin: 0;
                font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
                color: #555;
            }
            
            .invoice-box {
                max-width: 100%;
                padding: 30px;
            }

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}
		</style>
	</head>

	<body>
		<div class="invoice-box">
			<table cellpadding="0" cellspacing="0">
				<tr class="top">
					<td colspan="2">
						<table>
							<tr>
								<td style="width: 60%;" class="title">
									<img src="https://i.imgur.com/WqwHV6A.jpeg" style="width: 100%; max-width: 200px" />
								</td>

								<td style="text-align: left;">
									Fatura n.º ' . $num_fatura . ' 2023/000' . $ultimaFatura+1 . '<br />
									Emitida em: ' . $hoje . '<br />
									<br/><br/><br/>
									<b text-align: right;> ' . $nome . '</b><br />
									<b> ' . $morada1 . '</b><br />
									<b> ' . $morada2 . '</b><br />
									NIF: <b> ' . $nif . '</b><br />
									<br />
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="2">
						<table>
							<tr>
								<td>
									Grupo Musical Estrela de Argoncilhe<br />
									Rua Grupo Musical Estrela de Argoncilhe, 81<br />
									4505-132, Argoncilhe<br />
									Santa Maria da Feira, Aveiro<br />
									NIF: 501312714<br />
									E-Mail: secretaria@gmea.pt<br />
									Website: www.gmea.pt
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="heading">
					<td></td>

					<td>Valor</td>
				</tr>

				<tr class="item">
					<td>Quotas - ' . $ano . '<br><br><span style="font-size: 12px;">Observações:</span></td>
					<td>' . $quota . '<br><br><span style="font-size: 12px;">' . $obs . '</span></td>
				</tr>

				<tr class="total">
					<td></td>

					<td style = "font-size: 24px"; >Total: ' .  $quota . '</td>
				</tr>

				<!-- Linha em branco para separar o QR Code -->
				<tr class="blank">
					<td></td>
					<td></td>
				</tr>

				<!-- QR Code -->
				<tr class="qr-code">
					<td></td>
					<td style="text-align: right; font-size: 14px;"><b>ORIGINAL ' . $unique_id . '</b>
					<img style="width: 300px; height: 300px;" src="https://qrcode.tec-it.com/API/QRCode?data=' . $caminho_arquivo . '" title="Link para a fatura" /></td>
				</tr>
			</table>
		</div>
		<div style="margin-top: 12%" class="footer">
			<p style="text-align: center; font-size: 12px;">XXXX-Processado por programa certificado n. XXXX/AT -> GMEA®</p>
		</div>
	</body>
</html>
';


// Agregando el contenido de nuestro pdf al payoload de descarga
$dompdf->loadHtml($htmlTemplate);

// Asignacion del tamaño
$dompdf->setPaper('A4','landscape');

// Unificacion de todo los parametros enviados a nuestra clase para presentarlo en pantalla
$dompdf->render();

// Creadno de archivo pdf y descarga con un nombre dinamico
$dompdf->stream($contenidoDinamico);

$cod_socio = 's' . $socio;

$query = "INSERT INTO faturas (num_fatura, user, unique_id, valor) VALUES ('$num_fatura' ,'$cod_socio', '$unique_id', '$quota')";
mysqli_query($conexao, $query);

$nome_arquivo = $contenidoDinamico . '.pdf';

$caminho_arquivo = '../faturas/' . $nome_arquivo;

file_put_contents($caminho_arquivo, $dompdf->output());

// Código para forçar o download do arquivo para o navegador
header('Content-Description: File Transfer');
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $nome_arquivo . '"');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($caminho_arquivo));

readfile($caminho_arquivo);


?>