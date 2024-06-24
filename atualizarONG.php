<?php
try { //se veio do formulário
    if(isset($_POST["id_ong"]) && isset($_POST["nome"]) && isset($_POST["responsavel"]) && isset($_POST["cnpj"]) && isset($_POST["telefone"]) && isset($_POST["cep"]) && isset($_POST["cidade"]) && isset($_POST["logradouro"])
    && isset($_POST["bairro"]) && isset($_POST["n_residencia"]) && isset($_POST["descricao"]) && isset($_POST["email"]) && isset($_POST["senha"])){ //grava no banco
        $id_ong = $_POST['id_ong'];
        $nome = $_POST['nome'];
        $responsavel = $_POST['responsavel'];
        $cnpj=$_POST['cnpj'];
        $telefone=$_POST['telefone'];
        $cep=$_POST['cep'];
        $cidade=$_POST['cidade'];
        $logradouro=$_POST['logradouro'];
        $bairro=$_POST['bairro'];
        $n_residencia=$_POST['n_residencia'];
        $descricao=$_POST['descricao'];
        $email=$_POST['email'];
        $senha=$_POST['senha'];
        $sql = "update ONG set nome='".$nome."', responsavel='".$responsavel."', cnpj='".$cnpj."', telefone='".$telefone."', cep='".$cep."', cidade='".$cidade."', logradouro='".$logradouro."', bairro='".$bairro."',
        n_residencia='".$n_residencia."', descricao='".$descricao."', email='".$email."', senha='".$senha."' where id_ong=".$id_ong;
        require_once("conexao.php");
        // use exec() because no results are returned
        $conn->exec($sql);
        echo "<script>window.alert('Atualizado');
        window.location.href='powerfullpets.php';</script>";
    } else {  echo "<script>window.alert('Digite os dados.');</script>";}
} catch(Exception $e) {
    echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>