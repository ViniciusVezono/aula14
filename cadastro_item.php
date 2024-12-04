<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {

    header("Location: login.php");
    exit; 
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Item</title>
</head>
<body>
    <h1>Cadastrar Item para Leilão</h1>
    <form action="salva_item.php" method="POST" enctype="multipart/form-data">
    <label for="nome_item">Nome do Item:</label>
    <input type="text" name="nome_item" id="nome_item" required><br><br>

    <label for="imagem_item">Imagem do Item:</label>
    <input type="file" name="imagem_item" id="imagem_item" required><br><br>

    <label for="minimo">Lance Mínimo:</label>
    <input type="number" name="minimo" id="minimo" required><br><br>

    <input type="submit" value="Cadastrar Item">
</form>

</body>
</html>
