<?php
require_once("cabecalho.php");
if(!isset($_SESSION['idUsuarioLogado'])){ //verifica se o usuário está logado
    echo "<p>Você não tem permissão para acessar esta página, faça login.</p>";
}else if($_SESSION['nivelUsuario']=="COLAB" || $_SESSION['nivelUsuario']=="ADM"){
    require_once("conexao.php");
    $sql = "SELECT adocao.adocaoID, ong.nome AS nome_ong, adotante.nome AS nome_adotante, animal.nome AS nome_animal
        FROM adocao
        INNER JOIN ong ON adocao.ong = ong.id_ong
        INNER JOIN adotante ON adocao.adotanteID = adotante.adotanteID
        INNER JOIN animal ON adocao.animalID = animal.animalID
        ORDER BY ong.nome";
    $dados = $conn->query($sql);
?>
    <style>
        #listaRegistros{
            display: none;
            flex-direction: column;
            gap: 30px;
        }

        body[page=lista] #listaRegistros{ display: block; }

        body{
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
        }

        table{
            width: 50%;
            border-collapse: collapse;
        }
        table th,
        table td{
            font-size: 14px;
            padding: 10px 15px;
            border: solid 1px #ccc;
        }

        button{
            border: none;
            border-radius: 4px;
            cursor: pointer;
            background-color: #07a;
            color: #fff;
            margin: 3px;
            padding: 10px 15px;
        }
        button.cinza{
            background-color: #ccc;
            color: #666;
        }
        button.vermelho{
            background-color: #a00;
        }
        button:hover{
            opacity: 0.8;
        }

        input{
            border: solid 1px #ccc;
            border-radius: 4px;
            padding: 10px;
        }

        .label>div{
            display: flex;
        }
        .label>div>input{
            flex: 1;
        }
    </style>
</head>
<body page='lista'>   
    <center>
    <div id='listaRegistros'>
        <br><br><br><br>
        <div style='display: flex; justify-content: center;'>
            <input style='width: 50%;' placeholder='PESQUISAR' autofocus id='inputPesquisa'>
        </div><br><br>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome da ONG</th>
                    <th>Nome Adotante</th>
                    <th>Nome Animal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id='listaRegistrosBody'>
                <?php
                while($registros = $dados->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                            <td>".$registros['adocaoID']."</td>
                            <td>".$registros['nome_ong']."</td>
                            <td>".$registros['nome_adotante']."</td>
                            <td>".$registros['nome_animal']."</td>
                            <td>
                                <center>
                                    <a href='editarAdocao.php?adocaoID=".$registros['adocaoID']."'><button>Editar</button></a>
                                    <button onclick='confirmarExclusao(".$registros['adocaoID'].")' class='vermelho' >Deletar</button>
                                </center>
                            </td>
                        </tr>";
                }
                $conn=null;
                ?>
            </tbody>
        </table>

    </div>
    </center>
    <script>
        document.getElementById('inputPesquisa').addEventListener('input', function() {
            var filtro = this.value.toUpperCase();
            var linhas = document.getElementById('listaRegistrosBody').getElementsByTagName('tr');

            for (var i = 0; i < linhas.length; i++) {
                var colunas = linhas[i].getElementsByTagName('td');
                var encontrado = false;
                for (var j = 1; j < colunas.length - 1; j++) { // Começa de 1 e termina em length - 1 para ignorar a primeira e última coluna (ID e botões)
                    var texto = colunas[j].innerText.toUpperCase();
                    if (texto.indexOf(filtro) > -1) {
                        encontrado = true;
                        break;
                    }
                }
                linhas[i].style.display = encontrado ? '' : 'none';
            }
        });
        function confirmarExclusao(adocaoID) {
            if (confirm("Tem certeza que deseja excluir este usuário?")) {
                window.location.href = 'excluirAdocao.php?adocaoID=' + adocaoID;
            }
        }
    </script>
<?php
}else { //não é adm
    echo "<script>window.alert('Somente Colaborador pode acessar este módulo.');
              window.location.href='powerfullpets.php';</script>";
}
?>
</body>
</html>
