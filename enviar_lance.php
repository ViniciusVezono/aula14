<?php
session_start();
include('conexao.php'); 


if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Usuário não está logado']);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

if (isset($_POST['item_id'], $_POST['valor_lance'])) {
    $item_id = $_POST['item_id'];
    $valor_lance = $_POST['valor_lance'];

    $sql = "SELECT * FROM itens WHERE id = :item_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':item_id', $item_id, PDO::PARAM_INT);
    $stmt->execute();

    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($item) {
        if ($valor_lance >= $item['minimo']) {

            $sql_lance = "INSERT INTO lances (item_id, usuario_id, valor) VALUES (:item_id, :usuario_id, :valor)";
            $stmt_lance = $conn->prepare($sql_lance);
            $stmt_lance->bindValue(':item_id', $item_id, PDO::PARAM_INT);
            $stmt_lance->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmt_lance->bindValue(':valor', $valor_lance, PDO::PARAM_STR);

            if ($stmt_lance->execute()) {

                if ($valor_lance > $item['minimo']) {
                    $sql_update = "UPDATE itens SET minimo = :minimo WHERE id = :item_id";
                    $stmt_update = $conn->prepare($sql_update);
                    $stmt_update->bindValue(':minimo', $valor_lance, PDO::PARAM_STR);
                    $stmt_update->bindValue(':item_id', $item_id, PDO::PARAM_INT);
                    $stmt_update->execute();
                }

                echo json_encode(['status' => 'sucesso', 'mensagem' => 'Lance registrado com sucesso']);
            } else {
                echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao registrar o lance']);
            }
        } else {
            echo json_encode(['status' => 'erro', 'mensagem' => 'O valor do lance deve ser maior ou igual ao lance mínimo']);
        }
    } else {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Item não encontrado']);
    }
} else {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Dados incompletos']);
}
?>
