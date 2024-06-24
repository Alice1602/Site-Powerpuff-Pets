<?php
require_once("cabecalho.php");
if(isset($_GET['id_colaborador'])){
    try{
    $id_colaborador=$_GET['id_colaborador'];
    $sql="delete from Colaboradores where id_colaborador=".$id_colaborador;
    require_once "conexao.php";
    $conn->exec($sql);
    echo "<script>window.alert('Excluído');
    window.location.href='listarColaborador.php';</script>";
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