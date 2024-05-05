<?php
session_start();

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se o campo "nome_completo" e "botao_clicado" estão definidos no formulário
    if (isset($_POST["nome_completo"]) && isset($_POST["botao_clicado"])) {
        // Obtém o valor do campo "nome_completo" e "botao_clicado"
        $nome_completo = $_POST["nome_completo"];
        $botao_clicado = $_POST["botao_clicado"];

        // Adiciona o nome à "fila" correspondente ao botão clicado
        $_SESSION[$botao_clicado][] = $nome_completo;
        session_write_close();

        // Determina a posição do usuário na fila
        $posicao_na_fila = array_search($nome_completo, $_SESSION[$botao_clicado]) + 1;

        // Exibe uma mensagem de sucesso
        echo "<h1>Nome adicionado à fila com sucesso!</h1>";
        echo "<p>Nome: $nome_completo</p>";
        echo "<p>Posição na fila: $posicao_na_fila</p>";
        echo "<a href='/'>Voltar</a>";
    } else {
        echo "Erro: Campos não especificados.";
    }
}
?>
