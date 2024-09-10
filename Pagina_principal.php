<?php
session_start();  
include_once './Conexao.php';  // Conexao com banco de dados 

// Verifica se o tipo de usuário está armazenado na sessão. Se estiver, atribui à variável $tipo_usuario.
// Caso contrário, atribui uma string vazia.
$tipo_usuario = isset($_SESSION['tipo_usuario']) ? $_SESSION['tipo_usuario'] : '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  <!-- Torna o site responsivo -->
    <title>Página Principal</title>  <!-- Define o título da página -->

    <!-- Estilos CSS internos para estilizar a página -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;  /* Define a fonte da página */
            background-image: url('vwdf.jpg');  /* Adiciona uma imagem de fundo */
            background-size: cover;  /* Ajusta a imagem para cobrir todo o fundo */
            background-repeat: no-repeat;  /* Evita que a imagem de fundo se repita */
            background-position: center;  /* Centraliza a imagem de fundo */
            margin: 0;  /* Remove a margem padrão do body */
            padding: 0;  /* Remove o padding padrão do body */
            display: flex;  /* Define o display como flex */
            flex-direction: column;  /* Coloca os elementos em uma coluna */
            min-height: 100vh;  /* Define uma altura mínima de 100% da viewport */
            color: #333;  /* Define a cor do texto como um cinza escuro */
        }

        header {
            background-color: rgba(0, 0, 0, 0.1);  /* Define uma cor de fundo semi-transparente */
            color: #fff;  /* Define a cor do texto como branco */
            padding: 20px;  /* Adiciona padding ao redor do conteúdo do header */
            text-align: center;  /* Centraliza o texto no header */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);  /* Adiciona uma sombra ao header */
        }

        nav {
            background-color: rgba(0, 0, 0, 0.1);  /* Define uma cor de fundo semi-transparente para a barra de navegação */
            width: 200px;  /* Define a largura fixa da barra lateral */
            position: fixed;  /* Fixa a barra lateral na tela */
            top: 0;  /* Alinha no topo */
            left: 0;  /* Alinha à esquerda */
            height: 100%;  /* Define a altura como 100% da tela */
            overflow: auto;  /* Adiciona scroll se o conteúdo for maior que a tela */
            padding-top: 20px;  /* Adiciona um espaçamento no topo da barra lateral */
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);  /* Adiciona sombra à lateral */
        }

        nav a, .logout-btn {
            color: #fff;  /* Define a cor do texto como branco */
            text-decoration: none;  /* Remove o sublinhado dos links */
            padding: 15px 20px;  /* Adiciona padding aos links */
            display: block;  /* Faz os links ocuparem toda a largura disponível */
            font-weight: bold;  /* Deixa o texto em negrito */
            transition: background 0.3s;  /* Adiciona uma transição suave ao background */
        }

        nav a:hover, .logout-btn:hover {
            background-color: #575757;  /* Altera a cor de fundo ao passar o mouse sobre o link */
        }

        main {
            margin-left: 220px;  /* Adiciona uma margem à esquerda para acomodar a barra lateral */
            flex: 1;  /* Faz o conteúdo principal ocupar o espaço restante */
            padding: 20px;  /* Adiciona padding ao conteúdo principal */
        }

        section {
            color: #fff;  /* Define a cor do texto como branco */
            text-align: center;  /* Centraliza o texto */
            border-radius: 12px;  /* Adiciona bordas arredondadas */
        }

        footer {
            background-color: rgba(0, 0, 0, 0.1);  /* Define uma cor de fundo semi-transparente para o rodapé */
            color: #fff;  /* Define a cor do texto como branco */
            text-align: center;  /* Centraliza o texto no rodapé */
            padding: 10px 0;  /* Adiciona padding ao redor do texto no rodapé */
            width: 100%;  /* Faz o rodapé ocupar toda a largura */
            box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.2);  /* Adiciona uma sombra ao rodapé */
            position: fixed;  /* Fixa o rodapé no fundo da página */
            bottom: 0;  /* Alinha o rodapé ao fundo */
            left: 0;  /* Alinha o rodapé à esquerda */
        }

        .logout-btn {
            background-color: #ff4b5c;  /* Define a cor de fundo para o botão de logout */
            border: none;  /* Remove a borda padrão do botão */
            cursor: pointer;  /* Muda o cursor para pointer ao passar o mouse */
            text-align: left;  /* Alinha o texto à esquerda dentro do botão */
        }

        .logout-btn:hover {
            background-color: #e43f52;  /* Altera a cor de fundo ao passar o mouse sobre o botão de logout */
        }

        @media (max-width: 600px) {
            nav {
                width: 100%;  /* Faz a barra lateral ocupar toda a largura da tela em telas menores */
                height: auto;  /* Define a altura como automática */
                position: relative;  /* Remove a posição fixa da barra lateral */
            }
            nav a {
                float: left;  /* Faz os links flutuarem à esquerda */
                padding: 10px;  /* Reduz o padding para telas menores */
            }
            main {
                margin-left: 0;  /* Remove a margem da esquerda para telas menores */
            }
        }
    </style>
</head>
<body>
<header>
    <h1> à Página Principal</h1>  <!-- Cabeçalho da página -->
</header>
<nav>
    <!-- Formulário para logout -->
    <form method="POST" action="logout.php">
        <button type="submit" class="logout-btn">Sair</button>  <!-- Botão de logout -->
    </form>
    
    <!-- Links de navegação -->
    <a href="Consultar.php">Consultar</a>  <!-- Link para consultar -->
    
    <!-- Verifica se o usuário não é um aluno e exibe opções adicionais -->
    <?php if ($tipo_usuario = 'aluno'): ?>
        <a href="Cad_ensalamento.php">Novo Ensalamento</a>  <!-- Link para cadastro de ensalamento -->
        <a href="Cadastro.php">Cadastrar Usuário</a>  <!-- Link para cadastro de usuário -->
    <?php endif; ?>
</nav>
<main>
    <section>
        <h2>O que você procura?</h2>  <!-- Título do conteúdo principal -->
        <p>Explore nossos serviços e descubra mais sobre nós.</p>  <!-- Texto descritivo -->
    </section>
</main>
<footer>
    <p>&copy; 2024 Página Inicial. Todos os direitos reservados.</p>  <!-- Rodapé com direitos reservados -->
</footer>
</body>
</html>
        