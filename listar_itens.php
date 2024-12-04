<?php
session_start();
include('conexao.php'); 


if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}


$sql = "SELECT * FROM itens WHERE estado = 'aberto'";
$stmt = $conn->prepare($sql);
$stmt->execute();


$itens = $stmt->fetchAll(PDO::FETCH_ASSOC);


foreach ($itens as $item) {
    echo "<div>";
    echo "<h3>" . htmlspecialchars($item['nome']) . "</h3>";
    echo "<img src='" . htmlspecialchars($item['imagem']) . "' alt='" . htmlspecialchars($item['nome']) . "' />";
    echo "<p>Preço Mínimo: R$" . number_format($item['minimo'], 2, ',', '.') . "</p>";

    if ($item['usuario_id'] == $_SESSION['usuario_id']) {
        echo "<form method='POST' action='encerrar_leilao.php'>";
        echo "<input type='hidden' name='item_id' value='" . $item['id'] . "'>";
        echo "<button type='submit'>Encerrar Leilão</button>";
        echo "</form>";
    }

    echo "</div>";
}
?>
