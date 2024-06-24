<?php
require_once("cabecalho.php");
if(isset($_GET['adotanteID'])){
    try{
    $adotanteID=$_GET['adotanteID'];
    $sql="delete from adotante where adotanteID=".$adotanteID;
    require_once "conexao.php";
    $conn->exec($sql);
    echo "<script>window.alert('Excluído');
    window.location.href='listarUsuarios.php';</script>";
    //header('location:listarUsuarios.php');
    }catch(Exception $erro){
        if($erro->getCode()==23000)
        echo "<script>window.alert('Erro ao excluir: este usuário tem relacionamento com outra tabela');</script>";
    else
        echo "<p>Erro:".$erro->getMessage();
    }
}else{
    echo "<script>window.alert('Selecione um registro.');</script>";
}
?>