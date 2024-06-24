<?php
try { //se veio do formulário
    if(isset($_POST["id_colaborador"]) && isset($_POST["nome"]) && isset($_POST["sobrenome"]) && isset($_POST["idade"]) && isset($_POST["sexo"])
    && isset($_POST["email"]) && isset($_POST["senha"])){ //grava no banco
        $id_colaborador = $_POST['id_colaborador'];
        $nome = $_POST['nome'];
        $sobrenome = $_POST['sobrenome'];
        $idade=$_POST['idade'];
        $sexo=$_POST['sexo'];
        $email=$_POST['email'];
        $senha=$_POST['senha'];
        $sql = "update Colaboradores set nome='".$nome."', sobrenome='".$sobrenome."', idade='".$idade."', sexo='".$sexo."',
        email='".$email."', senha='".$senha."' where id_colaborador=".$id_colaborador;
        require_once("conexao.php");
        // use exec() because no results are returned
        $conn->exec($sql);
        echo "<script>window.alert('Atualizado');
        window.location.href='powerfullpets.php';</script>";
    } else {  echo "<script>window.alert('Digite os dados.');</script>"; }
} catch(Exception $e) {
    echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>