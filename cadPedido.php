<?php
require_once('conexao.php');
session_start(); // Certifique-se de que a sessão está iniciada

$adotanteID = $_SESSION['idUsuarioLogado'];

// Trocar para 60 SECOND
$sql = "SELECT COUNT(*) AS click_count 
        FROM lista_espera 
        WHERE adotanteID = :adotanteID 
        AND data >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':adotanteID', $adotanteID, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$click_count = $result['click_count'];

if ($click_count >= 1) {
    echo "Você atingiu o limite de 1 adoções neste mês. Por favor, tente novamente no próximo mês.";
    exit;
}

$data = $_POST['data'] ?? null;
$status = $_POST['status'] ?? null;
$adotanteID = $_POST['adotanteID'] ?? null;
$animalID = $_POST['animalID'] ?? null;

if ($data && $status && $adotanteID && $animalID) {
    $conn->beginTransaction();
    try {
        // Inserir dados na tabela lista_espera
        $sql = "INSERT INTO lista_espera (data, status, adotanteID, animalID) VALUES (:data, :status, :adotanteID, :animalID)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':adotanteID', $adotanteID, PDO::PARAM_INT);
        $stmt->bindParam(':animalID', $animalID, PDO::PARAM_INT);
        $stmt->execute();

        // Atualizar a disponibilidade do animal na tabela Animal
        $sql = "UPDATE Animal SET disponibilidade = 'Indisponível' WHERE animalID = :animalID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':animalID', $animalID, PDO::PARAM_INT);
        $stmt->execute();

        $conn->commit();

        echo "<script>window.alert('Pedido de adoção cadastrado com sucesso.');
              window.location.href='adocao.php';</script>";
    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Erro ao cadastrar pedido de adoção: " . $e->getMessage();
    }
} else {
    echo "<script>window.alert('Todos os campos são obrigatórios.');
              window.location.href='adocao.php';</script>";
}
?>
