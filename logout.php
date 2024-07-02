<?php
session_start();

// Destruir todas as variáveis de sessão
$_SESSION = array();

// Se desejar, também pode destruir a sessão completamente
// Isso apagará a sessão, e não apenas os dados da sessão
// Se você quiser apenas limpar os dados da sessão, remova esta linha
session_destroy();

// Redirecionar de volta para a página de login ou qualquer outra página desejada
header("Location: index.php");
exit();
?>
