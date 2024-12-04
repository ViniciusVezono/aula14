<?php
session_start();
include('conexao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Usuário não está logado']);
    exit;
}

// Verifica se o ID do item foi passado via POST
if (!isset($_POST['item_id'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'ID do item não fornecido']);
    exit;
}

$item_id = $_POST['item_id'];
$usuario_id = $_SESSION['usuario_id'];

// Consulta para verificar se o item existe e se o usuário é o dono
$sql = "SELECT * FROM itens WHERE id = :item_id AND usuario_id = :usuario_id";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':item_id', $item_id, PDO::PARAM_INT);
$stmt->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
$stmt->execute();

$item = $stmt->fetch(PDO::FETCH_ASSOC);


if (!$item) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Item não encontrado ou você não é o dono do item']);
    exit;
}


if ($item['estado'] === 'encerrado') {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Este item já foi encerrado']);
    exit;
}


$sql_lances = "SELECT * FROM lances WHERE item_id = :item_id ORDER BY valor DESC LIMIT 1";
$stmt_lances = $conn->prepare($sql_lances);
$stmt_lances->bindValue(':item_id', $item_id, PDO::PARAM_INT);
$stmt_lances->execute();

$lance = $stmt_lances->fetch(PDO::FETCH_ASSOC);


if ($lance) {
   
    $sql_update_item = "UPDATE itens SET estado = 'encerrado', vencedor = :vencedor_id WHERE id = :item_id";
    $stmt_update_item = $conn->prepare($sql_update_item);
    $stmt_update_item->bindValue(':vencedor_id', $lance['usuario_id'], PDO::PARAM_INT);
    $stmt_update_item->bindValue(':item_id', $item_id, PDO::PARAM_INT);
    $stmt_update_item->execute();

    echo json_encode(['status' => 'sucesso', 'mensagem' => 'Leilão encerrado com sucesso. O vencedor é o usuário com ID ' . $lance['usuario_id']]);
} else {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Não há lances registrados para este item']);
}
?>
