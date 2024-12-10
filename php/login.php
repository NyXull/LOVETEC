<?php
// Inicia a sessão
session_start();

// Conectar ao banco de dados
include 'conexao-banco.php';

// Recebe os dados de login (exemplo de email e senha)
$email = $_POST['email'];
$senha = $_POST['senha'];

// Verificar login de cliente
$query_cliente = "SELECT id_cliente FROM LOVETEC.Cliente WHERE email = '$email' AND senha = '$senha'";
$result_cliente = mysqli_query($conn, $query_cliente);

if (mysqli_num_rows($result_cliente) > 0) {
    // Cliente encontrado, iniciar sessão
    $cliente = mysqli_fetch_assoc($result_cliente);
    $id_usuario = $cliente['id_cliente'];
    $_SESSION['tipo_usuario'] = 'cliente'; // Definir tipo de usuário como cliente
    $_SESSION['id_usuario'] = $id_usuario; // Definir ID do usuário na sessão

    // Inserir na tabela de sessões
    $query_sessao = "INSERT INTO LOVETEC.Sessao (id_usuario, tipo_usuario) 
                     VALUES ('$id_usuario', 'cliente')";
    mysqli_query($conn, $query_sessao);

    header("Location: ../index.php"); // Redireciona para a página inicial
    exit();
} else {
    // Verificar login de funcionário
    $query_funcionario = "SELECT id_funcionario FROM LOVETEC.Funcionario WHERE email = '$email' AND senha = '$senha'";
    $result_funcionario = mysqli_query($conn, $query_funcionario);

    if (mysqli_num_rows($result_funcionario) > 0) {
        // Funcionário encontrado, iniciar sessão
        $funcionario = mysqli_fetch_assoc($result_funcionario);
        $id_usuario = $funcionario['id_funcionario'];
        $_SESSION['tipo_usuario'] = 'funcionario'; // Definir tipo de usuário como funcionário
        $_SESSION['id_usuario'] = $id_usuario; // Definir ID do usuário na sessão

        // Inserir na tabela de sessões
        $query_sessao = "INSERT INTO LOVETEC.Sessao (id_usuario, tipo_usuario) 
                         VALUES ('$id_usuario', 'funcionario')";
        mysqli_query($conn, $query_sessao);

        header("Location: ../index.php"); // Redireciona para a página inicial
        exit();
    } else {
        echo "Login inválido";
    }
}
?>
