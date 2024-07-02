<?php
include 'db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se o campo "botao_clicado" está definido no formulário
    if (isset($_POST["botao_clicado"])) {
        // Obtém o ID do usuário da sessão
        $id_usuario = $_SESSION['id_usuario'];
                    
        // Consulta o banco de dados para obter o nome do usuário
        $stmt = $conn->prepare("SELECT nome FROM usuarios WHERE id_usuario = ?");
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $stmt->bind_result($nome_usuario);
        $stmt->fetch();
        $stmt->close(); // Fechar o statement após o uso
        // Obtém o valor do campo "botao_clicado"
        $botao_clicado = $_POST["botao_clicado"];

        // Exibe o formulário para fornecer o nome completo
        echo "<h2>ENTRAR NA FILA</h2>";
        echo "<div class='form-container'>";
        echo "<form action='/adicionar-fila' method='post'>";
        echo "<label for='nome_completo'>Confirma entrada na fila?</label><br>";
        echo "<input type='hidden' id='nome_completo' name='nome_completo' value='$nome_usuario'><br>";
        echo "<input type='hidden' name='botao_clicado' value='$botao_clicado'>";
        echo "<button type='submit'>Entrar na Fila</button>";
        echo "</form>";
        echo "</div>";
        echo "<div class='btn-voltar'><a href='/'><button>Voltar</button></a></div>";
    } else {
        echo "Erro: Botão não especificado.";
    }
}
?>

<style>
    h2 {
        font-family: 'Ubuntu', sans-serif;
        padding: 10px 20px;
    }

    .form-container {
        font-family: 'Ubuntu', sans-serif;
        display: flex;
        justify-content: center; 
        align-items: center; 
        height: 40vh;
    }

    form label {
        margin-bottom: 10px;
    }

    form input[type="hidden"] {
        display: none;
    }

    form button[type="submit"] {
        padding: 10px 20px;
        background-color: #6eaa5e;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
    }

    form button[type="submit"]:hover {
        background-color: #5e994e;
    }

    .btn-voltar {
        display: flex;
        justify-content: center; 
        align-items: center; 
        height: 40vh;   
    }

    a button {
        display: inline-block;
        margin: 10px;
        padding: 10px 20px;
        background-color: #6eaa5e; 
        color: #fff; 
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
    }
</style>
