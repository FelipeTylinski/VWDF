<?php
include_once './Conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!empty($dados["submit"])) {
        $empty_input = false;

        // Validar se todos os campos foram preenchidos
        $dados = array_map('trim', $dados);
        if (in_array("", $dados)) {
            $empty_input = true;
            echo "<p style='color: red;'>Erro: Necessário preencher todos os campos!</p>"; 
        } elseif (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
            $empty_input = true;
            echo "<p style='color: red;'>Erro: Necessário preencher com um e-mail válido!</p>";
        }

        if (!$empty_input) {
            // Criptografar a senha antes de salvar no banco de dados
            $hashed_password = password_hash($dados['senha'], PASSWORD_DEFAULT);

            $query_usuario = "INSERT INTO cadastrar (nome, email, telefone, sexo, data_nasc, cidade, estado, endereco, senha, tipo_usuario) 
                              VALUES (:Nome, :Email, :Telefone, :Sexo, :Data_nasc, :Cidade, :Estado, :Endereco, :Senha, :Tipo_usuario)";
            
            // Preparar e executar a query
            $cad_usuario = $conn->prepare($query_usuario);
            $cad_usuario->bindParam(':Nome', $dados['nome'], PDO::PARAM_STR);
            $cad_usuario->bindParam(':Email', $dados['email'], PDO::PARAM_STR);
            $cad_usuario->bindParam(':Telefone', $dados['telefone'], PDO::PARAM_STR);
            $cad_usuario->bindParam(':Sexo', $dados['genero'], PDO::PARAM_STR);
            $cad_usuario->bindParam(':Data_nasc', $dados['data_nascimento'], PDO::PARAM_STR);
            $cad_usuario->bindParam(':Cidade', $dados['cidade'], PDO::PARAM_STR);
            $cad_usuario->bindParam(':Estado', $dados['estado'], PDO::PARAM_STR);
            $cad_usuario->bindParam(':Endereco', $dados['endereco'], PDO::PARAM_STR);
            $cad_usuario->bindParam(':Senha', $hashed_password, PDO::PARAM_STR); // Usar a senha criptografada
            $cad_usuario->bindParam(':Tipo_usuario', $dados['tipo_usuario'], PDO::PARAM_STR);
            $cad_usuario->execute();

            if ($cad_usuario->rowCount()) {
                echo "<p style='color: green;'>Usuário cadastrado com sucesso!</p>";
                unset($dados); // Limpar os campos do formulário após o cadastro
                header("Location: pagina_Principal.php"); // Redirecionar para a página principal
                exit();
            } else {
                echo "<p style='color: red;'>Erro: usuário não cadastrado!</p>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-image: linear-gradient(to right, gray, black);
        }
        .box {
            color: white;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.4);
            padding: 15px;
            border-radius: 15px;
            width: 20%;  
        }
        fieldset {
            border: 3px solid white;
            border-radius: 10px;
        }
        legend {
            border: 2px solid white;
            padding: 10px;
            text-align: center;
            border-radius: 8px;           
        }
        .inputBox {
            position: relative;
        }
        .inputUser {
            background: none;
            border: none;
            border-bottom: 1px solid white;
            outline: none;
            color: white;
            font-size: 15px;
            width: 100%;
            letter-spacing: 2px;
        }
        .labelInput {
            position: absolute;
            top: 0px;
            left: 0px;
            pointer-events: none;
            transition: .5s;
        }
        .inputUser:focus ~ .labelInput,
        .inputUser:valid ~ .labelInput {
            top: -20px;
            font-size: 12px;
            color: purple;
        }
        #data_nascimento {
            border: none;
            padding: 8px;
            border-radius: 10px;
            outline: none;
            font-size: 15px;
        }
        #submit {
            background-image: linear-gradient(to right, rgb(0, 92, 197), rgb(90, 20, 220));
            width: 100%;
            border: none;
            padding: 15px;
            color: white;
            font-size: 15px;
            cursor: pointer;
            border-radius: 10px;
        }
        #submit:hover {
            background-image: linear-gradient(to right, rgb(0, 80, 172), rgb(80, 19, 195));
        }
    </style>
</head>
<body>
    <div class="box">
        <form method="post" action="">
            <fieldset>
                <legend><b>Formulário de Cadastro</b></legend>
                
                <div class="inputBox">
                    <input type="text" name="nome" id="nome" class="inputUser" required>
                    <label for="nome" class="labelInput">Nome completo</label>
                </div>
                <br>
                <div class="inputBox">
                    <input type="email" name="email" id="email" class="inputUser" required>
                    <label for="email" class="labelInput">Email</label>
                </div>
                <br>
                <div class="inputBox">
                    <input type="tel" name="telefone" id="telefone" class="inputUser" required>
                    <label for="telefone" class="labelInput">Telefone</label>
                </div>
                <p>Sexo:</p>
                <input type="radio" id="feminino" name="genero" value="feminino" required>
                <label for="feminino">Feminino</label>
                <br>
                <input type="radio" id="masculino" name="genero" value="masculino" required>
                <label for="masculino">Masculino</label>
                <br>
                <input type="radio" id="outro" name="genero" value="outro" required>
                <label for="outro">Outro</label>
                <br>
                <label for="data_nascimento"><b>Data de Nascimento</b></label>
                <input type="date" name="data_nascimento" id="data_nascimento" required>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="cidade" id="cidade" class="inputUser" required>
                    <label for="cidade" class="labelInput">Cidade</label>
                </div>
                <br>
                <div class="inputBox">
                    <input type="text" name="estado" id="estado" class="inputUser" required>
                    <label for="estado" class="labelInput">Estado</label>
                </div>
                <br>
                <div class="inputBox">
                    <input type="text" name="endereco" id="endereco" class="inputUser" required>
                    <label for="endereco" class="labelInput">Endereço</label>
                </div>
                <br>
                <div class="inputBox">
                    <input type="password" name="senha" id="senha" class="inputUser" required>
                    <label for="senha" class="labelInput">Senha</label>
                </div>
                <br>
                <p>Tipo de Usuário:</p>
                <input type="radio" id="aluno" name="tipo_usuario" value="aluno" required>
                <label for="aluno">Aluno</label>
                <br>
                <input type="radio" id="secretaria" name="tipo_usuario" value="secretaria" required>
                <label for="secretaria">Secretaria</label>
                <br><br>
                <input type="submit" name="submit" id="submit" value="Cadastrar">
            </fieldset>
        </form>
    </div>
</body>
</html>
