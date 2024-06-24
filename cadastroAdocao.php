<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Adoção</title>
    <link rel="stylesheet" href="css/cadAdocao.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="images/logoGG.png">
</head>

<body>
    <p><b><a class="Home" href="powerfullpets.php" target="_blank">Início</a></b></p>
    <br><br><br><br><br><br> 

    <div id="main-container">
        <h1>Cadastro de adoção</h1><br>
        <br>
        <form class="form" id="registro-form" action="cadAdocao.php" method="post">
            <div class="half-box spacing">
                <label for="ong">Qual a sua ONG?</label>
                <select id="ong" name="ong" placeholder="Selecione">
                    <?php
                    require_once("conexao.php");
                    $sql = "SELECT * FROM ONG ORDER BY nome";
                    $dados = $conn->query($sql);
                    while ($registros = $dados->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . $registros['id_ong'] . "'>" . $registros['nome'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="half-box spacing">
                <label for="adotanteID">Nome adotante</label>
                <?php
                $adotanteID = isset($_GET['adotanteID']) ? $_GET['adotanteID'] : '';
                echo "<input type='text' name='adotanteID' value='$adotanteID' readonly>";
                ?>
            </div>

            <div class="half-box spacing">
                <label for="animalID">Nome animal</label>
                <?php
                $animalID = isset($_GET['animalID']) ? $_GET['animalID'] : '';
                echo "<input type='text' name='animalID' value='$animalID' readonly>";
                ?>
            </div>

            <div class="half-box spacing">
                <label for="data_escolha">Data da escolha do animal</label>
                <?php
                require_once("conexao.php");

                if (isset($_GET['adotanteID']) && isset($_GET['animalID'])) {
                    $adotanteNome = $_GET['adotanteID'];
                    $animalNome = $_GET['animalID'];

                    $sqlAdotante = "SELECT adotanteID FROM adotante WHERE CONCAT(nome, ' ', sobrenome) = :adotanteNome";
                    $stmtAdotante = $conn->prepare($sqlAdotante);
                    $stmtAdotante->bindParam(':adotanteNome', $adotanteNome);
                    $stmtAdotante->execute();
                    $adotante = $stmtAdotante->fetch(PDO::FETCH_ASSOC);

                    $sqlAnimal = "SELECT animalID FROM animal WHERE nome = :animalNome";
                    $stmtAnimal = $conn->prepare($sqlAnimal);
                    $stmtAnimal->bindParam(':animalNome', $animalNome);
                    $stmtAnimal->execute();
                    $animal = $stmtAnimal->fetch(PDO::FETCH_ASSOC);

                    if ($adotante && $animal) {
                        $adotanteID_num = $adotante['adotanteID'];
                        $animalID_num = $animal['animalID'];

                        $sql = "SELECT data FROM lista_espera WHERE adotanteID = :adotanteID AND animalID = :animalID ORDER BY data DESC LIMIT 1";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':adotanteID', $adotanteID_num);
                        $stmt->bindParam(':animalID', $animalID_num);
                        $stmt->execute();

                        if ($stmt->rowCount() > 0) {
                            $registro = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo "<input name='data_escolha' value='" . $registro['data'] . "' readonly>";
                        } else {
                            echo "Nenhuma data encontrada para este adotante e animal.";
                        }
                    } else {
                        echo "Adotante ou animal não encontrados.";
                    }
                } else {
                    echo "Parâmetros adotanteID e animalID não encontrados na URL.";
                }
                ?>
            </div>

            <div class="half-box spacing">
                <label for="dt_entrevista">Data da entrevista</label>
                <input type="date" name="dt_entrevista" id="dt_entrevista">
            </div>

            <div class="half-box spacing">
                <label for="data_adocaoaceita">Data que a adoção foi aprovada</label>
                <input type="date" name="data_adocaoaceita" id="data_adocaoaceita">
            </div>

            <div class="half-box spacing">
                <label for="dt_adocao">Data da entrega do animal</label>
                <input type="date" name="dt_adocao" id="dt_adocao">
            </div>

            <div class="half-box spacing">
                            <label for="disponibilidade">Disponibilidade</label>
                            <select id="disponibilidade" name="disponibilidade" placeholder="Selecione" value="<?php echo $registros['disponibilidade']; ?>">
                                <option value="" disabled selected hidden>Selecione</option>
                                <option value="Disponível">Disponível</option>
                                <option value="Indisponível">Indisponível</option>
                            </select>
                        </div>

            <div class="grande-box spacing">
                <label for="entrevista">Entrevista</label>
                <textarea class="texto" name="entrevista" rows="4" cols="100" placeholder="Conte como foi a entrevista?"></textarea>
            </div>

            <!-- Hidden inputs to store IDs -->
            <input type="hidden" name="adotanteID_hidden" id="adotanteID_hidden" value="<?php echo $adotanteID; ?>">
            <input type="hidden" name="animalID_hidden" id="animalID_hidden" value="<?php echo $animalID; ?>">
            <input type="hidden" name="pedidoID_hidden" id="pedidoID_hidden" value="<?php echo isset($_GET['pedidoID']) ? $_GET['pedidoID'] : ''; ?>">

            <div class="botao spacing">
                <input type="submit" value="Cadastrar">
            </div>
        </form>
    </div>
    </div>
    <p class="error-validation template"></p>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const adotanteID = urlParams.get('adotanteID');
        const animalID = urlParams.get('animalID');

        document.getElementById('adotanteID_hidden').value = adotanteID;
        document.getElementById('animalID_hidden').value = animalID;

        document.getElementById('adotanteID').value = adotanteID;
        document.getElementById('animalID').value = animalID;
    </script>
</body>

</html>
