<?php
session_start();

// Define um vetor com os nomes das filas disponíveis
$filas_disponiveis = array("Vacina", "Consulta", "Exame"); // Adicionar ou remover conforme necessário

// Verifica se o parâmetro 'fila' está presente na URL
if (isset($_GET['fila'])) {
    // Obtém o nome da fila a partir do parâmetro 'fila'
    $nome_fila = $_GET['fila'];

    // Verifica se o vetor da fila está definido na sessão
    if (isset($_SESSION[$nome_fila])) {
        // Verifica se há itens na fila
        if (!empty($_SESSION[$nome_fila])) {
            // Exibe o próximo da fila
            echo "<h1>Próximo da fila $nome_fila:</h1>";
            echo "<p>{$_SESSION[$nome_fila][0]}</p>";
            
            // Remove a posição atual a fila
            array_shift($_SESSION[$nome_fila]);
        } else {
            echo "<h1>A fila $nome_fila está vazia!</h1>";
        }
        
        // Exibe o botão "Voltar"
        echo "<a href='/'>Voltar</a>";
    } else {
        echo "<h1>A fila $nome_fila não está definida na sessão!</h1>";
    }
} else {
    // Caso o parâmetro 'fila' não seja especificado na URL, exibir um formulário para escolher a fila
    ?>
    <h1>Escolha a Fila</h1>
    <form action="chamar-proximo.php" method="get">
        <label for="fila">Selecione a fila:</label>
        <select name="fila" id="fila">
            <?php
            // Itera sobre o vetor de filas disponíveis e cria uma opção para cada fila
            foreach ($filas_disponiveis as $fila) {
                echo "<option value='$fila'>$fila</option>";
            }
            ?>
        </select>
        <button type="submit">Chamar Próximo da Fila</button>
    </form>
    <?php
}
?>
