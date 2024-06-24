<?php
try {
    // Verifica se todos os campos foram enviados
    if(isset($_POST["nome"]) && isset($_POST["sobrenome"]) && isset($_POST["idade"]) && isset($_POST["sexo"]) &&
       isset($_POST["cpf"]) && isset($_POST["telefone"]) && isset($_POST["cep"]) && isset($_POST["cidade"]) &&
       isset($_POST["logradouro"]) && isset($_POST["bairro"]) && isset($_POST["n_residencia"]) &&
       isset($_POST["complemento"]) && isset($_POST["email"]) && isset($_POST["senha"])) {

        $nome = $_POST['nome'];
        $sobrenome = $_POST['sobrenome'];
        $idade = $_POST['idade'];
        $sexo = $_POST['sexo'];
        $cpf = $_POST['cpf'];
        $telefone = $_POST['telefone'];
        $cep = $_POST['cep'];
        $cidade = $_POST['cidade'];
        $logradouro = $_POST['logradouro'];
        $bairro = $_POST['bairro'];
        $n_residencia = $_POST['n_residencia'];
        $complemento = $_POST['complemento'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $sql = "INSERT INTO Adotante (nome, sobrenome, idade, sexo, cpf, telefone, cep, cidade, logradouro, bairro, n_residencia, complemento, email, senha) 
                VALUES ('$nome', '$sobrenome', '$idade', '$sexo', '$cpf', '$telefone', '$cep', '$cidade', '$logradouro', '$bairro', '$n_residencia', '$complemento', '$email', '$senha')";

        require_once("conexao.php");
        $conn->exec($sql);

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
