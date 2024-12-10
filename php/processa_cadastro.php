<?php
// Conectar ao banco de dados
include 'conexao-banco.php';

// Receber dados do formulário
$nome_cliente = $_POST['nome_cliente'];
$data_nasc = $_POST['data_nasc'];
$num_cnh = $_POST['num_cnh'];
$email = $_POST['email'];
$senha = $_POST['senha']; // Sem criptografia, conforme solicitado

// Dados do endereço
$rua = $_POST['rua'];
$bairro = $_POST['bairro'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$cep = $_POST['cep'];
$id_tipo_endereco = $_POST['tipo_endereco'];

// Dados do telefone
$numero_telefone = $_POST['numero_telefone'];
$id_tipo_telefone = $_POST['tipo_telefone'];

// Inserir dados na tabela Endereço
$query_endereco = "INSERT INTO LOVETEC.Endereco (rua, bairro, cidade, estado, cep, id_tipo_endereco) 
                   VALUES ('$rua', '$bairro', '$cidade', '$estado', '$cep', $id_tipo_endereco)";
mysqli_query($conn, $query_endereco);
$id_endereco = mysqli_insert_id($conn); // Pega o ID do endereço inserido

// Inserir dados na tabela Telefone
$query_telefone = "INSERT INTO LOVETEC.Telefone (numero_telefone, id_tipo_telefone) 
                   VALUES ('$numero_telefone', $id_tipo_telefone)";
mysqli_query($conn, $query_telefone);
$id_telefone = mysqli_insert_id($conn); // Pega o ID do telefone inserido

// Inserir os dados na tabela Cliente
$query_cliente = "INSERT INTO LOVETEC.Cliente (nome_cliente, data_nasc, num_cnh, email, senha, id_endereco, id_telefone) 
                  VALUES ('$nome_cliente', '$data_nasc', '$num_cnh', '$email', '$senha', $id_endereco, $id_telefone)";
if (mysqli_query($conn, $query_cliente)) {
    echo "Cadastro realizado com sucesso!";
    header("Location: ..\html\login.html"); // Redireciona para a página de login
    exit();
} else {
    echo "Erro ao cadastrar cliente: " . mysqli_error($conn);
}
?>
