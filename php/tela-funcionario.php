<?php
// Inicia a sessão
session_start();

// Obtém o token da sessão do cookie
$token = $_COOKIE['token_sessao'];  // Ou de session

// Verifica se o token é válido na tabela Sessao
$query = "SELECT * FROM LOVETEC.Sessao WHERE token_sessao = '$token' AND ativo = 1";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    // Sessão válida, recupera os dados do usuário
    $sessao = mysqli_fetch_assoc($result);
    $id_usuario = $sessao['id_usuario'];
    $tipo_usuario = $sessao['tipo_usuario'];

    // Recupera os dados do usuário com base no tipo
    if ($tipo_usuario == 'cliente') {
        $query_cliente = "SELECT * FROM LOVETEC.Cliente WHERE id_cliente = '$id_usuario'";
        $result_cliente = mysqli_query($conn, $query_cliente);
        $usuario = mysqli_fetch_assoc($result_cliente);
        // ... lógica para cliente
    } elseif ($tipo_usuario == 'funcionario') {
        $query_funcionario = "SELECT * FROM LOVETEC.Funcionario WHERE id_funcionario = '$id_usuario'";
        $result_funcionario = mysqli_query($conn, $query_funcionario);
        $usuario = mysqli_fetch_assoc($result_funcionario);
        // ... lógica para funcionário
    }
} else {
    // Sessão inválida ou expirada, redireciona para o login
    header("Location: login.php");
    exit();
}
?>
