<?php
try { //se veio do formulário
    if(isset($_POST["adotanteID"]) && isset($_POST["nome"]) && isset($_POST["sobrenome"]) && isset($_POST["idade"]) && isset($_POST["sexo"])
    && isset($_POST["cpf"]) && isset($_POST["telefone"]) && isset($_POST["cep"]) && isset($_POST["cidade"]) && isset($_POST["logradouro"]) 
    && isset($_POST["bairro"]) && isset($_POST["n_residencia"]) && isset($_POST["complemento"]) && isset($_POST["email"]) && isset($_POST["senha"])){ //grava no banco
        $adotanteID=$_POST['adotanteID'];
        $nome = $_POST['nome'];
        $sobrenome = $_POST['sobrenome'];
        $nomeCompleto = $nome . ' ' . $sobrenome;
        $idade=$_POST['idade'];
        $sexo=$_POST['sexo'];
        $cpf=$_POST['cpf'];
        $telefone=$_POST['telefone'];
        $cep=$_POST['cep'];
        $cidade=$_POST['cidade'];
        $logradouro=$_POST['logradouro'];
        $bairro=$_POST['bairro'];
        $n_residencia=$_POST['n_residencia'];
        $complemento=$_POST['complemento'];
        $email=$_POST['email'];
        $senha=$_POST['senha'];
        $sql = "update Adotante set nome='".$nome."', sobrenome='".$sobrenome."', idade='".$idade."', sexo='".$sexo."', cpf='".$cpf."', telefone='".$telefone."', cep='".$cep."', cidade='".$cidade."', logradouro='".$logradouro."', bairro='".$bairro."', n_residencia='".$n_residencia."', complemento='".$complemento."', email='".$email."', senha='".$senha."' where adotanteID=".$adotanteID;
        require_once("conexao.php");
        // use exec() because no results are returned
        $conn->exec($sql);
        echo "<script>window.alert('Atualizado');
        window.location.href='powerfullpets.php';</script>";
    } else { echo "<script>window.alert('Digite os dados.');</script>"; }
} catch(Exception $e) {
    echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>