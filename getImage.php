<?php
if (isset($_GET['animalID'])) {
    $animalID = $_GET['animalID'];

    require_once("conexao.php");

    $sql = "SELECT foto FROM Animal WHERE animalID = :animalID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':animalID', $animalID, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        header("Content-type: image/jpeg"); // Certifique-se de definir o tipo de conteúdo correto
        echo $row['foto'];
    } else {
        echo "Imagem não encontrada.";
    }

    $conn = null;
}
?>
