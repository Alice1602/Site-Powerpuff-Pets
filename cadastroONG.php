<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de ONG</title>
    <link rel="stylesheet" href="css/cadUsuario.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="images/logoGG.png">
    <script>
        function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('logradouro').value = ("");
            document.getElementById('bairro').value = ("");
            document.getElementById('cidade').value = ("");
        }

        function meu_callback(conteudo) {
            if (!("erro" in conteudo)) {
                //Atualiza os campos com os valores.
                document.getElementById('logradouro').value = (conteudo.logradouro);
                document.getElementById('bairro').value = (conteudo.bairro);
                document.getElementById('cidade').value = (conteudo.localidade);
            } //end if.
            else {
                //CEP não Encontrado.
                limpa_formulário_cep();
                alert("CEP não encontrado.");
            }
        }

        function pesquisacep(valor) {

            //Nova variável "cep" somente com dígitos.
            var cep = valor.replace(/\D/g, '');

            //Verifica se campo cep possui valor informado.
            if (cep != "") {

                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;

                //Valida o formato do CEP.
                if (validacep.test(cep)) {

                    //Preenche os campos com "..." enquanto consulta webservice.
                    document.getElementById('logradouro').value = "...";
                    document.getElementById('bairro').value = "...";
                    document.getElementById('cidade').value = "...";

                    //Cria um elemento javascript.
                    var script = document.createElement('script');

                    //Sincroniza com o callback.
                    script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

                    //Insere script no documento e carrega o conteúdo.
                    document.body.appendChild(script);

                } //end if.
                else {
                    //cep é inválido.
                    limpa_formulário_cep();
                    alert("Formato de CEP inválido.");
                }
            } //end if.
            else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep();
            }
        };
    </script>
</head>

<body>
    <p><b><a class="Home" href="powerfullpets.php" target="_blank">Início</a> / </b> <b><a class="Home" href="Login.php" target="_blank">Já tem login?</a></b></p>
    <br>

    <div id="main-container">
        <h1>Cadastre-se sua ONG em nosso site</h1><br>
        <br>
        <br>
        <form id="registro-form" action="cadONG.php" method="post">
            <div class="half-box spacing">
                <label for="nome">Nome da empresa</label>
                <input type="text" name="nome" id="nome" placeholder="Digite seu nome">
            </div><br>

            <div class="half-box spacing">
                <label for="responsavel">Dono da empresa</label>
                <input type="text" name="responsavel" id="responsavel" placeholder="Digite o nome do responsável da empresa">
            </div><br>

            <div class="half-box spacing">
                <label for="cnpj">CNPJ</label>
                <input type="text" name="cnpj" id="cnpj" placeholder="Digite o CNPJ da empresa" data-min-length="14" data-only-numbers data-required>
            </div>

            <div class="half-box spacing">
                <label for="telefone">Telefone</label>
                <input type="tel" name="telefone" id="telefone" placeholder="DDD + Telefone" data-min-length="11" data-only-numbers data-required>
            </div>

            <div class="half-box spacing"> <!-- campo menores -->
                <label for="cep">CEP</label>
                <input type="text" name="cep" id="cep" required placeholder="Digite seu CEP" maxlength="9" onblur="pesquisacep(this.value);">
            </div>

            <div class="half-box spacing">
                <label for="cidade">Cidade</label>
                <input type="text" name="cidade" id="cidade" placeholder="Digite sua cidade">
            </div>

            <div class="half-box spacing">
                <label for="logradouro">Logradouro</label>
                <input type="text" name="logradouro" id="logradouro" placeholder="Digite seu logradouro">
            </div>

            <div class="half-box spacing">
                <label for="bairro">Bairro</label>
                <input type="text" name="bairro" id="bairro" placeholder="Digite seu bairro">
            </div>


            <div class="half-box spacing"> <!-- campo menores -->
                <label for="n_residencia">Número</label>
                <input type="text" name="n_residencia" id="n_residencia" placeholder="nº Residêncial" maxlength="4" data-only-numbers>
            </div>

                <div class="grande-box spacing"> 
                    <label for="descricao">Descrição</label>
                    <textarea class="texto" name="descricao" rows="4" cols="100" placeholder="Descreva sobre sua empresa."></textarea>
                </div>

            <div class="grande-box spacing">
                <label for="email">E-mail</label> <!-- campo grande -->
                <input type="email" name="email" id="email" placeholder="Digite seu e-mail" data-email-validate>
            </div>

            <div class="full-box spacing">
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" placeholder="Digite sua senha" data-password-validate data-required>
                <i class="bi bi-eye-slash-fill" id="btn-senha" onclick="mostrarSenha()"></i>
            </div>

            <div class="full-box spacing">
                <label for="passconfirmation">Confirmação de senha</label>
                <input type="password" name="passconfirmation" id="passwordconfirmation" placeholder="Confirme sua senha" data-equal="password" data-required>
                <i class="bi bi-eye-slash-fill" id="btn-senha2" onclick="mostrarSenha2()"></i>
            </div>

            <div class="full-box spacing">
                <input type="submit" value="Cadastrar">
            </div>
        </form>
        <br>
        <br>
        <br>
        <br>
    </div>
    <p class="error-validation template"></p>
    <script src="js/scriptCadUsuario.js"></script>
    <script src="js/main.js"></script>
</body>
</html>