<?php
session_start();

if (isset($_SESSION['idUsuarioLogado']) && isset($_SESSION['nivelUsuario'])) {
    $idUsuarioLogado = $_SESSION['idUsuarioLogado'];
    $nivelUsuario = $_SESSION['nivelUsuario'];

    // Para usuários não administradores, usa o idUsuarioLogado como adotanteID
    if ($nivelUsuario != "ADM") {
        $adotanteID = $idUsuarioLogado;
    } else {
        // Para administradores, permite edição de qualquer adotanteID passado na URL
        if (isset($_GET['adotanteID']) && !empty($_GET['adotanteID'])) {
            $adotanteID = $_GET['adotanteID'];
        } else {
            echo "<script>window.alert('ID do adotante não fornecido.');</script>";
            exit();
        }
    }

    try {
        require_once("conexao.php");
        $sql = "SELECT * FROM adotante WHERE adotanteID = :adotanteID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':adotanteID', $adotanteID);
        $stmt->execute();
        $registros = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($registros) {
            // Continue com o restante do código para exibir o formulário de edição
            ?>
            <!DOCTYPE html>
            <html lang="pt-BR">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Editar Usuário</title>
                <link rel="stylesheet" href="css/cadUsuario.css">
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
                <link rel="icon" href="images/logoGG.png">
            </head>
            <body>
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
                    };
                </script>
                <br>
                <br>
                <div id="main-container">
                    <h1>Edite suas informações</h1><br>
                    <br>
                    <form id="registro-form" action="atualizarUsuario.php" method="post">
                        <input type="hidden" name="adotanteID" value="<?php echo $registros['adotanteID']; ?>">
                        <div class="full-box spacing">
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" id="nome" placeholder="Digite seu nome" data-required data-max-length="16" data-only-letters value="<?php echo $registros['nome']; ?>">
                        </div>
                        <div class="full-box spacing">
                            <label for="sobrenome">Sobrenome</label>
                            <input type="text" name="sobrenome" id="sobrenome" placeholder="Digite seu sobrenome" data-only-letters data-max-length="30" data-required value="<?php echo $registros['sobrenome']; ?>">
                        </div>
                        <div class="half-box spacing">
                            <label for="idade">Data de nascimento</label>
                            <input type="date" name="idade" id="idade" value="<?php echo $registros['idade']; ?>" readonly>
                        </div>
                        <div class="half-box spacing">
                            <label for="sexo">Sexo</label>
                            <select id="sexo" name="sexo" placeholder="Selecione">
                                <option value="" disabled selected hidden>Selecione uma opção</option>
                                <option value="feminino" <?php if ($registros['sexo'] === 'feminino') echo 'selected'; ?>>Feminino</option>
                                <option value="masculino" <?php if ($registros['sexo'] === 'masculino') echo 'selected'; ?>>Masculino</option>
                            </select>
                        </div>
                        <div class="full-box spacing">
                            <label for="cpf">CPF</label>
                            <input type="text" pattern="[0-9]{3}[\.\s-][0-9]{3}[\.\s-][0-9]{3}-?[0-9]{2}" name="cpf" id="cpf" placeholder="Digite seu CPF" data-min-length="11" data-only-numbers data-required value="<?php echo $registros['cpf']; ?>" readonly>
                        </div>
                        <div class="full-box spacing">
                            <label for="telefone">Telefone</label>
                            <input type="tel" pattern="^[0-9]{3}[\s-][0-9]{4}$" name="telefone" id="telefone" placeholder="DDD + Telefone" data-only-numbers value="<?php echo $registros['telefone']; ?>">
                        </div>
                        <div class="half-box spacing">
                            <label for="cep">CEP</label>
                            <input type="text" pattern="[0-9]{5}-?[0-9]{3}" name="cep" id="cep" required placeholder="Digite seu CEP" maxlength="9" onblur="pesquisacep(this.value);" value="<?php echo $registros['cep']; ?>">
                        </div>
                        <div class="full-box spacing">
                            <label for="cidade">Cidade</label>
                            <input type="text" name="cidade" id="cidade" placeholder="Digite sua cidade" value="<?php echo $registros['cidade']; ?>">
                        </div>
                        <div class="full-box spacing">
                            <label for="logradouro">Logradouro</label>
                            <input type="text" name="logradouro" id="logradouro" placeholder="Digite seu logradouro" value="<?php echo $registros['logradouro']; ?>">
                        </div>
                        <div class="full-box spacing">
                            <label for="bairro">Bairro</label>
                            <input type="text" name="bairro" id="bairro" placeholder="Digite seu bairro" value="<?php echo $registros['bairro']; ?>">
                        </div>
                        <div class="half-box spacing">
                            <label for="n_residencia">Número</label>
                            <input type="text" name="n_residencia" id="n_residencia" placeholder="nº Residencial" data-max-length="4" data-only-numbers value="<?php echo $registros['n_residencia']; ?>">
                        </div>
                        <div class="half-box spacing">
                            <label for="complemento">Complemento</label>
                            <input type="text" name="complemento" id="complemento" placeholder="Digite o complemento" value="<?php echo $registros['complemento']; ?>">
                        </div>
                        <div class="grande-box spacing">
                            <label for="email">E-mail</label>
                            <input type="email" name="email" id="email" placeholder="Digite seu e-mail" data-email-validate value="<?php echo $registros['email']; ?>" readonly>
                        </div>
                        <div class="full-box spacing">
                            <label for="senha">Senha</label>
                            <input type="password" name="senha" id="senha" placeholder="Digite sua senha" data-password-validate data-required value="<?php echo $registros['senha']; ?>">
                            <i class="bi bi-eye-slash-fill" id="btn-senha" onclick="mostrarSenha()"></i>
                        </div>
                        <div class="full-box spacing">
                            <label for="passconfirmation">Confirmação de senha</label>
                            <input type="password" name="passconfirmation" id="passwordconfirmation" placeholder="Confirme sua senha" data-equal="password" data-required value="<?php echo $registros['passwordconfirmation']; ?>">
                            <i class="bi bi-eye-slash-fill" id="btn-senha2" onclick="mostrarSenha2()"></i>
                        </div>
                        <div class="full-box spacing">
                            <input type="submit" value="Salvar Alterações">
                        </div>
                    </form>
                </div>
            </body>
            </html>
            <?php
        } else {
            echo "<script>window.alert('Usuário não encontrado.');</script>";
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
} else {
    echo "<script>window.alert('Por favor, faça o login para editar suas informações.');</script>";
}
?>
