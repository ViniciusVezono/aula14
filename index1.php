<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
</head>
<body>
    <h1>Cadastro de Usuário</h1>
    <form id="formCadastro" method="post">
        Nome: <input type="text" id="nome" name="nome" required><br>
        Email: <input type="email" id="email" name="email" required><br>
        Senha: <input type="password" id="senha" name="senha" required><br>
        <button type="submit">Cadastrar</button>
    </form>
    <br>
    <br>
    
    <h1>Login</h1>
    <form id="loginForm" action="login.php" method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit">Login</button>
    </form>

    <script>
        document.getElementById("formCadastro").onsubmit = function(event) {
            event.preventDefault();

            let nome = document.getElementById("nome").value;
            let email = document.getElementById("email").value;
            let senha = document.getElementById("senha").value;

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "salva_usuario.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                alert(xhr.responseText); 
            };
            xhr.send("nome=" + nome + "&email=" + email + "&senha=" + senha);
        }
    </script>
</body>
</html>
