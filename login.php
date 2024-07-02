<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'db.php';

    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        die('Preencha ambos os campos.');
    }

    // Validar o usuário
    $stmt = $conn->prepare("SELECT id_usuario, senha, tipo_usuario FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $usuario = $result->fetch_assoc();

        if ($senha == $usuario['senha']) {
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];

            if ($usuario['tipo_usuario'] === 0) {
                header("Location: index.php"); // Redireciona para o index para pacientes
            } else {
                header("Location: chamar-proximo.php"); // Redireciona para o ADM UBS
            }
            exit();
        } else {
            echo 'Senha incorreta.';
        }
    } else {
        echo 'Usuário não encontrado.';
    }
}
?>

<div class="form-container">
    <form action="login.php" method="post">
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br>

        <button type="submit">Login</button>
    </form>
</div>
<div class="btn-voltar"><a href="index.php"><button>Voltar</button></a></div>

<style>
    .form-container {
        font-family: 'Ubuntu', sans-serif;
        display: flex;
        justify-content: center;
        align-items: center; 
        height: 80vh; 
    }

    form {
        width: 300px;
        padding: 20px;
        border: 1px solid #6eaa5e; 
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
    }

    form label {
        margin-bottom: 5px; 
    }

    form input[type="email"],
    form input[type="password"] {
        width: 250px; 
        padding: 10px;
        margin-bottom: 15px; 
        border: 1px solid #6eaa5e; 
        border-radius: 5px;
    }

    form button[type="submit"] {
        padding: 10px 20px;
        background-color: #6eaa5e;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    form button[type="submit"]:hover {
        background-color: #5e994e;
    }

    .btn-voltar {
        display: flex;
        justify-content: center; 
        align-items: center;    
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