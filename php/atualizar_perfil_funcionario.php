<?php
session_start();

// Verificar se o usuário está logado como funcionário
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'funcionario') {
    header("Location: html/login.html"); // Se não for funcionário, redireciona para o login
    exit();
}

// Conectar ao banco de dados
include 'conexao-banco.php';

// Pegar dados do funcionário logado
$id_funcionario = $_SESSION['id_usuario'];

// Pegar os dados do formulário
$email = mysqli_real_escape_string($conn, $_POST['email']);
$senha = mysqli_real_escape_string($conn, $_POST['senha']);
$confirmar_senha = mysqli_real_escape_string($conn, $_POST['confirmar_senha']);
$telefone = mysqli_real_escape_string($conn, $_POST['telefone']);
$rua = mysqli_real_escape_string($conn, $_POST['rua']);
$bairro = mysqli_real_escape_string($conn, $_POST['bairro']);
$cidade = mysqli_real_escape_string($conn, $_POST['cidade']);
$estado = mysqli_real_escape_string($conn, $_POST['estado']);

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

// Atualizar dados do funcionário
$query_update_funcionario = "UPDATE LOVETEC.Funcionario SET ";

$fields_to_update = [];

// Se houver alteração no email, inclui a atualização
if (!empty($email)) {
    $fields_to_update[] = "email = '$email'";
}

// Se houver uma nova senha, inclui a atualização da senha
if ($senha_final !== null) {
    $fields_to_update[] = "senha = '$senha_final'";
}

if (count($fields_to_update) > 0) {
    $query_update_funcionario .= implode(", ", $fields_to_update);
    $query_update_funcionario .= " WHERE id_funcionario = '$id_funcionario'";

    if (mysqli_query($conn, $query_update_funcionario)) {
        // Atualizar os dados do endereço
        $query_update_endereco = "UPDATE LOVETEC.Endereco SET rua = '$rua', bairro = '$bairro', cidade = '$cidade', estado = '$estado' WHERE id_endereco = (SELECT id_endereco FROM LOVETEC.Funcionario WHERE id_funcionario = '$id_funcionario')";
        mysqli_query($conn, $query_update_endereco);

        // Atualizar os dados do telefone
        $query_update_telefone = "UPDATE LOVETEC.Telefone SET numero_telefone = '$telefone' WHERE id_telefone = (SELECT id_telefone FROM LOVETEC.Funcionario WHERE id_funcionario = '$id_funcionario')";
        mysqli_query($conn, $query_update_telefone);

        echo "Perfil atualizado com sucesso!";
        header("Location: perfil_funcionario.php");
    } else {
        echo "Erro ao atualizar o perfil: " . mysqli_error($conn);
    }
} else {
    echo "Nenhuma alteração foi feita no perfil.";
}
?>
