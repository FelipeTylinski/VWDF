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
            $mensagem = "<div class='mensagem-erro'>Erro: Necessário preencher todos os campos!</div>";
        }

        if (!$empty_input) {
            $query_ensalamento = "INSERT INTO Ensalamento (curso, professor, data, hora, sala) VALUES (:curso, :professor, :data, :hora, :sala)";

            // Preparar e executar a query
            $cad_ensalamento = $conn->prepare($query_ensalamento);
            $cad_ensalamento->bindParam(':curso', $dados['curso'], PDO::PARAM_STR);
            $cad_ensalamento->bindParam(':professor', $dados['professor'], PDO::PARAM_STR);
            $cad_ensalamento->bindParam(':data', $dados['data'], PDO::PARAM_STR);
            $cad_ensalamento->bindParam(':hora', $dados['hora'], PDO::PARAM_STR);
            $cad_ensalamento->bindParam(':sala', $dados['sala'], PDO::PARAM_STR);
            $cad_ensalamento->execute();

            if ($cad_ensalamento->rowCount()) {
                $mensagem = "<div class='mensagem-sucesso'>Ensalamento cadastrado com sucesso!</div>";
                // Limpar os campos do formulário após o cadastro
                unset($dados);
                
            } else {
                $mensagem = "<div class='mensagem-erro'>Erro: Ensalamento não cadastrado!</div>";
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
            box-sizing: border-box;
        }
        fieldset {
            border: 3px solid white;
            border-radius: 10px;
            padding: 20px;
        }
        legend {
            border: 2px solid white;
            padding: 10px;
            text-align: center;
            border-radius: 8px;
        }
        .inputBox {
            position: relative;
            margin-bottom: 20px;
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
        .styled-select {
            padding: 10px;
            background-color: rgba(0, 0, 0, 0.4);
            border: 1px solid white;
            color: white;
            width: 100%;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 15px;
        }
        /* Estilos para mensagens */
        .mensagem-sucesso, .mensagem-erro {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }
        .mensagem-sucesso {
            color: green;
            border: 2px solid green;
            background-color: rgba(0, 255, 0, 0.1);
        }
        .mensagem-erro {
            color: red;
            border: 2px solid red;
            background-color: rgba(255, 0, 0, 0.1);
        }
        .home-icon {
            width: 20px;
            height: 20px;
            vertical-align: middle;
        }
        .home-button {
            background: none;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            margin: 10px;
        }
    </style>
    <script>
        function goHome() {
            window.location.href = 'Pagina_principal.php';
        }
    </script>
</head>
<body>
<button class="home-button" onclick="goHome()">
        <img src="home-icon.png" class="home-icon">
    </button>

    <div class="box">
        <?php if (isset($mensagem)) echo $mensagem; ?>
        <form method="post" action="">
            <fieldset>
                <legend><b>Cadastro de Ensalamento</b></legend>
                <select name="curso" id="curso" class="styled-select">
                    <option value="Téc. Desenvolvimento de Sistemas">Téc. Desenvolvimento de Sistemas</option>
                    <option value="Téc. Alimentos">Téc. Alimentos</option>
                    <option value="Téc. Administração">Téc. Administração</option>
                    <option value="Téc. Automação Industrial">Téc. Automação Industrial</option>
                    <option value="Téc. Eletroeletrônica">Téc. Eletroeletrônica</option>
                </select>
                <div class="inputBox">
                    <input type="text" name="professor" id="professor" class="inputUser" required>
                    <label for="professor" class="labelInput">Professor</label>
                </div>
                <div class="inputBox">
                    <input type="text" name="data" id="data" class="inputUser" required>
                    <label for="data" class="labelInput">Dia</label>
                </div>
                <div class="inputBox">
                    <input type="text" name="hora" id="hora" class="inputUser" required>
                    <label for="hora" class="labelInput">Horário</label>
                </div>
                <select name="sala" id="sala" class="styled-select">
                    <option value="Lab de informática 1">Laboratório de informática 1</option>
                    <option value="Lab de informática 2">Laboratório de informática 2</option>
                    <option value="Simulador 1">Simulador 1</option>
                    <option value="Simulador 2">Simulador 2</option>
                    <option value="Oficina 1">Oficina 1</option>
                    <option value="Oficina 2">Oficina 2</option>
                </select>
                <input type="submit" name="submit" id="submit" value="Cadastrar">
            </fieldset>
        </form>
    </div>
</body>
</html>
