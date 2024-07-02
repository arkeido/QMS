<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'db.php'; // Inclua a conexão com o banco de dados

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se o campo "nome_completo" e "botao_clicado" estão definidos no formulário
    if (isset($_POST["nome_completo"]) && isset($_POST["botao_clicado"])) {
        // Obtém o valor do campo "nome_completo" e "botao_clicado"
        $nome_completo = $_POST["nome_completo"];
        $botao_clicado = $_POST["botao_clicado"];

        // Obtém o id_fila correspondente ao nome da fila
        $stmt = $conn->prepare("SELECT id_fila FROM filas WHERE nome = ?");
        $stmt->bind_param("s", $botao_clicado);
        $stmt->execute();
        $stmt->bind_result($id_fila);
        $stmt->fetch();
        $stmt->close(); // Fechar o statement após o uso

        if ($id_fila) {
            // Adiciona o nome à tabela "fila_pacientes"
            $stmt = $conn->prepare("INSERT INTO fila_pacientes (id_fila, nome_paciente) VALUES (?, ?)");
            $stmt->bind_param("is", $id_fila, $nome_completo);
            $stmt->execute();
            $stmt->close(); // Fechar o statement após o uso

            // Determina a posição do usuário na fila contando o número de pacientes na fila
            $stmt = $conn->prepare("SELECT COUNT(*) AS posicao FROM fila_pacientes WHERE id_fila = ?");
            $stmt->bind_param("i", $id_fila);
            $stmt->execute();
            $stmt->bind_result($posicao_na_fila);
            $stmt->fetch();
            $stmt->close(); // Fechar o statement após o uso

            // Exibe uma mensagem de sucesso
            echo "<h2>Nome adicionado à fila com sucesso!</h2>";
            echo "<div class='container'>";
            echo "<p>Nome: $nome_completo</p>";
            echo "<p>Posição na fila: $posicao_na_fila</p>";
            echo "<a href='/'><button>Voltar</button></a>";
            echo "</div>";
        } else {
            echo "Erro: Fila não encontrada.";
        }
    } else {
        echo "Erro: Campos não especificados.";
    }
}
$conn->close();
?>

<style>
    h2 {
        font-family: Ubuntu, sans-serif;
    }

    .container {
        font-family: Ubuntu, sans-serif;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 80vh;
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
