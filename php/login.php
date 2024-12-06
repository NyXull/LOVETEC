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
    $tipo_usuario = 'cliente'; // Identifica que é um cliente

    // Inserir na tabela de sessões
    $query_sessao = "INSERT INTO LOVETEC.Sessao (id_usuario, tipo_usuario) 
                     VALUES ('$id_usuario', '$tipo_usuario')";
    mysqli_query($conn, $query_sessao);

    header("Location: ../index.php"); // Redireciona para a página do cliente
    exit();
} else {
    // Verificar login de funcionário
    $query_funcionario = "SELECT id_funcionario FROM LOVETEC.Funcionario WHERE email = '$email' AND senha = '$senha'";
    $result_funcionario = mysqli_query($conn, $query_funcionario);

    if (mysqli_num_rows($result_funcionario) > 0) {
        // Funcionário encontrado, iniciar sessão
        $funcionario = mysqli_fetch_assoc($result_funcionario);
        $id_usuario = $funcionario['id_funcionario'];
        $tipo_usuario = 'funcionario'; // Identifica que é um funcionário

       
        // Inserir na tabela de sessões
        $query_sessao = "INSERT INTO LOVETEC.Sessao (id_usuario, tipo_usuario) 
                         VALUES ('$id_usuario', '$tipo_usuario')";
        mysqli_query($conn, $query_sessao);

        header("Location: ../index.php"); // Redireciona para a página do funcionário
        exit();
    } else {
        echo "Login inválido";
    }
}
?>