<?php
session_start();
require_once("conexao.php");

if (isset($_SESSION['idUsuarioLogado']) && isset($_SESSION['nivelUsuario'])) {
    $idUsuarioLogado = $_SESSION['idUsuarioLogado'];
    $nivelUsuario = $_SESSION['nivelUsuario'];

    // Definir a tabela e o campo de ID baseado no nível do usuário
    switch ($nivelUsuario) {
        case 'USR':
            $tabela = 'Adotante';
            $idCampo = 'adotanteID';
            break;
        case 'COLAB':
            $tabela = 'Colaboradores';
            $idCampo = 'id_colaborador';
            break;
        case 'ONG':
            $tabela = 'ONG';
            $idCampo = 'id_ong';
            break;
        case 'ADM':
            $tabela = 'Donas';
            $idCampo = 'id';
            break;
        default:
            // Caso o nível do usuário não seja reconhecido
            header("Content-Type: images/fotoPerfil.jpg");
            readfile("images/default-profile.jpg");
            exit();
    }

    // Preparar e executar a consulta
    $sql = "SELECT foto FROM $tabela WHERE $idCampo = :idUsuario";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':idUsuario', $idUsuarioLogado, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && !empty($result['foto'])) {
        header("Content-Type: images/fotoPerfil.jpg");
        echo $result['foto'];
    } else {
        // Exibir uma imagem padrão caso o usuário não tenha foto
        header("Content-Type: images/fotoPerfil.jpg");
        readfile("images/default-profile.jpg");
    }
} else {
    // Exibir uma imagem padrão caso o usuário não esteja logado
    header("Content-Type: images/fotoPerfil.jpg");
    readfile("images/default-profile.jpg");
}

$conn = null;
?>
