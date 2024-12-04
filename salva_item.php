<?php
session_start();
include('conexao.php'); 


if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Usuário não está logado']);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];


if (isset($_POST['nome_item'], $_POST['minimo']) && isset($_FILES['imagem_item'])) {
    $nome_item = $_POST['nome_item'];
    $minimo = $_POST['minimo'];

    if ($_FILES['imagem_item']['error'] === UPLOAD_ERR_OK) {
        $imagem_item = $_FILES['imagem_item'];
        $imagem_nome = 'imagens/' . basename($imagem_item['name']);


        if (move_uploaded_file($imagem_item['tmp_name'], $imagem_nome)) {
  
            $sql = "INSERT INTO itens (nome, imagem, minimo, estado, usuario_id) VALUES (:nome, :imagem, :minimo, 'aberto', :usuario_id)";
            $stmt = $conn->prepare($sql);

    
            $stmt->bindValue(':nome', $nome_item, PDO::PARAM_STR);
            $stmt->bindValue(':imagem', $imagem_nome, PDO::PARAM_STR);
            $stmt->bindValue(':minimo', $minimo, PDO::PARAM_INT);
            $stmt->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                echo json_encode(['status' => 'sucesso']);
            } else {
                echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao salvar item']);
            }
        } else {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao mover o arquivo']);
        }
    } else {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Erro no upload do arquivo']);
    }
} else {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Dados incompletos']);
}
?>
