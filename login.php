<?php
session_start();
include('conexao.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha']; 


    $senhaHash = hash('sha256', $senha);

    try {

        $sql = "SELECT * FROM usuarios WHERE email = :email AND senha = :senha";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senhaHash, PDO::PARAM_STR);


        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_email'] = $usuario['email'];

            header('cadastro_item.php');
        } else {

            echo json_encode(['status' => 'erro']);
        }
    } catch (PDOException $e) {

        echo "Erro na consulta: " . $e->getMessage();
    }
}
?>
