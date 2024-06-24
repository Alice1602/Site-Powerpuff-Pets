<?php
try {
    if (isset($_POST["animalID"]) && isset($_POST["nome"]) && isset($_POST["raca"]) && isset($_POST["porte"]) && isset($_POST["sexo"]) 
    && isset($_POST["tipo_animal"]) && isset($_POST["disponibilidade"]) && isset($_POST["saude"]) && isset($_POST["historico"]) && isset($_POST["dt_entrada"]) && isset($_POST["dt_saida"])) {
        
        $animalID = $_POST['animalID'];
        $nome = $_POST['nome'];
        $raca = $_POST['raca'];
        $porte = $_POST['porte'];
        $idade = isset($_POST['idade']) ? $_POST['idade'] : null; // Verificação para idade
        $sexo = $_POST['sexo'];
        $tipo_animal = $_POST['tipo_animal'];
        $disponibilidade = $_POST['disponibilidade'];
        $saude = $_POST['saude'];
        $historico = $_POST['historico'];
        $dt_entrada = $_POST['dt_entrada'];
        $dt_saida = $_POST['dt_saida'];
        $foto = null;

        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $imagem = $_FILES['foto'];
            $tipoimagem = $imagem['type'];
            define('TAMANHO_MAXIMO', (2 * 1024 * 1024)); // 2 MB

            if ($imagem != NULL) {
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
            } else {
                echo "Você não realizou o upload de forma satisfatória.";
                exit;
            }
        }

        require_once("conexao.php");

        // Atualizar os dados no banco de dados
        $sql = "UPDATE Animal 
                SET nome = :nome, raca = :raca, porte = :porte, idade = :idade, sexo = :sexo, tipo_animal = :tipo_animal, 
                    disponibilidade = :disponibilidade, saude = :saude, historico = :historico, dt_entrada = :dt_entrada, 
                    dt_saida = :dt_saida, foto = :foto 
                WHERE animalID = :animalID";

        $stmt = $conn->prepare($sql);

        // Defina os parâmetros
        $stmt->bindParam(':animalID', $animalID, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':idade', $idade, PDO::PARAM_STR); // Alterado para PARAM_STR
        $stmt->bindParam(':sexo', $sexo, PDO::PARAM_STR);
        $stmt->bindParam(':tipo_animal', $tipo_animal, PDO::PARAM_STR);
        $stmt->bindParam(':raca', $raca, PDO::PARAM_STR);
        $stmt->bindParam(':porte', $porte, PDO::PARAM_STR);
        $stmt->bindParam(':saude', $saude, PDO::PARAM_STR);
        $stmt->bindParam(':historico', $historico, PDO::PARAM_STR);
        $stmt->bindParam(':dt_entrada', $dt_entrada, PDO::PARAM_STR);
        $stmt->bindParam(':dt_saida', $dt_saida, PDO::PARAM_STR);
        $stmt->bindParam(':disponibilidade', $disponibilidade, PDO::PARAM_STR);
        $stmt->bindParam(':foto', $foto, PDO::PARAM_LOB);

        $stmt->execute();

        // Redirecionar após o registro ser salvo
        header("Location: listarAnimais.php");
        exit();
    } else { 
        echo "<script>window.alert('Digite os dados.');</script>";
        var_dump($_POST); // Mostrar os dados enviados para depuração
    }
} catch(Exception $e) {
    echo "<br>" . $e->getMessage();
}

$conn = null;
?>
