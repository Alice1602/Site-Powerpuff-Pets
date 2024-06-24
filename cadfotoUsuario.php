<?php
session_start();
require_once("conexao.php");

try {
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $imagem = $_FILES['foto'];
        $tipoimagem = $imagem['type'];
        define('TAMANHO_MAXIMO', (2 * 1024 * 1024)); // 2 MB

        $tamanho = $imagem['size'];

        // Validações básicas
        // Formato
        if (!preg_match('/^image\/(pjpeg|jpeg|png|gif|bmp)$/', $tipoimagem)) {
            echo 'Não é uma imagem válida';
            exit;
        }

        // Tamanho
        if ($tamanho > TAMANHO_MAXIMO) {
            echo 'A imagem deve possuir no máximo 2 MB';
            exit;
        }

        // Transformando foto em dados (binário)
        $foto = file_get_contents($imagem['tmp_name']);

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
                    echo 'Tipo de usuário inválido.';
                    exit();
            }

            // Atualizar os dados no banco de dados
            $sql = "UPDATE $tabela 
                    SET foto = :foto 
                    WHERE $idCampo = :idUsuario";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':foto', $foto, PDO::PARAM_LOB);
            $stmt->bindParam(':idUsuario', $idUsuarioLogado, PDO::PARAM_INT);

            $stmt->execute();

            echo "<script>window.alert('Foto de perfil atualizada com sucesso.');
                window.location.href='powerfullpets.php';</script>";
            exit();
        } else {
            echo 'Usuário não autenticado.';
            echo "<script>window.alert('Todos os campos são obrigatórios.');
              window.location.href='adocao.php';</script>";
            exit();
        }
    } else {
        echo "<p>Erro no upload da imagem.</p>"; 
        echo "<script>window.alert('Todos os campos são obrigatórios.');
              window.location.href='adocao.php';</script>";
        var_dump($_FILES); // Mostrar os dados enviados para depuração
    }

} catch(Exception $e) {
    echo "<br>" . $e->getMessage();
}

$conn = null;
?>
