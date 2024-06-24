<?php
require_once "conexao.php";
session_start();

if (isset($_POST['email']) && isset($_POST['senha'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    // Verifica na tabela Adotante
    $sql = "SELECT * FROM adotante WHERE email = :email AND senha = :senha";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);
    $stmt->execute();
    $registros = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($registros) {
        $_SESSION['idUsuarioLogado'] = $registros['adotanteID'];
        $_SESSION['nomeUsuarioLogado'] = $registros['nome'];
        $_SESSION['nivelUsuario'] = "USR";
        echo "<script>window.alert('Seja bem vindo(a) ".$registros['nome']." ".$registros['sobrenome']."!');
              window.location.href='powerfullpets.php';</script>";
        exit(); 
    } 

    // Verifica na tabela Colaboradores
    $sql2 = "SELECT * FROM Colaboradores WHERE email = :email AND senha = :senha";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bindParam(':email', $email);
    $stmt2->bindParam(':senha', $senha);
    $stmt2->execute();
    $registros2 = $stmt2->fetch(PDO::FETCH_ASSOC);

    if ($registros2) {
        $_SESSION['idUsuarioLogado'] = $registros2['id_colaborador'];
        $_SESSION['nomeUsuarioLogado'] = $registros2['nome'];
        $_SESSION['nivelUsuario'] = "COLAB";
        echo "<script>window.alert('Seja bem vindo(a) ".$registros2['nome']." ".$registros2['sobrenome']."!');
              window.location.href='powerfullpets.php';</script>";
        exit();
    }

    // Verifica na tabela ONG
    $sql4 = "SELECT * FROM ONG WHERE email = :email AND senha = :senha";
    $stmt4 = $conn->prepare($sql4);
    $stmt4->bindParam(':email', $email);
    $stmt4->bindParam(':senha', $senha);
    $stmt4->execute();
    $registros4 = $stmt4->fetch(PDO::FETCH_ASSOC);

    if ($registros4) {
        $_SESSION['idUsuarioLogado'] = $registros4['id_ong'];
        $_SESSION['nomeUsuarioLogado'] = $registros4['nome'];
        $_SESSION['nivelUsuario'] = "ONG";
        echo "<script>window.alert('Seja bem vindo(a) ".$registros4['nome']."!');
              window.location.href='powerfullpets.php';</script>";
        exit();
    }

    // Verifica na tabela Donas
    $sql3 = "SELECT * FROM Donas WHERE email = :email AND senha = :senha";
    $stmt3 = $conn->prepare($sql3);
    $stmt3->bindParam(':email', $email);
    $stmt3->bindParam(':senha', $senha);
    $stmt3->execute();
    $registros3 = $stmt3->fetch(PDO::FETCH_ASSOC);

    if ($registros3) {
        $_SESSION['idUsuarioLogado'] = $registros3['id'];
        $_SESSION['nomeUsuarioLogado'] = $registros3['nome'];
        $_SESSION['nivelUsuario'] = "ADM";
        echo "<script>window.alert('Seja bem vinda ".$registros3['nome']."!');
              window.location.href='powerfullpets.php';</script>";
        exit();
    }

    // Se nenhum usuário for encontrado
    echo "<script>window.alert('Usuário ou senha inválidos.');
              window.location.href='powerfullpets.php';</script>";
} else {
    echo "<script>window.alert('Você deve digitar um e-mail e senha válidos.');
              window.location.href='powerfullpets.php';</script>";
}
?>
