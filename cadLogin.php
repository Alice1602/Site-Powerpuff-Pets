<?php
    require_once("conexao.php");

    if(isset($_POST['email']) && isset($_POST['senha'])){
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        
        $sql = "select * from Adotante
        where email = '".$email."' and senha = '".$senha."'";
        $dados = $conn->query($sql);
        while ($registros=$dados->fetch(PDO::FETCH_ASSOC)){
            echo "<script>window.alert('Seja bem vindo(a)!');
            window.location.href='powerfullpets.php';</script>";
        }
        $sql = "select * from Colaboradores
        where email = '".$email."' and senha = '".$senha."'";
        $dados = $conn->query($sql);
        while ($registros=$dados->fetch(PDO::FETCH_ASSOC)){
            echo "<script>window.alert('Seja bem vindo(a)!');
            window.location.href='powerfullpets.php';</script>";
        }

        echo "<script>window.alert('Usuário ou senha inválidos.');
        window.location.href='Login.php';</script>";

    }else{
        echo "<script>window.alert('Você deve digitar um e-mail e senha válidos.');
        window.location.href='Login.php';</script>";
    }
    $conn = null;
?>