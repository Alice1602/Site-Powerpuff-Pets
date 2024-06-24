<!DOCTYPE html>
<html lang="pt-br">

<head>
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

    <div id="main-container">
        <h1>Cadastro de adoção</h1><br>
        <br>
        <form class="form" id="registro-form" action="cadAdocao.php" method="post">
            <div class="half-box spacing">
                <label for="ong">Qual a sua ONG?</label>
                <select id="ong" name="ong" placeholder="Selecione">
                    <?php
                    require_once("conexao.php");
                    $sql = "Select * from ONG order by nome";
                    $dados = $conn->query($sql);
                    while ($registros = $dados->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . $registros['id_ong'] . "'>" . $registros['nome'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="half-box spacing">
                <label for="data_escolha">Data da escolha do animal</label>
                <input type="date" name="data_escolha" id="data_escolha">
            </div>

            <div class="half-box spacing">
                <label for="dt_entrevista">Data da entrevista</label>
                <input type="date" name="dt_entrevista" id="dt_entrevista">
            </div>

            <div class="half-box spacing">
                <label for="data_adocaoaceita">Data que a adoção foi aprovada</label>
                <input type="date" name="data_adocaoaceita" id="data_adocaoaceita">
            </div>

            <div class="half-box spacing">
                <label for="dt_adocao">Data da entrega do animal</label>
                <input type="date" name="dt_adocao" id="dt_adocao">
            </div>

            <div class="grande-box spacing">
                <label for="entrevista">Entrevista</label>
                <textarea class="texto" name="entrevista" rows="4" cols="100" placeholder="Conte como foi a entrevista?"></textarea>
            </div>
            <br>
            <br>
            <div class="grande-box spacing">
                <div style='display: flex; justify-content: center;'>
                    <input style='width: 50%;' placeholder='Pesquisar' autofocus id='inputPesquisa' oninput="pesquisar()">
                </div>
            </div>
            <div id="tabelas-container">
                <div class="tabela">
                    <?php
                    require_once("conexao.php");
                    $sql = "SELECT Adotante.*
                    FROM Adotante
                    LEFT JOIN Adocao ON Adotante.adotanteID = Adocao.adotanteID
                    WHERE Adocao.adocaoID IS NULL";

                    $dados = $conn->query($sql);
                    ?>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Sobrenome</th>
                                <th>Data Nascimento</th>
                                <th>E-mail</th>
                            </tr>
                        </thead>
                        <tbody id='listaRegistrosAdotanteBody'>
                            <?php
                            while ($registros = $dados->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr onclick='selecionarLinhaAdotante(this)'>
                                        <td>" . $registros['adotanteID'] . "</td>
                                        <td>" . $registros['nome'] . "</td>
                                        <td>" . $registros['sobrenome'] . "</td>
                                        <td>" . $registros['idade'] . "</td>
                                        <td>" . $registros['email'] . "</td>
                                    </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="tabela">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Raça</th>
                                <th>Tipo do animal</th>
                                <th>Data da entrada</th>
                                <th>Data de saída</th>
                            </tr>
                        </thead>
                        <tbody id='listaRegistrosAnimailBody'>
                        <?php
                        require_once("conexao.php"); // Inclua seu arquivo de conexão aqui

                        // Consulta SQL com JOIN entre as tabelas Animal e Adocao
                        $sql = "SELECT Animal.*
                                    FROM Animal
                                    LEFT JOIN Adocao ON Animal.animalID = Adocao.animalID
                                    WHERE Adocao.adocaoID IS NULL";

                        $dados = $conn->query($sql);

                        while ($registros = $dados->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr onclick='selecionarLinhaAnimais(this)'>
                                    <td>" . $registros['animalID'] . "</td>
                                    <td>" . $registros['nome'] . "</td>
                                    <td>" . $registros['raca'] . "</td>
                                    <td>" . $registros['tipo_animal'] . "</td>
                                    <td>" . $registros['dt_entrada'] . "</td>
                                    <td>" . $registros['dt_saida'] . "</td>
                                </tr>";
                        }
                        $conn = null;
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <input type="hidden" name="adotanteID" id="adotanteID">
            <input type="hidden" name="animalID" id="animalID">

            <div class="half-box spacing">
                <input type="submit" value="Cadastrar">
            </div>
        </form>
    </div>
    </div>
    <p class="error-validation template"></p>
    <script>
        function pesquisar() {
            var filtro = document.getElementById('inputPesquisa').value.toUpperCase();
            var linhasAdotante = document.getElementById('listaRegistrosAdotanteBody').getElementsByTagName('tr');
            var linhasAdocao = document.getElementById('listaRegistrosAnimailBody').getElementsByTagName('tr');

            for (var i = 0; i < linhasAdotante.length; i++) {
                var colunas = linhasAdotante[i].getElementsByTagName('td');
                linhasAdotante[i].style.display = 'none';
                for (var j = 0; j < colunas.length; j++) {
                    var texto = colunas[j].innerText.toUpperCase();
                    if (texto.indexOf(filtro) > -1) {
                        linhasAdotante[i].style.display = '';
                        break;
                    }
                }
            }

            for (var i = 0; i < linhasAdocao.length; i++) {
                var colunas = linhasAdocao[i].getElementsByTagName('td');
                linhasAdocao[i].style.display = 'none';
                for (var j = 0; j < colunas.length; j++) {
                    var texto = colunas[j].innerText.toUpperCase();
                    if (texto.indexOf(filtro) > -1) {
                        linhasAdocao[i].style.display = '';
                        break;
                    }
                }
            }
        }
        function selecionarLinhaAdotante(linha) {
        var isSelected = linha.classList.contains('selected');
        
        var linhas = document.querySelectorAll('#listaRegistrosAdotanteBody tr');
        linhas.forEach(function(linha) {
            linha.classList.remove('selected');
        });

        if (!isSelected) {
            linha.classList.add('selected');
            var adotanteID = linha.querySelector('td:first-child').textContent;
            document.getElementById('adotanteID').value = adotanteID;
        } else {
            document.getElementById('adotanteID').value = '';
        }
    }

    function selecionarLinhaAnimais(linha) {
        var isSelected = linha.classList.contains('selected');
        
        var linhas = document.querySelectorAll('#listaRegistrosAnimailBody tr');
        linhas.forEach(function(linha) {
            linha.classList.remove('selected');
        });

        if (!isSelected) {
            linha.classList.add('selected');
            var animalID = linha.querySelector('td:first-child').textContent;
            document.getElementById('animalID').value = animalID;
        } else {
            document.getElementById('animalID').value = '';
        }
    }
    </script>
</body>

</html>