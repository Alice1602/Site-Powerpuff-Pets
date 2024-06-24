<?php
require_once("cabecalho.php");
if(isset($_GET['id_ong'])){
    try{
    $id_ong=$_GET['id_ong'];
    $sql="delete from ONG where id_ong=".$id_ong;
    require_once "conexao.php";
    $conn->exec($sql);
    echo "<script>window.alert('Excluído');
    window.location.href='listarONG.php';</script>";
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