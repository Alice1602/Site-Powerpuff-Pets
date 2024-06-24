<?php
try {
    if(isset($_POST["adocaoID"]) && isset($_POST["ong"]) && isset($_POST["data_escolha"]) && isset($_POST["dt_entrevista"]) && isset($_POST["data_adocaoaceita"]) && isset($_POST["dt_adocao"])
    && isset($_POST["entrevista"]) && isset($_POST["adotanteID"]) && isset($_POST["animalID"])){
        
        $adocaoID = $_POST['adocaoID'];
        $ong = $_POST['ong'];
        $data_escolha = $_POST['data_escolha'];
        $dt_entrevista = $_POST['dt_entrevista'];
        $data_adocaoaceita = $_POST['data_adocaoaceita'];
        $dt_adocao = $_POST['dt_adocao'];
        $entrevista = $_POST['entrevista'];
        $adotanteID = $_POST['adotanteID'];
        $animalID = $_POST['animalID'];

        // Atualizar os dados no banco de dados
        $sql = "update Adocao set ong='".$ong."', data_escolha='".$data_escolha."', dt_entrevista='".$dt_entrevista."', data_adocaoaceita='".$data_adocaoaceita."', dt_adocao='".$dt_adocao."', entrevista='".$entrevista."', adotanteID='".$adotanteID."', animalID='".$animalID."'  WHERE adocaoID=".$adocaoID;
        require_once("conexao.php");
        $conn->exec($sql);
        

        echo "<script>window.alert('Atualizado');
        window.location.href='listarAdocao.php';</script>";
    } else { 
        echo "<script>window.alert('Digite os dados.');</script>";
    }
} catch(Exception $e) {
    echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>

