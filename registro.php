<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'db.php';

    // Extrair informações do POST
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $is_funcionario = isset($_POST['is_funcionario']) ? 1 : 0;
    $numero_identificacao = $_POST['numero_identificacao'] ?? '';

    // Validações básicas
    if (empty($nome) || empty($email) || empty($senha) || ($is_funcionario && empty($numero_identificacao))) {
        die('Preencha todos os campos obrigatórios.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Email inválido.');
    }

    if (strlen($senha) < 6) {
        die('A senha deve ter pelo menos 6 caracteres.');
    }

    if (!is_numeric($numero_identificacao) && $is_funcionario) {
        die('Número de identificação deve ser numérico.');
    }

    if ($is_funcionario) {
        // Verificar se o número de identificação é válido
        $stmt = $conn->prepare("SELECT id FROM identificacao_adm WHERE id = ?");
        $stmt->bind_param("i", $numero_identificacao);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            die('Número de identificação não encontrado.');
        }
        $tipo_usuario = $numero_identificacao;
    } else {
        $tipo_usuario = 0;
    }

    // Inserir usuário no banco
    $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, tipo_usuario) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $nome, $email, $senha, $tipo_usuario);
    $stmt->execute();

    if ($conn->affected_rows > 0) {
        header("Location: login.php");
        exit();
    } else {
        echo "Erro ao registrar usuário.";
    }
}
?>

<div class="form-container">
    <form action="registro.php" method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br>

        <label><input type="checkbox" id="is_funcionario" name="is_funcionario"> É funcionário?</label><br>

        <label for="numero_identificacao" id="label_numero_identificacao" class="hidden">Número Identificação:</label>
        <input type="text" id="numero_identificacao" name="numero_identificacao" class="hidden"><br>

        <button type="submit">Registrar</button>
    </form>
</div>
<div class="btn-voltar"><a href="index.php"><button>Voltar</button></a></div>

<script>
    function toggleIdentificationField() {
        var isChecked = document.getElementById('is_funcionario').checked;
        var numeroIdentificacao = document.getElementById('numero_identificacao');
        var labelNumeroIdentificacao = document.getElementById('label_numero_identificacao');
        if (isChecked) {
            numeroIdentificacao.style.display = 'block';
            labelNumeroIdentificacao.style.display = 'block';
        } else {
            numeroIdentificacao.style.display = 'none';
            labelNumeroIdentificacao.style.display = 'none';
        }
    }

    // Ativa a função no carregamento da página
    window.onload = function() {
        toggleIdentificationField();
        document.getElementById('is_funcionario').onchange = toggleIdentificationField;
    };
</script>

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
        display: block;
        margin-bottom: 10px;
    }

    form input[type="text"],
    form input[type="email"],
    form input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #6eaa5e; 
        border-radius: 5px;
        box-sizing: border-box;
    }

    form button {
        width: 100%;
        padding: 10px;
        margin-bottom: 5px;
        background-color: #6eaa5e;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    form button:hover {
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
