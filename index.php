<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Fila</title>
    <style>
        .container {
            text-align: center;
            margin-top: 50px; /* Ajuste a margem conforme necessário */
        }
        .button {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            background-color: #007bff; /* Cor de fundo dos botões */
            color: #fff; /* Cor do texto dos botões */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gerenciamento de Fila</h1>
        <!-- Acessa página que chama o próximo da fila -->
        <a class="button" href="chamar-proximo.php">Chamar Próximo da Fila</a>
        <?php
        // Obtém a URL da solicitação
        $url = isset($_GET['url']) ? $_GET['url'] : '';

        // Roteamento com base na URL
        switch ($url) {
            case 'entrar-fila':
                ob_clean();
                include 'entrar-fila.php';
                exit();
            case 'adicionar-fila':
                ob_clean();
                include 'adicionar-fila.php';
                exit();
            default:
                // Página padrão ou tratamento de erro 404
                break;
        }

        // Vetor com o conteúdo de cada botão
        $conteudo_botao = array("Vacina", "Consulta", "Exame");
        
        // Gerar botões com conteúdo do vetor
        for ($i = 0; $i < count($conteudo_botao); $i++) {
            // Redireciona para a URL /entrar-fila
            echo "<form action='/entrar-fila' method='post'>";
            echo "<input type='hidden' name='botao_clicado' value='$conteudo_botao[$i]'>";
            echo "<button class='button' type='submit'>$conteudo_botao[$i]</button>";
            echo "</form>";
        }
        ?>
    </div>
</body>
</html>
