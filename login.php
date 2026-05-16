<?php
session_start();
ob_start();
include_once './Conexao.php';

$erro = '';

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
                $_SESSION['tipo_usuario'] = $user['tipo_usuario'];
                header("Location: Pagina_principal.php");
                exit();
            } else {
                $erro = "⚠ Email ou senha incorretos!";
            }
        } else {
            $erro = "⚠ Preencha com um email válido!";
        }
    } else {
        $erro = "⚠ Preencha todos os campos!";
    }
}
?>
<!DOCTYPE HTML>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
            background: #0a0a0f;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* Fundo animado */
     body::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;

    width: 100%;
    height: 100%;

    background:
        linear-gradient(
            rgba(0,0,0,0.45),
            rgba(0,0,0,0.45)
        ),
        url('NOVA.png');

    background-position: center center;
    background-repeat: no-repeat;

    /* ocupa a tela toda */
    background-size: cover;

    z-index: 0;

    animation: bgPulse 8s ease-in-out infinite alternate;
}
        @keyframes bgPulse {
            0%   { opacity: 0.6; }
            100% { opacity: 1; }
        }

        /* Grid futurista */
        body::after {
            content: '';
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-image:
                linear-gradient(rgba(100, 50, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(100, 50, 255, 0.03) 1px, transparent 1px);
            background-size: 40px 40px;
            z-index: 0;
        }

        /* Card */
        .card {
            position: relative;
            z-index: 10;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 48px 40px;
            width: 100%;
            max-width: 400px;
            backdrop-filter: blur(20px);
            box-shadow:
                0 0 0 1px rgba(130, 50, 255, 0.1),
                0 20px 60px rgba(0, 0, 0, 0.5),
                inset 0 1px 0 rgba(255,255,255,0.05);
            animation: fadeUp 0.6s ease forwards;
        }

        /* Linha brilhante no topo */
        .card::before {
            content: '';
            position: absolute;
            top: 0; left: 10%; right: 10%;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(130, 50, 255, 0.8), transparent);
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Título */
        .card-title {
            text-align: center;
            margin-bottom: 36px;
        }

        .card-title h1 {
            font-size: 28px;
            font-weight: 700;
            background: linear-gradient(135deg, #fff 0%, #a78bfa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 1px;
        }

        .card-title p {
            color: rgba(255,255,255,0.35);
            font-size: 13px;
            margin-top: 6px;
        }

        /* Grupos de input */
        .input-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 18px;
        }

        .input-group label {
            font-size: 11px;
            font-weight: 600;
            color: rgba(255,255,255,0.4);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .input-group input {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 10px;
            padding: 13px 16px;
            color: white;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
            width: 100%;
        }

        .input-group input:focus {
            border-color: rgba(130, 50, 255, 0.6);
            background: rgba(130, 50, 255, 0.07);
            box-shadow: 0 0 0 3px rgba(130, 50, 255, 0.1);
        }

        .input-group input::placeholder {
            color: rgba(255,255,255,0.2);
        }

        /* Mensagem de erro */
        .msg-error {
            background: rgba(255, 60, 60, 0.1);
            border: 1px solid rgba(255, 60, 60, 0.2);
            color: #ff8080;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Botões */
        .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 8px;
        }

        .btn-primary {
            flex: 1;
            padding: 13px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #6d28d9, #4f46e5);
            color: white;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(109, 40, 217, 0.4);
        }

        /* Efeito brilho */
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255,255,255,0.15), transparent);
            transition: 0.5s;
        }

        .btn-primary:hover::before { left: 100%; }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(109, 40, 217, 0.6);
        }

        .btn-primary:active { transform: scale(0.98); }

        .btn-secondary {
            flex: 1;
            padding: 13px;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            background: rgba(255,255,255,0.03);
            color: rgba(255,255,255,0.5);
            font-size: 14px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .btn-secondary::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255,255,255,0.08), transparent);
            transition: 0.5s;
        }

        .btn-secondary:hover::before { left: 100%; }

        .btn-secondary:hover {
            border-color: rgba(255,255,255,0.2);
            color: white;
            background: rgba(255,255,255,0.06);
            transform: translateY(-2px);
        }

        .btn-secondary:active { transform: scale(0.98); }
    </style>
</head>
<body>
    <div class="card">

        <div class="card-title">
            <h1>Bem-vindo</h1>
            <p>Faça login para continuar</p>
        </div>

        <?php if ($erro): ?>
            <div class="msg-error"><?= $erro ?></div>
        <?php endif; ?>

        <form name="acessar" method="POST" action="">

            <div class="input-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" placeholder="seu@email.com" required>
            </div>

            <div class="input-group">
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" placeholder="••••••••" required>
            </div>

            <div class="btn-group">
                <input type="submit" value="Entrar" name="login" class="btn-primary">
                <button type="button" class="btn-secondary" onclick="window.location.href='Cadastro.php'">Cadastrar</button>
            </div>

        </form>
    </div>
</body>
</html>