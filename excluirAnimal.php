<?php
require_once("cabecalho.php");
if(isset($_GET['animalID'])){
    try{
    $animalID=$_GET['animalID'];
    $sql="delete from Animal where animalID=".$animalID;
    require_once "conexao.php";
    $conn->exec($sql);
    echo "<script>window.alert('Excluído');
    window.location.href='listarAnimais.php';</script>";
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