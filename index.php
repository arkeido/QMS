<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Fila</title>
    <style>
        body {
            background-color: #f8f9fa; 
            font-family: Ubuntu, sans-serif;
        }
        .hidden {
            display: none;
        }
        .container {
            text-align: center;
            margin-top: 50px; 
            display: flex;
            align-items: center;
            justify-content: space-evenly;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #f8f9fa;
        }
        .button {
            font-size: 16px;
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
        .btn-index {
            display: flex;
            justify-content: center; 
            align-items: center;    
            height: 25vh; 
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>GERENCIAMENTO DE FILA</h2>
        <?php
        session_start();

        if (isset($_SESSION['id_usuario'])) {
            // Se estiver logado, mostra o botão de logout
            echo '<a class="button" href="logout.php">Logout</a>';
        }
        ?>
    </div>
    <div class="container">
        <?php
        include 'db.php';

        $url = isset($_GET['url']) ? $_GET['url'] : '';

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
                break;
        }

        if (!isset($_SESSION['id_usuario'])) {
            // Se não estiver logado, mostra as opções de login e registro
            echo '<div class="btn-index"><a class="button" href="login.php">Login</a>';
            echo '<a class="button" href="registro.php">Registro</a></div>';
        } else {
            // Usuário logado
            $tipo_usuario = $_SESSION['tipo_usuario'];

            // Checa o tipo de usuário para definir a área
            if ($tipo_usuario == 0) {
                // Área Paciente
                $sql = "SELECT nome FROM filas";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $nome_fila = $row['nome'];
                        echo "<form action='/entrar-fila.php' method='post'>";
                        echo "<input type='hidden' name='botao_clicado' value='$nome_fila'>";
                        echo "<button class='button' type='submit'>$nome_fila</button>";
                        echo "</form>";
                    }
                } else {
                    echo "Nenhuma fila encontrada.";
                }

                $conn->close();
            } else {
                // Área Admin
                echo '<a class="button" href="chamar-proximo.php">Área Admin</a>';
            }
        }            
        ?>
    </div>
</body>
</html>
