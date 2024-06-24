<?php
require_once("cabecalho.php");

if (isset($_GET['id'])) {
    try {
        $id = $_GET['id'];
        require_once "conexao.php";

        // Primeiro, recupera o animalID do pedido de adoção
        $sql = "SELECT animalID FROM lista_espera WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $animalID = $result['animalID'];

            $conn->beginTransaction();

            // Exclui o pedido de adoção
            $sql = "DELETE FROM lista_espera WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            // Atualiza a disponibilidade do animal
            $sql = "UPDATE Animal SET disponibilidade = 'Disponível' WHERE animalID = :animalID";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':animalID', $animalID, PDO::PARAM_INT);
            $stmt->execute();

            $conn->commit();

            echo "<script>window.alert('Pedido de adoção excluído com sucesso.');
                  window.location.href='listaEspera.php';</script>";
        } else {
            echo "<script>window.alert('Pedido de adoção não encontrado.');
                  window.location.href='listaEspera.php';</script>";
        }
    } catch (Exception $erro) {
        $conn->rollBack();

        if ($erro->getCode() == 23000) {
            echo "<script>window.alert('Erro ao excluir: este usuário tem relacionamento com outra tabela');</script>";
        } else {
            echo "<p>Erro: " . $erro->getMessage() . "</p>";
        }
    }
} else {
    echo "<script>window.alert('Selecione um registro.');</script>";
}
?>
