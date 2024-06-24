<?php
try {
    //se veio do formulário
    if(isset($_POST["nome"]) && isset($_POST["responsavel"]) && isset($_POST["cnpj"]) && isset($_POST["descricao"]) && isset($_POST["cep"]) && isset($_POST["cidade"]) && isset($_POST["logradouro"]) 
    && isset($_POST["bairro"]) && isset($_POST["n_residencia"]) && isset($_POST["telefone"]) && isset($_POST["email"]) && isset($_POST["senha"])) {
        
        $nome = $_POST['nome'];
        $responsavel = $_POST['responsavel'];
        $cnpj = $_POST['cnpj'];
        $descricao = $_POST['descricao'];
        $cep = $_POST['cep'];
        $cidade = $_POST['cidade'];
        $logradouro = $_POST['logradouro'];
        $bairro = $_POST['bairro'];
        $n_residencia = $_POST['n_residencia'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $sql = "INSERT INTO ONG (nome,responsavel,cnpj,descricao,cep,cidade,logradouro,bairro,n_residencia,telefone,email,senha) 
        VALUES ('$nome','$responsavel','$cnpj','$descricao','$cep','$cidade','$logradouro','$bairro','$n_residencia','$telefone','$email','$senha')";        
        require_once("conexao.php");
        // use exec() because no results are returned
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
