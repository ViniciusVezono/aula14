<?php
    include('conexao.php'); 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = hash('sha256', $_POST['senha']); 

    $codigoSQL = "INSERT INTO `usuarios` (`nome`, `email`, `senha`) VALUES (:nome, :email, :senha)";
    
    try{
        $comando = $conexao->prepare($codigoSQL);
    
        $resultado = $comando->execute(array(
            'nome' => $nome,
            'senha' => $senha,
            'email' => $email
        ));

        if($resultado) {
            echo "Comando executado!";
            } else {
            echo "Erro ao executar o comando!";
            }
        } catch (Exception $e) {
            echo "Erro $e";
    }
}
?>
