<?php
if (isset($_GET['adocaoID'])) {
    try {
        $adocaoID = $_GET['adocaoID'];
        require_once("conexao.php");
        $sql = "SELECT * FROM Adocao WHERE adocaoID=" . $adocaoID;
        $dados = $conn->query($sql);
        while ($adocao = $dados->fetch(PDO::FETCH_ASSOC)) {
?>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Colaborador</title>
    <link rel="stylesheet" href="css/cadAdocao.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="images/logoGG.png">
    <style>
        /*listagem*/
        #listaRegistros {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .tabela {
        max-height: 230px; /* Altura máxima da tabela */
        overflow-y: auto; /* Adiciona barra de rolagem vertical quando necessário */
    }

    table {
        border-collapse: collapse;
        width: 100%;
        border: solid 1.8px black;
    }

    #tabelas-container {
        display: flex;
        gap: 30px;
        /* Espaçamento entre as tabelas */
    }

    .tabela th,
    .tabela td {
        font-size: 14px;
        padding: 15px 25px;
        border: solid 1px black;
    }

    input {
        border: solid 1px black;
        border-radius: 4px;
        padding: 10px;
    }

    .label>div {
        display: flex;
    }

    .label>div>input {
        flex: 1;
    }
    .selected {
        background-color: #bcebec; /* Cor de fundo para destacar */
    }
    </style>
</head>

<body>
    <p><b><a class="Home" href="powerfullpets.php" target="_blank">Início</a></b></p>
    <br>

    <div id="main-container2">
        <h1>Editar adoção</h1><br>
        <br>
        
            <?php
            if(isset($_GET['adocaoID'])) {
                $adocaoID = $_GET['adocaoID'];

                // Consulta para obter os dados da adoção
                $sqlAdocao = "SELECT * FROM Adocao WHERE adocaoID = :adocaoID";
                $stmtAdocao = $conn->prepare($sqlAdocao);
                $stmtAdocao->bindParam(':adocaoID', $adocaoID);
                $stmtAdocao->execute();
                $adocao = $stmtAdocao->fetch(PDO::FETCH_ASSOC);

                // Consulta para obter os dados do adotante
                $sqlAdotante = "SELECT * FROM Adotante WHERE adotanteID = :adotanteID";
                $stmtAdotante = $conn->prepare($sqlAdotante);
                $stmtAdotante->bindParam(':adotanteID', $adocao['adotanteID']);
                $stmtAdotante->execute();
                $adotante = $stmtAdotante->fetch(PDO::FETCH_ASSOC);

                // Consulta para obter os dados do animal
                $sqlAnimal = "SELECT * FROM Animal WHERE animalID = :animalID";
                $stmtAnimal = $conn->prepare($sqlAnimal);
                $stmtAnimal->bindParam(':animalID', $adocao['animalID']);
                $stmtAnimal->execute();
                $animal = $stmtAnimal->fetch(PDO::FETCH_ASSOC);
            }
            ?>
            <form class="form" id="registro-form" action="atualizarAdocao.php" method="post">
        <input type="hidden" name="adocaoID" value="<?php echo $adocao['adocaoID']; ?>">
            <div class="pequeno-box spacing">
                <label for="adotanteID">ID</label>
                <input type="text" name="adotanteID" id="adotanteID" value="<?php echo $adocao['adotanteID']; ?>" readonly>
            </div>
            <div class="half-box spacing">
                <label for="nome_adotante">Nome do Adotante</label>
                <input type="text" name="nome_adotante" id="nome_adotante" value="<?php echo $adotante['nome']; ?>" readonly>
            </div>

            <div class="pequeno-box spacing">
                <label for="animalID">ID</label>
                <input type="text" name="animalID" id="animalID" value="<?php echo $adocao['animalID']; ?>" readonly>
            </div>
            <div class="half-box spacing">
                <label for="nome_animal">Nome do Animal</label>
                <input type="text" name="nome_animal" id="nome_animal" value="<?php echo $animal['nome']; ?>" readonly>
            </div>

            <div class="half-box spacing">
                <label for="ong">Qual a sua ONG?</label>
                <select id="ong" name="ong" placeholder="Selecione">
                <?php
                $sqlONG = "SELECT * FROM ONG order by nome";
                $stmtONG = $conn->query($sqlONG);
                while ($row = $stmtONG->fetch(PDO::FETCH_ASSOC)) {
                    $selected = ($row['id_ong'] == $adocao['ong']) ? 'selected' : '';
                    echo "<option value='" . $row['id_ong'] . "' $selected>" . $row['nome'] . "</option>";
                }
                ?>
                </select>
            </div>

            <div class="half-box spacing">
                <label for="data_escolha">Data da escolha do animal</label>
                <input type="date" name="data_escolha" id="data_escolha" value="<?php echo $adocao['data_escolha']; ?>">
            </div>

            <div class="half-box spacing">
                <label for="dt_entrevista">Data da entrevista</label>
                <input type="date" name="dt_entrevista" id="dt_entrevista" value="<?php echo $adocao['dt_entrevista']; ?>">
            </div>

            <div class="half-box spacing">
                <label for="data_adocaoaceita">Data que a adoção foi aprovada</label>
                <input type="date" name="data_adocaoaceita" id="data_adocaoaceita" value="<?php echo $adocao['data_adocaoaceita']; ?>">
            </div>

            <div class="half-box spacing">
                <label for="dt_adocao">Data da entrega do animal</label>
                <input type="date" name="dt_adocao" id="dt_adocao" value="<?php echo $adocao['dt_adocao']; ?>">
            </div>

            <div class="grande-box spacing">
                <label for="entrevista">Entrevista</label>
                <textarea class="texto" name="entrevista" rows="4" cols="100" placeholder="Conte como foi a entrevista?"><?php echo $adocao['entrevista']; ?></textarea>
            </div>

            <div class="half-box spacing">
                <input type="submit" value="Cadastrar">
            </div>
        </form>
    </div>
    </div>
    <p class="error-validation template"></p>
    <?php
        } //Fim do while
    } catch (Exception $erro) {
        echo "<p>Erro:" . $erro->getMessage();
    }
} else {
    echo "<script>window.alert('Selecione um registro.');</script>";
}
?>
</body>

</html>