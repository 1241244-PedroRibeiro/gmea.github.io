<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userOuTurma = $mysqli->real_escape_string($_POST['userOuTurma']);
    $disciplina = $mysqli->real_escape_string($_POST['disciplina']);
    $tipoAvaliacao = $mysqli->real_escape_string($_POST['tipoAvaliacao']);

    // Definir a tabela com base no tipo de avaliação selecionado
    $tabela = ($tipoAvaliacao == 1 || $tipoAvaliacao == 2) ? 'pautas_avaliacao_intercalar' : 'pautas_avaliacao';

    $query = "SELECT * FROM $tabela WHERE userOuTurma = '$userOuTurma' AND disciplina = '$disciplina' AND semestre = '$tipoAvaliacao'";
    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $userDoCard = $row['user'];
            $queryNome = "SELECT nome, foto FROM users1 WHERE user = '$userDoCard'";
            $resultNome = $mysqli->query($queryNome);
            if ($resultNome && $resultNome->num_rows > 0) {
                while ($rowuser = $resultNome->fetch_assoc()) {
                    $nomeDoAluno = $rowuser['nome'];
                    $fotoDoAluno = $rowuser['foto'];
                }
            }
            // Construir HTML para o card exibindo os resultados
            $cardHtml = '<div class="custom-card card col-lg-4 col-md-6 mb-4">';
            $cardHtml .= '<img src="' . $fotoDoAluno . '" class="card-img-top" alt="Foto">';
            $cardHtml .= '<div class="card-body">';
            $cardHtml .= '<h5 class="card-title">' . $userDoCard . ' - ' . $nomeDoAluno . '</h5>';
            // Adicionando um input hidden
            $id_pauta = $row['id_pauta']; // Defina o valor que deseja para o input hidden
            $cardHtml .= '<input type="hidden" name="id_pauta" value="' . $id_pauta . '">';

            if ($tipoAvaliacao == '1' || $tipoAvaliacao == '2') {
                // Opções de seleção para avaliações intercalares
                $cardHtml .= '<div class="form-group">';
                $cardHtml .= '<label for="aproveitamento">Aproveitamento:</label>';
                $aproveitamentoValue = $row['par1'];
                $cardHtml .= '<select class="form-control" name="aproveitamento" required>';
                $cardHtml .= '<option value="">Selecionar</option>';
                $cardHtml .= '<option value="0" ' . ($aproveitamentoValue == 0 ? 'selected' : '') . '>Nível 0 - Não existem dados suficientes para avaliar</option>';
                $cardHtml .= '<option value="1" ' . ($aproveitamentoValue == 1 ? 'selected' : '') . '>Nível 1 - Apresenta um aproveitamento fraco</option>';
                $cardHtml .= '<option value="2" ' . ($aproveitamentoValue == 2 ? 'selected' : '') . '>Nível 2 - Apresenta um mau aproveitamento</option>';
                $cardHtml .= '<option value="3" ' . ($aproveitamentoValue == 3 ? 'selected' : '') . '>Nível 3 - Apresenta um aproveitamento razoável</option>';
                $cardHtml .= '<option value="4" ' . ($aproveitamentoValue == 4 ? 'selected' : '') . '>Nível 4 - Apresenta um bom aproveitamento</option>';
                $cardHtml .= '<option value="5" ' . ($aproveitamentoValue == 5 ? 'selected' : '') . '>Nível 5 - Apresenta um ótimo aproveitamento</option>';
                $cardHtml .= '</select>';
                $cardHtml .= '</div>';

                $atitudesValue = $row['par2'];  // Obtém o valor para Atitudes e Valores

                $cardHtml .= '<div class="form-group">';
                $cardHtml .= '<label for="atitudes">Atitudes e Valores:</label>';
                $cardHtml .= '<select class="form-control" name="atitudes" required>';
                $cardHtml .= '<option value="">Selecionar</option>';
                $cardHtml .= '<option value="0" ' . ($atitudesValue == 0 ? 'selected' : '') . '>Nível 0 - Não existem dados suficientes para avaliar</option>';
                $cardHtml .= '<option value="1" ' . ($atitudesValue == 1 ? 'selected' : '') . '>Nível 1 - Revela um fraco comportamento</option>';
                $cardHtml .= '<option value="2" ' . ($atitudesValue == 2 ? 'selected' : '') . '>Nível 2 - Apresenta um mau comportamento</option>';
                $cardHtml .= '<option value="3" ' . ($atitudesValue == 3 ? 'selected' : '') . '>Nível 3 - Revela um comportamento razoável</option>';
                $cardHtml .= '<option value="4" ' . ($atitudesValue == 4 ? 'selected' : '') . '>Nível 4 - Revela um bom comportamento</option>';
                $cardHtml .= '<option value="5" ' . ($atitudesValue == 5 ? 'selected' : '') . '>Nível 5 - Demonstra um ótimo comportamento</option>';
                $cardHtml .= '</select>';
                $cardHtml .= '</div>';
                

                $empenhoValue = $row['par3'];  // Obtém o valor para Empenho e Cumprimento de Tarefas

                $cardHtml .= '<div class="form-group">';
                $cardHtml .= '<label for="empenho">Empenho e Cumprimento de Tarefas:</label>';
                $cardHtml .= '<select class="form-control" name="empenho" required>';
                $cardHtml .= '<option value="">Selecionar</option>';
                $cardHtml .= '<option value="0" ' . ($empenhoValue == 0 ? 'selected' : '') . '>Nível 0 - Não existem dados suficientes para avaliar</option>';
                $cardHtml .= '<option value="1" ' . ($empenhoValue == 1 ? 'selected' : '') . '>Nível 1 - Não revela interesse nem demonstra boa compreensão de conceitos</option>';
                $cardHtml .= '<option value="2" ' . ($empenhoValue == 2 ? 'selected' : '') . '>Nível 2 - Revela pouco interesse e fraca compreensão de conceitos</option>';
                $cardHtml .= '<option value="3" ' . ($empenhoValue == 3 ? 'selected' : '') . '>Nível 3 - Revela algum interesse e razoável compreensão de conceitos</option>';
                $cardHtml .= '<option value="4" ' . ($empenhoValue == 4 ? 'selected' : '') . '>Nível 4 - Revela interesse e boa compreensão de conceitos</option>';
                $cardHtml .= '<option value="5" ' . ($empenhoValue == 5 ? 'selected' : '') . '>Nível 5 - Revela bastante interesse e ótima compreensão de conceitos</option>';
                $cardHtml .= '</select>';
                $cardHtml .= '</div>';
                

                $observacoesValue = $row['notas'];  // Obtém o valor para Observações

                $cardHtml .= '<div class="form-group">';
                $cardHtml .= '<label for="observacoes">Observações:</label>';
                $cardHtml .= '<textarea class="form-control" name="observacoes" rows="3">' . htmlspecialchars($observacoesValue) . '</textarea>';
                $cardHtml .= '</div>';
                
            } elseif ($tipoAvaliacao == '3' || $tipoAvaliacao == '4') {
                // Opções de seleção para avaliações finais
                $escalaValue = $row['escala'];  // Obtém o valor da escala do banco de dados

                $cardHtml .= '<div class="form-group">';
                $cardHtml .= '<label for="escala">Escala:</label>';
                $cardHtml .= '<select class="form-control" name="escala" required>';
                
                // Opções da escala com pré-seleção
                $cardHtml .= '<option value="1" ' . ($escalaValue == '1' ? 'selected' : '') . '>0 a 5</option>';
                $cardHtml .= '<option value="2" ' . ($escalaValue == '2' ? 'selected' : '') . '>0 a 20</option>';
                
                $cardHtml .= '</select>';
                $cardHtml .= '</div>';
                

                // Opções de seleção comuns para todos os tipos de avaliação final
                $cardHtml .= '<div class="form-group">';
                $cardHtml .= '<label for="aproveitamento">Aproveitamento:</label>';
                $aproveitamentoValue = $row['par1'];
                $cardHtml .= '<select class="form-control" name="aproveitamento" required>';
                $cardHtml .= '<option value="">Selecionar</option>';
                $cardHtml .= '<option value="0" ' . ($aproveitamentoValue == 0 ? 'selected' : '') . '>Nível 0 - Não existem dados suficientes para avaliar</option>';
                $cardHtml .= '<option value="1" ' . ($aproveitamentoValue == 1 ? 'selected' : '') . '>Nível 1 - Apresenta um aproveitamento fraco</option>';
                $cardHtml .= '<option value="2" ' . ($aproveitamentoValue == 2 ? 'selected' : '') . '>Nível 2 - Apresenta um mau aproveitamento</option>';
                $cardHtml .= '<option value="3" ' . ($aproveitamentoValue == 3 ? 'selected' : '') . '>Nível 3 - Apresenta um aproveitamento razoável</option>';
                $cardHtml .= '<option value="4" ' . ($aproveitamentoValue == 4 ? 'selected' : '') . '>Nível 4 - Apresenta um bom aproveitamento</option>';
                $cardHtml .= '<option value="5" ' . ($aproveitamentoValue == 5 ? 'selected' : '') . '>Nível 5 - Apresenta um ótimo aproveitamento</option>';
                $cardHtml .= '</select>';
                $cardHtml .= '</div>';

                $atitudesValue = $row['par2'];  // Obtém o valor para Atitudes e Valores

                $cardHtml .= '<div class="form-group">';
                $cardHtml .= '<label for="atitudes">Atitudes e Valores:</label>';
                $cardHtml .= '<select class="form-control" name="atitudes" required>';
                $cardHtml .= '<option value="">Selecionar</option>';
                $cardHtml .= '<option value="0" ' . ($atitudesValue == 0 ? 'selected' : '') . '>Nível 0 - Não existem dados suficientes para avaliar</option>';
                $cardHtml .= '<option value="1" ' . ($atitudesValue == 1 ? 'selected' : '') . '>Nível 1 - Revela um fraco comportamento</option>';
                $cardHtml .= '<option value="2" ' . ($atitudesValue == 2 ? 'selected' : '') . '>Nível 2 - Apresenta um mau comportamento</option>';
                $cardHtml .= '<option value="3" ' . ($atitudesValue == 3 ? 'selected' : '') . '>Nível 3 - Revela um comportamento razoável</option>';
                $cardHtml .= '<option value="4" ' . ($atitudesValue == 4 ? 'selected' : '') . '>Nível 4 - Revela um bom comportamento</option>';
                $cardHtml .= '<option value="5" ' . ($atitudesValue == 5 ? 'selected' : '') . '>Nível 5 - Demonstra um ótimo comportamento</option>';
                $cardHtml .= '</select>';
                $cardHtml .= '</div>';
                

                $empenhoValue = $row['par3'];  // Obtém o valor para Empenho e Cumprimento de Tarefas

                $cardHtml .= '<div class="form-group">';
                $cardHtml .= '<label for="empenho">Empenho e Cumprimento de Tarefas:</label>';
                $cardHtml .= '<select class="form-control" name="empenho" required>';
                $cardHtml .= '<option value="">Selecionar</option>';
                $cardHtml .= '<option value="0" ' . ($empenhoValue == 0 ? 'selected' : '') . '>Nível 0 - Não existem dados suficientes para avaliar</option>';
                $cardHtml .= '<option value="1" ' . ($empenhoValue == 1 ? 'selected' : '') . '>Nível 1 - Não revela interesse nem demonstra boa compreensão de conceitos</option>';
                $cardHtml .= '<option value="2" ' . ($empenhoValue == 2 ? 'selected' : '') . '>Nível 2 - Revela pouco interesse e fraca compreensão de conceitos</option>';
                $cardHtml .= '<option value="3" ' . ($empenhoValue == 3 ? 'selected' : '') . '>Nível 3 - Revela algum interesse e razoável compreensão de conceitos</option>';
                $cardHtml .= '<option value="4" ' . ($empenhoValue == 4 ? 'selected' : '') . '>Nível 4 - Revela interesse e boa compreensão de conceitos</option>';
                $cardHtml .= '<option value="5" ' . ($empenhoValue == 5 ? 'selected' : '') . '>Nível 5 - Revela bastante interesse e ótima compreensão de conceitos</option>';
                $cardHtml .= '</select>';
                $cardHtml .= '</div>';
                

                // Campos adicionais para avaliações finais
                $observacoesValue = $row['notas'];  // Obtém o valor para Observações

                $cardHtml .= '<div class="form-group">';
                $cardHtml .= '<label for="observacoes">Observações:</label>';
                $cardHtml .= '<textarea class="form-control" name="observacoes" rows="3">' . htmlspecialchars($observacoesValue) . '</textarea>';
                $cardHtml .= '</div>';

                $cardHtml .= '<div class="form-group">';
                $cardHtml .= '<label for="media">Média das Avaliações:</label>';
                $cardHtml .= '<input type="text" class="form-control" name="media" disabled>';
                $cardHtml .= '</div>';

                $cardHtml .= '<div class="form-group">';
                $cardHtml .= '<label for="sugestao_nivel">Sugestão de Nível:</label>';
                $cardHtml .= '<input type="text" class="form-control" name="sugestao_nivel" readonly value="0">';
                $cardHtml .= '</div>';

                $cardHtml .= '<div class="form-group">';
                $cardHtml .= '<label for="nivel">Nível:</label>';
                $cardHtml .= '<select class="form-control" name="nivel" required>';
                $cardHtml .= '<option value="">Selecionar</option>';
                
                // Determinar as opções com base na escala selecionada
                if ($row['escala'] == '1') {
                    // Escala de 0 a 5
                    for ($i = 0; $i <= 5; $i++) {
                        $selected = ($i == $row['nivel']) ? 'selected' : '';  // Verifica se este é o valor selecionado
                        $cardHtml .= '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
                    }
                } elseif ($row['escala'] == '2') {
                    // Escala de 0 a 20
                    for ($i = 0; $i <= 20; $i++) {
                        $selected = ($i == $row['nivel']) ? 'selected' : '';  // Verifica se este é o valor selecionado
                        $cardHtml .= '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
                    }
                }
                
                $cardHtml .= '</select>';
                $cardHtml .= '</div>';
                
            }

            $cardHtml .= '</div>';
            $cardHtml .= '</div>';
            $cardHtml .= '</div>';


            echo $cardHtml;
        }
    } else {
        echo '<div class="col"><p>Não foram encontrados resultados.</p></div>';
    }
    $result->free();
}
?>
