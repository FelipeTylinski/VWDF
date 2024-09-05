<?php
session_start();
ob_start();
include_once './Conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch user details
    $query_usuario = "SELECT id, curso, professor, data, hora, sala FROM ensalamento WHERE id = :id";
    $result_usuario = $conn->prepare($query_usuario);
    $result_usuario->bindParam(':id', $id);
    $result_usuario->execute();

    if ($result_usuario && $result_usuario->rowCount() > 0) {
        $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
    } else {
        $_SESSION['msg'] = "<p style='color: red;'>Usuário não encontrado!</p>";
        header("Location: Consultar.php");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $curso = $_POST['curso'];
    $professor = $_POST['professor'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $sala = $_POST['sala'];

    // Update user details
    $query_update = "UPDATE ensalamento SET curso = :curso, professor = :professor, data = :data, hora = :hora, sala = :sala WHERE id = :id";
    $result_update = $conn->prepare($query_update);
    $result_update->bindParam(':id', $id);
    $result_update->bindParam(':curso', $curso);
    $result_update->bindParam(':professor', $professor);
    $result_update->bindParam(':data', $data);
    $result_update->bindParam(':hora', $hora);
    $result_update->bindParam(':sala', $sala);

    if ($result_update->execute()) {
        $_SESSION['msg'] = "<p style='color: green;'>Usuário atualizado com sucesso!</p>";
        header("Location: Consultar.php");
    } else {
        $_SESSION['msg'] = "<p style='color: red;'>Erro ao atualizar o usuário!</p>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar </title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: linear-gradient(to right, gray, black);
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: blue;
        }
        .edit-form {
            
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color:  rgba(0, 0, 0, 0.4);
            padding: 20px;
            margin: 20px auto;
            max-width: 600px;
            color:blue;
        }
        .edit-form div {
            margin-bottom: 10px;
            color: blue;
        }
        .edit-form label {
            display: inline-block;
            width: 100px;
            color: blue;
        }
        .edit-form input {
            padding: 8px;
            width: calc(100% - 120px);
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .edit-form button {
            background: blue;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
        }
        .inputuser{
            background-image: linear-gradient(to right, gray, black);
            color: white;
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
            window.location.href = 'Consultar.php';
        }
    </script>
</head>
<body>
<button class="home-button" onclick="goHome()">
        <img src="home-icon.png" class="home-icon">
    </button>
    <h1>Editar Usuário</h1>
    <form class="edit-form" method="POST" action="">
        <input type="hidden" name="id" value="<?php echo $row_usuario['id']; ?>">
        <div>
            <label>Curso:</label>
            <input type="text" name="curso" class="inputuser" value="<?php echo $row_usuario['curso']; ?>">
        </div>
        <div>
            <label>Professor:</label>
            <input type="text" name="professor" class="inputuser" value="<?php echo $row_usuario['professor']; ?>">
        </div>
        <div>
            <label>Data:</label>
            <input type="text" name="data" class="inputuser" value="<?php echo $row_usuario['data']; ?>">
        </div>
        <div>
            <label>Hora:</label>
            <input type="text" name="hora" class="inputuser" value="<?php echo $row_usuario['hora']; ?>">
        </div>
        <div>
            <label>Sala:</label>
            <input type="text" name="sala" class="inputuser" value="<?php echo $row_usuario['sala']; ?>">
        </div>
        <button type="submit">Salvar</button>
    </form>
</body>
</html>
