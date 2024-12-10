<?php
session_start();

// Verificar se o usuário está logado como cliente
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'cliente') {
    header("Location: html\login.html"); // Se não for cliente, redireciona para o login
    exit();
}

// Conectar ao banco de dados
include 'conexao-banco.php';

// Pegar dados do cliente logado
$id_cliente = $_SESSION['id_usuario'];

// Pegar os dados do formulário
$email = mysqli_real_escape_string($conn, $_POST['email']);
$senha = mysqli_real_escape_string($conn, $_POST['senha']);
$confirmar_senha = mysqli_real_escape_string($conn, $_POST['confirmar_senha']);

// Validar a senha, se fornecida
if (!empty($senha)) {
    if ($senha !== $confirmar_senha) {
        echo "As senhas não coincidem.";
        exit();
    }
    // Não utilizar password_hash() - Armazenar a senha diretamente
    $senha_final = $senha; 
} else {
    $senha_final = null; // Não alterar a senha se não fornecida
}

// Atualizar dados
$query_update = "UPDATE LOVETEC.Cliente SET email = '$email'";

if ($senha_final !== null) {
    $query_update .= ", senha = '$senha_final'"; // Atualizar senha se fornecida
}

$query_update .= " WHERE id_cliente = '$id_cliente'";

if (mysqli_query($conn, $query_update)) {
    echo "Perfil atualizado com sucesso!";
    header("Location: perfil_cliente.php");
} else {
    echo "Erro ao atualizar o perfil: " . mysqli_error($conn);
}
?>
