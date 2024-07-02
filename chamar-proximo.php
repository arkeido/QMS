<?php
session_start();
include 'db.php'; // Inclua a conexão com o banco de dados

$filas_disponiveis = array();
$sql = "SELECT nome FROM filas";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $filas_disponiveis[] = $row['nome'];
    }
} else {
    echo "Nenhuma fila encontrada.";
}

if (isset($_GET['fila'])) {
    $nome_fila = $_GET['fila'];

    // Obtém o id_fila correspondente ao nome da fila
    $stmt = $conn->prepare("SELECT id_fila FROM filas WHERE nome = ?");
    $stmt->bind_param("s", $nome_fila);
    $stmt->execute();
    $stmt->bind_result($id_fila);
    $stmt->fetch();
    $stmt->close(); // Fechar o statement após o uso

    if ($id_fila) {
        // Busca o próximo paciente na fila
        $stmt = $conn->prepare("SELECT id, nome_paciente FROM fila_pacientes WHERE id_fila = ? ORDER BY id ASC LIMIT 1");
        $stmt->bind_param("i", $id_fila);
        $stmt->execute();
        $stmt->bind_result($id, $nome_paciente);
        $stmt->fetch();

        // Armazenar os valores e fechar o statement antes de executar o próximo comando
        $paciente_id = $id;
        $paciente_nome = $nome_paciente;
        $stmt->close(); // Fechar o statement após o uso

        if ($paciente_nome) {
            echo "<div class='msg'><h2>Próximo da fila para '$nome_fila':</h2>";
            echo "<p>$paciente_nome</p></div>";

            // Remove o paciente da fila
            $stmt = $conn->prepare("DELETE FROM fila_pacientes WHERE id = ?");
            $stmt->bind_param("i", $paciente_id);
            $stmt->execute();
            $stmt->close(); // Fechar o statement após o uso
        } else {
            echo "<div class='msg'><h2>A fila para '$nome_fila' está vazia!</h2></div>";
        }
    } else {
        echo "<div class='msg'><h2>Erro: Fila não encontrada.</h2></div>";
    }

    echo '<div class="voltar"><a href="chamar-proximo.php" class="button">Voltar</a></div>';

} else {
    ?>
    <div class="navbar">
        <h2>ESCOLHA DE FILA</h2>
        <a class="button" href="logout.php">Logout</a>
    </div>
    <div class="div-form">
        <form class="form" action="chamar-proximo.php" method="get">
            <label for="fila">Selecione a fila:</label>
            <select name="fila" id="fila">
                <?php
                foreach ($filas_disponiveis as $fila) {
                    echo "<option value='$fila'>$fila</option>";
                }
                ?>
            </select>
            <button type="submit">Chamar Próximo da Fila</button>
        </form>
    </div>
    <?php
}
$conn->close();
?>

<style>
    body {
        background-color: #f8f9fa; 
        font-family: Ubuntu, sans-serif;
    }
    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
        background-color: #f8f9fa;
    }
    .div-form {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 80vh;
    }
    .form {
    width: 300px;
    padding: 20px;
    border: 1px solid #6eaa5e;
    border-radius: 5px;
    }
    .form label {
    display: block;
    margin-bottom: 10px;
    }
    .form select {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #6eaa5e;
        border-radius: 5px;
    }
    .form button {
        width: 100%;
        padding: 10px;
        background-color: #6eaa5e;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .form button:hover {
        background-color: #5e994e;
    } 

    .button {
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
    .voltar, .msg {
        display: flex;
        flex-direction: column;
        justify-content: center; 
        align-items: center;    
        height: 40vh; 
    }
</style>
