<?php
try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") { // Verifica se o formulário foi submetido
        // Verifica se todos os campos necessários estão definidos
        if (isset($_POST["nome"]) && isset($_POST["idade"]) && isset($_POST["sexo"]) && isset($_POST["tipo_animal"]) && isset($_POST["raca"]) && isset($_POST["porte"]) && isset($_POST["saude"]) && isset($_POST["historico"]) && isset($_POST["dt_entrada"]) && isset($_POST["dt_saida"]) && isset($_POST["disponibilidade"])) {

                $nome = $_POST['nome'];
                $idade = $_POST['idade'];
                $sexo = $_POST['sexo'];
                $tipo_animal = $_POST['tipo_animal'];
                $raca = $_POST['raca'];
                $porte = $_POST['porte'];
                $saude = $_POST['saude'];
                $historico = $_POST['historico'];
                $dt_entrada = $_POST['dt_entrada'];
                $dt_saida = $_POST['dt_saida'];
                $disponibilidade = $_POST['disponibilidade'];

            // Verifica se uma imagem foi enviada
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $imagem = $_FILES['foto'];
                $tipoimagem = $imagem['type'];
                define('TAMANHO_MAXIMO', (2 * 1024 * 1024)); // 2 MB

                if($imagem != NULL) {
                    $tamanho = $imagem['size'];
                    // Validações básicas
                    // Formato
                    if(!preg_match('/^image\/(pjpeg|jpeg|png|gif|bmp)$/', $tipoimagem))
                    {
                        echo 'Não é uma imagem válida';
                        exit;
                    }
                    // Tamanho
                    if ($tamanho > TAMANHO_MAXIMO)
                    {
                        echo 'A imagem deve possuir no máximo 2 MB';
                        exit;
                    }
                    // Transformando foto em dados (binário)
                    $conteudo = file_get_contents($imagem['tmp_name']);
                } else {
                    echo "Você não realizou o upload de forma satisfatória.";
                    exit;
                }
            } else {
                echo "Nenhuma imagem foi enviada.";
                exit;
            }

            // Inclua aqui a configuração da conexão com o banco de dados
            require_once("conexao.php");

            // Prepare a declaração SQL para inserir os dados
            $stmt = $conn->prepare('INSERT INTO Animal (nome, idade, sexo, tipo_animal, raca, porte, saude, historico, dt_entrada, dt_saida, disponibilidade, foto) VALUES (:nome, :idade, :sexo, :tipo_animal, :raca, :porte, :saude, :historico, :dt_entrada, :dt_saida, :disponibilidade, :conteudo)');

            // Defina os parâmetros
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':idade', $idade, PDO::PARAM_STR);
            $stmt->bindParam(':sexo', $sexo, PDO::PARAM_STR);
            $stmt->bindParam(':tipo_animal', $tipo_animal, PDO::PARAM_STR);
            $stmt->bindParam(':raca', $raca, PDO::PARAM_STR);
            $stmt->bindParam(':porte', $porte, PDO::PARAM_STR);
            $stmt->bindParam(':saude', $saude, PDO::PARAM_STR);
            $stmt->bindParam(':historico', $historico, PDO::PARAM_STR);
            $stmt->bindParam(':dt_entrada', $dt_entrada, PDO::PARAM_STR);
            $stmt->bindParam(':dt_saida', $dt_saida, PDO::PARAM_STR);
            $stmt->bindParam(':disponibilidade', $disponibilidade, PDO::PARAM_STR);
            $stmt->bindParam(':conteudo', $conteudo, PDO::PARAM_LOB);

            // Execute a declaração
            $stmt->execute();

            // Redirecione após o registro ser salvo
            header("Location:adocao.php");
            exit();
        } else {
            echo "<p>Digite todos os dados.</p>";
        }
    }
} catch(Exception $e) {
    echo "<br>" . $e->getMessage();
}
?>
