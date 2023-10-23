<?php
session_start();
include "./generals/config.php";
$mysqli = new mysqli($bd_host, $bd_user, $bd_password, $bd_database);

if ($mysqli->connect_error) {
    die('Erro: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if (empty($_SESSION["session_id"]) || $_SESSION["type"] != 3) {
    header("Location: ../index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["action"] == "add") {
        $serviceDate = $_POST["date"];
        $serviceLocation = $_POST["location"];
        $serviceTime = $_POST['time'];
        $serviceType = $_POST["type"];

        // Converte a hora para o formato 'hh:mm'
        $serviceTime = date('H:i', strtotime($serviceTime));

        $query = "INSERT INTO servicos (data_servico, local_servico, tipo_servico, hora_servico, estado) VALUES ('$serviceDate', '$serviceLocation', '$serviceType', '$serviceTime', 1)";
        if ($mysqli->query($query)) {
            echo '<br>';
            echo '<div class="alert alert-success" role="alert">Serviço adicionado com sucesso!</div>';
        } else {
            echo '<br>';
            echo '<div class="alert alert-danger" role="alert">Erro ao adicionar serviço. Por favor, tente novamente.</div>';
        }
    } else if ($_POST["action"] == "update") {
            $serviceID = $_POST["id"];
            $serviceDate = $_POST["date"];
            $serviceLocation = $_POST["location"];
            $updatedServiceTime = $_POST["time"];
            $updatedServiceType = $_POST["type"];
            
            $query = "UPDATE servicos SET data_servico='$serviceDate', local_servico='$serviceLocation', hora_servico='$updatedServiceTime', tipo_servico='$updatedServiceType' WHERE id_servico='$serviceID'";        
            if ($mysqli->query($query)) {
                echo '<br>';
                echo '<div class="alert alert-success" role="alert">Serviço atualizado com sucesso!</div>';
            } else {
                echo '<br>';
                echo '<div class="alert alert-danger" role="alert">Erro ao atualizar serviço. Por favor, tente novamente.</div>';
            }
    } else if ($_POST["action"] == "delete") {
        $serviceID = $_POST["service"];

        $query = "UPDATE servicos SET estado = 0 WHERE id_servico='$serviceID'";
        if ($mysqli->query($query)) {
            echo '<br>';
            echo '<div class="alert alert-success" role="alert">Serviço eliminado com sucesso!</div>';
        } else {
            echo '<br>';
            echo '<div class="alert alert-danger" role="alert">Erro ao eliminar serviço. Por favor, tente novamente.</div>';
        }
    }

    exit;
}

// Obter os serviços existentes
$serviceQuery = "SELECT id_servico, data_servico, local_servico FROM servicos WHERE estado = 1";
$serviceResult = $mysqli->query($serviceQuery);
$services = [];
while ($row = $serviceResult->fetch_assoc()) {
    $services[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GMEA - Gerir Alunos</title>
    <link rel="shortcut icon" type="image/png" href="media/logo.png" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
</head>
<body>


    <div style="margin-top: 0;">
        <img style="width: 100%; height: auto;" src="./media/topAR.png" class="img-responsive">
    </div>

    <?php
        include "header-direcao.php";
    ?>


    <div class="container">
        <h1>Gestão de Serviços</h1>
        
        <form id="serviceForm">
            <div class="mb-3">
                <label for="selectOption" class="form-label">Selecione uma opção:</label>
                <select class="form-select" id="selectOption">
                    <option value="">-- Selecione --</option>
                    <option value="add">Adicionar Serviço</option>
                    <option value="manage">Gerir Serviço</option>
                    <option value="delete">Eliminar Serviço</option>
                </select>
            </div>
            
            <button style="background-color: #00631b; border-color: black;" type="button" class="btn btn-primary" id="proceedBtn" disabled>Prosseguir</button>
        </form>
        
        <div id="serviceContent" style="display: none;">
            <h2></h2>
            
            <div id="addServiceForm" style="display: none;">
                <form>
                    <div class="mb-3">
                        <label for="serviceDate" class="form-label">Data do Serviço:</label>
                        <input type="date" class="form-control" id="serviceDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="serviceTime" class="form-label">Hora do Serviço:</label>
                        <input type="time" class="form-control" id="serviceTime" required>
                    </div>
                    <div class="mb-3">
                        <label for="serviceLocation" class="form-label">Local do Serviço:</label>
                        <input type="text" class="form-control" id="serviceLocation" required>
                    </div>
                    <div class="mb-3">
                        <label for="serviceType" class="form-label">Tipo de Serviço:</label>
                        <select class="form-select" id="serviceType" required>
                            <option value="">-- Selecione --</option>
                            <option value="Concerto">Concerto</option>
                            <option value="Procissão">Procissão</option>
                            <option value="Missa">Missa</option>
                            <option value="Casamento">Casamento</option>
                            <option value="Missa + Procissão">Missa + Procissão</option>
                            <option value="Procissão + Concerto">Procissão + Concerto</option>
                            <option value="Missa + Procissão + Concerto">Missa + Procissão + Concerto</option>
                        </select>
                    </div>
                    <button style="background-color: #00631b; border-color: black;" type="submit" class="btn btn-primary">Inserir</button>
                </form>
            </div>

            
            <div id="manageServiceForm" style="display: none;">
                <label for="selectService" class="form-label">Selecione um serviço:</label>
                <select class="form-select" id="selectService">
                    <option value="">-- Selecione --</option>
                    <?php foreach ($services as $service): ?>
                        <option value="<?php echo $service['id_servico']; ?>"><?php echo $service['id_servico'] . ' - ' . $service['local_servico'] . ' - ' . $service['data_servico']; ?></option>
                    <?php endforeach; ?>
                </select>
                <br>
                <button style="background-color: #00631b; border-color: black;" type="button" class="btn btn-primary" id="proceedManageBtn" disabled>Prosseguir</button>
            </div>
            
            <div id="updateServiceForm" style="display: none;">
                <form>
                    <div class="mb-3">
                        <label for="serviceDateUpdate" class="form-label">Data do Serviço:</label>
                        <input type="date" class="form-control" id="serviceDateUpdate" required>
                    </div>
                    <div class="mb-3">
                        <label for="serviceLocationUpdate" class="form-label">Local do Serviço:</label>
                        <input type="text" class="form-control" id="serviceLocationUpdate" required>
                    </div>
                    <div class="mb-3">
                        <label for="serviceTimeUpdate" class="form-label">Hora do Serviço:</label>
                        <input type="time" class="form-control" id="serviceTimeUpdate" required>
                    </div>
                    <div class="mb-3">
                        <label for="serviceTypeUpdate" class="form-label">Tipo de Serviço:</label>
                        <select class="form-select" id="serviceTypeUpdate" required>
                            <option value="">-- Selecione --</option>
                            <option value="Concerto">Concerto</option>
                            <option value="Procissão">Procissão</option>
                            <option value="Missa">Missa</option>
                            <option value="Casamento">Casamento</option>
                            <option value="Missa + Procissão">Missa + Procissão</option>
                            <option value="Procissão + Concerto">Procissão + Concerto</option>
                            <option value="Missa + Procissão + Concerto">Missa + Procissão + Concerto</option>
                        </select>
                    </div>
                    <button style="background-color: #00631b; border-color: black;" type="submit" class="btn btn-primary">Atualizar</button>
                </form>
            </div>
            
            <div id="deleteServiceForm" style="display: none;">
                <label for="selectServiceDelete" class="form-label">Selecione um serviço:</label>
                <select class="form-select" id="selectServiceDelete">
                    <option value="">-- Selecione --</option>
                    <?php foreach ($services as $service): ?>
                        <option value="<?php echo $service['id_servico']; ?>"><?php echo $service['id_servico'] . ' - ' . $service['local_servico'] . ' - ' . $service['data_servico']; ?></option>
                    <?php endforeach; ?>
                </select>
                <br>
                <button type="button" class="btn btn-danger" id="deleteBtn">Eliminar Serviço</button>
            </div>
            
            <div id="resultMessage" style="display: none;"></div>
        </div>
    </div>
    
    <script>
        document.getElementById("selectOption").addEventListener("change", function() {
            var selectedOption = this.value;
            document.getElementById("proceedBtn").disabled = (selectedOption === "");

            var serviceContent = document.getElementById("serviceContent");
            var addServiceForm = document.getElementById("addServiceForm");
            var manageServiceForm = document.getElementById("manageServiceForm");
            var updateServiceForm = document.getElementById("updateServiceForm");
            var deleteServiceForm = document.getElementById("deleteServiceForm");
            var resultMessage = document.getElementById("resultMessage");

            addServiceForm.style.display = "none";
            manageServiceForm.style.display = "none";
            updateServiceForm.style.display = "none";
            deleteServiceForm.style.display = "none";
            resultMessage.style.display = "none";

            if (selectedOption === "add") {
                serviceContent.style.display = "block";
                addServiceForm.style.display = "block";
                document.getElementById("serviceDate").value = "";
                document.getElementById("serviceLocation").value = "";
                document.getElementById("resultMessage").innerHTML = "";
            } else if (selectedOption === "manage") {
                serviceContent.style.display = "block";
                manageServiceForm.style.display = "block";
                document.getElementById("selectService").value = "";
                document.getElementById("proceedManageBtn").disabled = true;
                document.getElementById("resultMessage").innerHTML = "";
            } else if (selectedOption === "delete") {
                serviceContent.style.display = "block";
                deleteServiceForm.style.display = "block";
                document.getElementById("selectService").value = "";
                document.getElementById("resultMessage").innerHTML = "";
            } else {
                serviceContent.style.display = "none";
            }
        });

        document.getElementById("selectService").addEventListener("change", function() {
            var selectedService = this.value;
            document.getElementById("proceedManageBtn").disabled = (selectedService === "");

            var updateServiceForm = document.getElementById("updateServiceForm");
            updateServiceForm.style.display = "none";

            if (selectedService !== "") {
                var serviceInfo = selectedService.split(" - ");
                document.getElementById("serviceDateUpdate").value = serviceInfo[2];
                document.getElementById("serviceLocationUpdate").value = serviceInfo[1];
                document.getElementById("serviceTimeUpdate").value = ""; // Limpa o valor anterior
                document.getElementById("serviceTypeUpdate").value = ""; // Limpa o valor anterior
            }
        });

        document.getElementById("proceedManageBtn").addEventListener("click", function() {
            var selectedService = document.getElementById("selectService").value;
            if (selectedService !== "") {
                var updateServiceForm = document.getElementById("updateServiceForm");
                updateServiceForm.style.display = "block";

                var serviceInfo = selectedService.split(" - ");
                document.getElementById("serviceTimeUpdate").value = serviceInfo[3];
                document.getElementById("serviceTypeUpdate").value = serviceInfo[4];
            }
        });

        document.getElementById("addServiceForm").addEventListener("submit", function(event) {
            event.preventDefault();
            
            var serviceDate = document.getElementById("serviceDate").value;
            var serviceTime = document.getElementById("serviceTime").value;
            var serviceLocation = document.getElementById("serviceLocation").value;
            var serviceType = document.getElementById("serviceType").value;
            
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    var resultMessage = document.getElementById("resultMessage");
                    resultMessage.innerHTML = this.responseText;
                    resultMessage.style.display = "block";
                }
            };
            xhttp.open("POST", "<?php echo $_SERVER['PHP_SELF']; ?>", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("action=add&date=" + serviceDate + "&time=" + serviceTime + "&location=" + serviceLocation + "&type=" + serviceType);
        });


        document.getElementById("updateServiceForm").addEventListener("submit", function(event) {
            event.preventDefault();

            var selectedService = document.getElementById("selectService").value;
            if (selectedService !== "") {
                var serviceID = selectedService.split(" - ")[0];
                var serviceDate = document.getElementById("serviceDateUpdate").value;
                var serviceLocation = document.getElementById("serviceLocationUpdate").value;
                var serviceTime = document.getElementById("serviceTimeUpdate").value;
                var serviceType = document.getElementById("serviceTypeUpdate").value;

                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState === 4 && this.status === 200) {
                        var resultMessage = document.getElementById("resultMessage");
                        resultMessage.innerHTML = this.responseText;
                        resultMessage.style.display = "block";
                    }
                };
                xhttp.open("POST", "<?php echo $_SERVER['PHP_SELF']; ?>", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("action=update&id=" + serviceID + "&date=" + serviceDate + "&location=" + serviceLocation + "&time=" + serviceTime + "&type=" + serviceType);
            }
        });

        document.getElementById("deleteBtn").addEventListener("click", function() {
            var selectedService = document.getElementById("selectServiceDelete").value;
            if (selectedService !== "") {
                var serviceID = selectedService.split(" - ")[0];

                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState === 4 && this.status === 200) {
                        var resultMessage = document.getElementById("resultMessage");
                        resultMessage.innerHTML = this.responseText;
                        resultMessage.style.display = "block";
                    }
                };
                xhttp.open("POST", "<?php echo $_SERVER['PHP_SELF']; ?>", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("action=delete&service=" + serviceID);
            }
        });
    </script>
</body>

<?php

    include "footer-reservado.php";

?>


</html>