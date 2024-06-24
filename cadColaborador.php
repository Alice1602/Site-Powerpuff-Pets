<?php
try {
    // se veio do formulário
    if (isset($_POST["nome"]) && isset($_POST["sobrenome"]) && isset($_POST["idade"]) && isset($_POST["sexo"]) 
        && isset($_POST["email"]) && isset($_POST["senha"]) && isset($_POST["ong"])) {
        
        $nome = $_POST['nome'];
        $sobrenome = $_POST['sobrenome'];
        $idade = $_POST['idade'];
        $sexo = $_POST['sexo'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $ong = $_POST['ong'];
        
        // Certifique-se de que a conexão está configurada corretamente
        require_once("conexao.php");

        // Prepare a instrução SQL
        $sql = "INSERT INTO Colaboradores (nome, sobrenome, idade, sexo, email, senha, ong) 
                VALUES (:nome, :sobrenome, :idade, :sexo, :email, :senha, :ong)";
        
        // Prepare a declaração
        $stmt = $conn->prepare($sql);
        
        // Vincular os parâmetros
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':sobrenome', $sobrenome);
        $stmt->bindParam(':idade', $idade);
        $stmt->bindParam(':sexo', $sexo);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':ong', $ong);

        // Execute a declaração
        $stmt->execute();

        echo "<script>alert('Cadastro feito com sucesso!'); window.location.href='powerfullpets.php';</script>";
    } else {
        echo "<script>alert('Por favor, preencha todos os campos.'); window.location.href='cadastroUsuarios.php';</script>";
    }
} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        echo "<script>alert('Dado duplicado. Verifique os dados inseridos.'); window.location.href='cadastroUsuarios.php';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar: " . $e->getMessage() . "'); window.location.href='cadastroUsuarios.php';</script>";
    }
}

$conn = null;
?>
