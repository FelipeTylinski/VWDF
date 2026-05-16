<?php
session_start();  
include_once './Conexao.php'; // Conexão com banco de dados

// Verifica o tipo de usuário na sessão
$tipo_usuario = isset($_SESSION['tipo_usuario']) ? $_SESSION['tipo_usuario'] : '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-image: url('NOVA.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            color: #333;
        }

        header {
            background-color: rgba(0, 0, 0, 0.4);
            color: #fff;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        /* Barra lateral */
        nav {
            background-color: rgba(0, 0, 0, 0.5);
            width: 200px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            overflow: auto;
            padding-top: 20px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.4);
            display: flex;
            flex-direction: column;
            gap: 8px;
            padding: 20px 10px;
            box-sizing: border-box;
        }

        /* Estilo base dos botões/links da nav */
        nav a, .logout-btn {
            color: #fff;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            font-weight: bold;
            font-size: 14px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            text-align: left;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, rgba(255,255,255,0.05), rgba(255,255,255,0.1));
            backdrop-filter: blur(5px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
            letter-spacing: 0.5px;
        }

        /* Efeito de brilho ao passar o mouse */
        nav a::before, .logout-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                120deg,
                transparent,
                rgba(255, 255, 255, 0.25),
                transparent
            );
            transition: 0.5s;
        }

        nav a:hover::before, .logout-btn:hover::before {
            left: 100%; /* Brilho desliza da esquerda para direita */
        }

        /* Efeito hover nos links */
        nav a:hover {
            background: linear-gradient(135deg, #6a0dad, #9b30ff);
            transform: translateX(5px); /* Desloca levemente para direita */
            box-shadow: 0 6px 15px rgba(106, 13, 173, 0.5);
            letter-spacing: 1px;
        }

        /* Botão de logout com cor diferente */
        .logout-btn {
            background: linear-gradient(135deg, #c0392b, #e74c3c);
            margin-top: auto; /* Empurra o logout para o fundo */
            width: 100%;
            font-family: 'Roboto', sans-serif;
        }

        .logout-btn:hover {
            background: linear-gradient(135deg, #e74c3c, #ff6b6b);
            transform: translateX(5px);
            box-shadow: 0 6px 15px rgba(231, 76, 60, 0.5);
        }

        /* Efeito de clique */
        nav a:active, .logout-btn:active {
            transform: scale(0.95);
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        main {
            margin-left: 220px;
            flex: 1;
            padding: 20px;
        }

        section {
            color: #fff;
            text-align: center;
            border-radius: 12px;
        }

        footer {
            background-color: rgba(0, 0, 0, 0.4);
            color: #fff;
            text-align: center;
            padding: 10px 0;
            width: 100%;
            box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.3);
            position: fixed;
            bottom: 0;
            left: 0;
        }

        @media (max-width: 600px) {
            nav {
                width: 100%;
                height: auto;
                position: relative;
                flex-direction: row;
                flex-wrap: wrap;
            }
            nav a {
                float: left;
                padding: 10px;
            }
            main {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

<header>
    <h1>Bem-Vindo à Página Principal</h1>
</header>

<nav>
    <!-- Link para consultar -->
    <a href="Consultar.php">🔍 Consultar</a>

    <!-- Exibe opções extras dependendo do tipo de usuário -->
    <?php if ($tipo_usuario == 'secretaria'): ?>
        <a href="Cad_ensalamento.php">📋 Novo Ensalamento</a>
        <a href="Cadastro.php">👤 Cadastrar Usuário</a>
    <?php endif; ?>

    <!-- Botão de logout -->
    <form method="POST" action="logout.php">
        <button type="submit" class="logout-btn">🚪 Sair</button>
    </form>
</nav>

<main>
    <section>
        <h2>O que você procura?</h2>
        <p>Explore nossos serviços e descubra mais sobre nós.</p>
    </section>
</main>

<footer>
    <p>&copy; 2024 Página Inicial. Todos os direitos reservados.</p>
</footer>

</body>
</html> 