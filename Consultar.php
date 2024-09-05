<?php

session_start();

ob_start();

include_once './Conexao.php'; // conexao com banco de dados 

$search_term = ''; // Inicializa a variável $search_term com uma string vazia.
if (isset($_POST['search'])) { // Verifica se o campo 'search' foi enviado no formulário via método POST.
    $search_term = $_POST['search']; // Atribui o valor do campo 'search' à variável $search_term.
}


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Visualizar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: linear-gradient(to right, grey, black);
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: blue;
        }
        .search-form {
            align-items: 30px;
            text-align: center;
            margin-bottom: 20px;
        }
        .search-input {
            margin: 15px;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: rgba(0, 0, 0, 0.4);
            padding: 15px 30px;
            max-width: 900px;
            color: white;
            
        }
        .search-button {
            font-size: 17px;
            font-family: Arial, Helvetica, sans-serif;
            background: #007bff;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
            text-decoration: none;
            width: auto;
        }
        .user-card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: rgba(0, 0, 0, 0.4);
            padding: 15px;
            margin: 20px auto;
            max-width: 600px;
            color: white;
        }
        .user-card strong {
            display: inline-block;
            width: 100px;
            color: blue;
        }
        .user-card div {
            margin-bottom: 10px;
        }
        .no-users {
            text-align: center;
            color: red;
            margin-top: 20px;
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
        .edit-button {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
            text-decoration: none;
        }
        .edit-button:hover {
            background: #0056b3;
        }
        .delete-button {
            background: red;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 30px;
            text-decoration: none;
            margin: 20px;
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
    <h1>Consulta</h1>
    <form class="search-form" method="POST" action="">
        <input type="text" name="search" class="search-input" placeholder="Buscar curso" value="<?php echo htmlspecialchars($search_term); ?>">
        <button type="submit" class="search-button">Buscar</button>
    </form>

    <?php
    // Query para buscar os usuários com base no termo de busca
    $query_usuarios = "SELECT id, curso, professor, data, hora, sala FROM ensalamento"; // Consulta inicial para buscar dados da tabela 'ensalamento'
    
    if (!empty($search_term)) { // Verifica se há um termo de busca fornecido
        $query_usuarios .= " WHERE curso LIKE :search_term OR professor LIKE :search_term"; // Adiciona uma cláusula WHERE para filtrar pelo termo de busca no campo 'curso' ou 'professor'
    }
    
    $result_usuarios = $conn->prepare($query_usuarios); // Prepara a consulta SQL
    
    if (!empty($search_term)) { // Verifica novamente se há um termo de busca
        $result_usuarios->bindValue(':search_term', '%' . $search_term . '%'); // Usa bindValue para associar o termo de busca, usando o operador LIKE com % para busca parcial
    }
    
    $result_usuarios->execute(); // Executa a consulta no banco de dados
    
    // Verifica se há usuários para exibir
    if ($result_usuarios && $result_usuarios->rowCount() > 0) { // Verifica se a consulta retornou algum resultado
        // Faz o loop através de cada usuário retornado e exibe seus detalhes
        while ($row_usuario = $result_usuarios->fetch(PDO::FETCH_ASSOC)) { // Busca cada registro como um array associativo
            extract($row_usuario); // Extrai as variáveis do array associativo ($id, $curso, $professor, $data, $hora, $sala)
            echo "<div class='user-card'>"; // Cria um contêiner para exibir as informações do usuário
            echo "<div><strong>Curso:</strong> $curso</div>"; // Exibe o curso
            echo "<div><strong>Professor:</strong> $professor</div>"; // Exibe o professor
            echo "<div><strong>Data:</strong> $data</div>"; // Exibe a data
            echo "<div><strong>Hora:</strong> $hora</div>"; // Exibe a hora
            echo "<div><strong>Sala:</strong> $sala</div>"; // Exibe a sala

            // Verifica se o usuário logado é do tipo 'secretaria' para exibir os botões de edição e exclusão
            if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 'secretaria') { 
                echo "<a class='edit-button' href='editar.php?id=$id'>Editar</a>"; // Link para editar o registro
                echo "<a class='delete-button' href='deletar.php?id=$id'>Deletar</a>"; // Link para deletar o registro
            }
            echo "</div>"; // Fecha o contêiner do usuário
        }
    } else {
        // Mensagem caso nenhum usuário seja encontrado
        echo "<p class='no-users'>Erro: Nenhum usuário encontrado!</p>"; // Exibe mensagem de erro caso nenhum registro seja encontrado
    }
?>
</body>
</html>
