<?php
session_start();
ob_start();
include_once './Conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!empty($dados["login"])) {
        if (filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
            $query_verificar = "SELECT * FROM cadastrar WHERE email = :email AND senha = :senha";
            $verificar = $conn->prepare($query_verificar);
            $verificar->bindParam(':email', $dados['email'], PDO::PARAM_STR);
            $verificar->bindParam(':senha', $dados['senha'], PDO::PARAM_STR);
            $verificar->execute();

            if ($verificar->rowCount() > 0) {
                $user = $verificar->fetch(PDO::FETCH_ASSOC);
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['tipo_usuario'] = $user['tipo_usuario']; // Assuming 'tipo_usuario' is the column name

                if ($user['tipo_usuario'] == 'secretaria') {
                    // Redirect to secretaria page
                    header("Location: Pagina_principal.php");
                } else {
                    // Redirect to main page
                    header("Location: Pagina_principal.php");
                }
                exit();
            } else {
                echo "<p style='color: red;'>Erro: Email ou senha incorretos!</p>";
            }
        } else {
            echo "<p style='color: red;'>Erro: Necessário preencher com um email válido!</p>";
        }
    } else {
        echo "<p style='color: red;'>Erro: Necessário preencher os campos!</p>";
    }
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <style>
        body {
            background-image: url('vwdf.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .container {
            width: 300px;
            border: 1px solid #ccc;
            padding: 20px;
            margin: 50px auto;
            box-sizing: border-box;
            border-radius: 15px;
            background-color: rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 35px;
            color: white;
        }
        label {
            display: block;
            margin-bottom: 10px;
            color: white;
            font-size: 22px;
            font-family: Arial, Helvetica, sans-serif;
        }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 15px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border-radius: 10px;
            outline: none;
        }
        input[type="submit"] {
            background-color: purple;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            outline: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Login</h1>
        <form name="acessar" method="POST" action="">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" placeholder="Email" required><br><br>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" placeholder="Password" required><br><br>

            <input type="submit" value="Login" name="login">
        </form>
    </div>
</body>
</html>
