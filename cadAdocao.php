<?php
try {
    var_dump($_POST); // Adicione esta linha para verificar os dados do formulário

    // Verifica se todos os campos necessários estão preenchidos
    if (
        isset($_POST["ong"]) && !empty($_POST["ong"]) &&
        isset($_POST["data_escolha"]) && !empty($_POST["data_escolha"]) &&
        isset($_POST["dt_entrevista"]) && !empty($_POST["dt_entrevista"]) &&
        isset($_POST["data_adocaoaceita"]) && !empty($_POST["data_adocaoaceita"]) &&
        isset($_POST["dt_adocao"]) && !empty($_POST["dt_adocao"]) &&
        isset($_POST["entrevista"]) && !empty($_POST["entrevista"]) &&
        isset($_POST['adotanteID_hidden']) && !empty($_POST['adotanteID_hidden']) &&
        isset($_POST['animalID_hidden']) && !empty($_POST['animalID_hidden'])
    ) {
        $ong = $_POST['ong'];
        $data_escolha = $_POST['data_escolha'];
        $dt_entrevista = $_POST['dt_entrevista'];
        $data_adocaoaceita = $_POST['data_adocaoaceita'];
        $dt_adocao = $_POST['dt_adocao'];
        $entrevista = $_POST['entrevista'];
        $adotanteNome = $_POST['adotanteID_hidden'];
        $animalNome = $_POST['animalID_hidden'];

        require_once("conexao.php");

        // Inicia a transação
        $conn->beginTransaction();

        // Obtenha o ID numérico do adotante
        $sqlAdotante = "SELECT adotanteID FROM adotante WHERE CONCAT(nome, ' ', sobrenome) = :adotanteNome";
        $stmtAdotante = $conn->prepare($sqlAdotante);
        $stmtAdotante->bindParam(':adotanteNome', $adotanteNome);
        $stmtAdotante->execute();
        $adotante = $stmtAdotante->fetch(PDO::FETCH_ASSOC);

        if (!$adotante) {
            throw new Exception("Adotante não encontrado.");
        }

        // Obtenha o ID numérico do animal
        $sqlAnimal = "SELECT animalID FROM animal WHERE nome = :animalNome";
        $stmtAnimal = $conn->prepare($sqlAnimal);
        $stmtAnimal->bindParam(':animalNome', $animalNome);
        $stmtAnimal->execute();
        $animal = $stmtAnimal->fetch(PDO::FETCH_ASSOC);

        if (!$animal) {
            throw new Exception("Animal não encontrado.");
        }

        $adotanteID = $adotante['adotanteID'];
        $animalID = $animal['animalID'];

        $sql = "INSERT INTO Adocao (ong, data_escolha, dt_entrevista, data_adocaoaceita, dt_adocao, entrevista, adotanteID, animalID) 
        VALUES (:ong, :data_escolha, :dt_entrevista, :data_adocaoaceita, :dt_adocao, :entrevista, :adotanteID, :animalID)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':ong', $ong);
        $stmt->bindParam(':data_escolha', $data_escolha);
        $stmt->bindParam(':dt_entrevista', $dt_entrevista);
        $stmt->bindParam(':data_adocaoaceita', $data_adocaoaceita);
        $stmt->bindParam(':dt_adocao', $dt_adocao);
        $stmt->bindParam(':entrevista', $entrevista);
        $stmt->bindParam(':adotanteID', $adotanteID);
        $stmt->bindParam(':animalID', $animalID);
        $stmt->execute();

        $sqlAnimal = "UPDATE Animal SET dt_saida = :dt_adocao, disponibilidade = 'Indisponível' WHERE animalID = :animalID";
        $stmtAnimal = $conn->prepare($sqlAnimal);
        $stmtAnimal->bindParam(':dt_adocao', $dt_adocao);
        $stmtAnimal->bindParam(':animalID', $animalID);
        $stmtAnimal->execute();

        // Adicione a exclusão da entrada na lista de espera
        $sqlListaEspera = "DELETE FROM lista_espera WHERE adotanteID = :adotanteID AND animalID = :animalID";
        $stmtListaEspera = $conn->prepare($sqlListaEspera);
        $stmtListaEspera->bindParam(':adotanteID', $adotanteID);
        $stmtListaEspera->bindParam(':animalID', $animalID);
        $stmtListaEspera->execute();

        // Confirma a transação
        $conn->commit();

        echo "Adoção registrada, animal atualizado e entrada na lista de espera removida com sucesso!";
                 
        // Redirecionamento após a inserção bem-sucedida
        header("Location:adocao.php");
        exit();
    } else {
        echo "<p>Algum campo está vazio. Verifique e tente novamente.</p>";
    }
} catch (Exception $e) {
    // Reverte a transação em caso de erro
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    echo $sql . "<br>" . $e->getMessage();
}
?>
