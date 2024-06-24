<?php
try { //se veio do formulário
    if(isset($_POST["adotanteID"]) && isset($_POST["email"]) && isset($_POST["senha"])){ //grava no banco
        $adotanteID=$_POST['adotanteID'];
        $email=$_POST['email'];
        $senha=$_POST['senha'];
        $sql = "update Adotante set email='".$email."', senha='".$senha."' where adotanteID=".$adotanteID;
        require_once("conexao.php");
        // use exec() because no results are returned
        $conn->exec($sql);
        echo "<script>window.alert('Atualizado');
        window.location.href='#';</script>";
    } else {  echo "<script>window.alert('Digite os dados.');</script>"; }
} catch(Exception $e) {
    echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>