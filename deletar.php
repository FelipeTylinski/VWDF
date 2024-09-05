<?php
session_start();
include_once './Conexao.php';

    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (empty($id)) {
    $_SESSION['msg_sucesso'] = "<p style='color: #f00;'>Erro: Usuário não encotrado!</p>";
    header("location: Consultar.php");
    exit();
}

// delete usuario
$query_delete ="DELETE FROM ensalamento WHERE id =:id";
$result_delete=$conn->prepare($query_delete);
$result_delete-> bindParam(':id', $id);

 if($result_delete->execute()){
    $_SESSION['msg'] = "<p style='color: green; '> usuario deletado com sucesso' </p>";
    header("location: consultar.php");
 }else{
    $_SESSION['msg'] = "<p style='color: #f00; '> usuario não deletado' </p>";
    header("location: consultar.php");
 }
exit();
?>
 