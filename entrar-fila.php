<?php
// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se o campo "botao_clicado" está definido no formulário
    if (isset($_POST["botao_clicado"])) {
        // Obtém o valor do campo "botao_clicado"
        $botao_clicado = $_POST["botao_clicado"];

        // Exibe o formulário para fornecer o nome completo
        echo "<h1>Entrar na Fila</h1>";
        echo "<form action='/adicionar-fila' method='post'>";
        echo "<label for='nome_completo'>Nome Completo:</label><br>";
        echo "<input type='text' id='nome_completo' name='nome_completo'><br>";
        echo "<input type='hidden' name='botao_clicado' value='$botao_clicado'>";
        echo "<button type='submit'>Entrar na Fila</button>";
        echo "</form>";
    } else {
        echo "Erro: Botão não especificado.";
    }
}
?>
