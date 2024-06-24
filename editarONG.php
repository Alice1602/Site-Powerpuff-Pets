<?php
session_start();

if (isset($_SESSION['idUsuarioLogado']) && (isset($_SESSION['nivelUsuario']) && ($_SESSION['nivelUsuario'] == "ADM" || $_SESSION['nivelUsuario'] == "ONG"))) {
    // Para administradores, o ID da ONG pode ser passado via GET, para ONGs deve ser obtido da sessão
    if ($_SESSION['nivelUsuario'] == "ADM" && isset($_GET['id_ong'])) {
        $id_ong = $_GET['id_ong'];
    } elseif ($_SESSION['nivelUsuario'] == "ONG" && isset($_SESSION['idUsuarioLogado'])) {
        $id_ong = $_SESSION['idUsuarioLogado'];
    } else {
        echo "<script>window.alert('ID da ONG não fornecido.');</script>";
        exit();
    }

    try {
        require_once("conexao.php");
        $sql = "SELECT * FROM ONG WHERE id_ong = :id_ong";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_ong', $id_ong);
        $stmt->execute();
        $registros = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($registros) {
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Edite sua ONG</title>
    <link rel="stylesheet" href="css/cadUsuario.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="images/logoGG.png">
    <script>
        function limpa_formulário_cep() {
            document.getElementById('logradouro').value = ("");
            document.getElementById('bairro').value = ("");
            document.getElementById('cidade').value = ("");
        }

        function meu_callback(conteudo) {
            if (!("erro" in conteudo)) {
                document.getElementById('logradouro').value = (conteudo.logradouro);
                document.getElementById('bairro').value = (conteudo.bairro);
                document.getElementById('cidade').value = (conteudo.localidade);
            } else {
                limpa_formulário_cep();
                alert("CEP não encontrado.");
            }
        }

        function pesquisacep(valor) {
            var cep = valor.replace(/\D/g, '');

            if (cep != "") {
                var validacep = /^[0-9]{8}$/;

                if (validacep.test(cep)) {
                    document.getElementById('logradouro').value = "...";
                    document.getElementById('bairro').value = "...";
                    document.getElementById('cidade').value = "...";

                    var script = document.createElement('script');
                    script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';
                    document.body.appendChild(script);
                } else {
                    limpa_formulário_cep();
                    alert("Formato de CEP inválido.");
                }
            } else {
                limpa_formulário_cep();
            }
        }
    </script>
</head>
<body>
    <p><b><a class="Home" href="powerfullpets.php">Início</a></b></p>
    <br>

    <div id="main-container">
        <h1>Edite suas informações</h1><br>
        <form id="registro-form" action="atualizarONG.php" method="post">
            <input type="hidden" name="id_ong" value="<?php echo $registros['id_ong']; ?>">
            <div class="half-box spacing">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" placeholder="Digite o nome da sua empresa" value="<?php echo $registros['nome']; ?>">
            </div>
            <div class="half-box spacing">
                <label for="responsavel">Dono da empresa</label>
                <input type="text" name="responsavel" id="responsavel" placeholder="Digite o nome do responsável da empresa" value="<?php echo $registros['responsavel']; ?>">
            </div><br>
            <div class="half-box spacing">
                <label for="cnpj">CNPJ</label>
                <input type="text" name="cnpj" id="cnpj" placeholder="Digite o CNPJ da empresa" value="<?php echo $registros['cnpj']; ?>" readonly>
            </div>
            <div class="half-box spacing">
                <label for="telefone">Telefone</label>
                <input type="tel" name="telefone" id="telefone" placeholder="DDD + Telefone" value="<?php echo $registros['telefone']; ?>">
            </div>
            <div class="half-box spacing">
                <label for="cep">CEP</label>
                <input type="text" name="cep" id="cep" required placeholder="Digite seu CEP" maxlength="9" onblur="pesquisacep(this.value);" value="<?php echo $registros['cep']; ?>">
            </div>
            <div class="half-box spacing">
                <label for="cidade">Cidade</label>
                <input type="text" name="cidade" id="cidade" placeholder="Digite sua cidade" value="<?php echo $registros['cidade']; ?>">
            </div>
            <div class="half-box spacing">
                <label for="logradouro">Logradouro</label>
                <input type="text" name="logradouro" id="logradouro" placeholder="Digite seu logradouro" value="<?php echo $registros['logradouro']; ?>">
            </div>
            <div class="half-box spacing">
                <label for="bairro">Bairro</label>
                <input type="text" name="bairro" id="bairro" placeholder="Digite seu bairro" value="<?php echo $registros['bairro']; ?>">
            </div>
            <div class="half-box spacing">
                <label for="n_residencia">Número</label>
                <input type="text" name="n_residencia" id="n_residencia" placeholder="nº Residêncial" value="<?php echo $registros['n_residencia']; ?>">
            </div>
            <div class="grande-box spacing">
                <label for="descricao">Descrição</label>
                <textarea class="texto" name="descricao" rows="4" cols="100" placeholder="Descreva sobre sua empresa."><?php echo $registros['descricao']; ?></textarea>
            </div>
            <div class="grande-box spacing">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" placeholder="Digite seu e-mail" value="<?php echo $registros['email']; ?>" readonly>
            </div>
            <div class="full-box spacing">
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" placeholder="Digite sua senha" value="<?php echo $registros['senha']; ?>">
                <i class="bi bi-eye-slash-fill" id="btn-senha" onclick="mostrarSenha()"></i>
            </div>
            <div class="full-box spacing">
                <label for="passconfirmation">Confirmação de senha</label>
                <input type="password" name="passconfirmation" id="passwordconfirmation" placeholder="Confirme sua senha" value="<?php echo $registros['senha']; ?>">
                <i class="bi bi-eye-slash-fill" id="btn-senha2" onclick="mostrarSenha2()"></i>
            </div>
            <div class="full-box spacing">
                <input type="submit" value="Cadastrar">
            </div>
        </form>
        <br><br><br><br>
    </div>
    <p class="error-validation template"></p>
    <script src="js/scriptCadUsuario.js"></script>
</body>
</html>
<?php
        } else {
            echo "<script>window.alert('ONG não encontrada.');</script>";
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
} else {
    echo "<script>window.alert('Por favor, faça o login para editar suas informações.');</script>";
    echo "<script>window.location.href = 'Login.php';</script>";
}
?>
