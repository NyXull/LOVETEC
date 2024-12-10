<?php
session_start();

// Verificar se o usuário está logado
if (isset($_SESSION['id_usuario']) && isset($_SESSION['tipo_usuario'])) {
    // Conectar ao banco de dados
    include 'conexao-banco.php';

    // Remover a sessão da tabela Sessao
    $id_usuario = $_SESSION['id_usuario'];
    $tipo_usuario = $_SESSION['tipo_usuario'];

    // Remover a sessão correspondente na tabela de Sessões
    $query_sessao = "DELETE FROM LOVETEC.Sessao WHERE id_usuario = '$id_usuario' AND tipo_usuario = '$tipo_usuario'";
    mysqli_query($conn, $query_sessao);

    // Destruir a sessão
    session_unset();  // Remove todas as variáveis da sessão
    session_destroy(); // Destroi a sessão completamente
}

// Redireciona para a página inicial ou de login
header("Location: ../index.php"); 
exit();
?>
