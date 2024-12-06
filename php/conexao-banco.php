<?php
// Defina as variáveis de conexão
$host = 'localhost'; // Host do banco de dados
$banco = 'lovetec'; // Nome do banco de dados
$usuario = 'root'; // Nome de usuário do banco de dados
$senha = ''; // Senha do banco de dados

// Cria a conexão com mysqli
$conn = new mysqli($host, $usuario, $senha, $banco);

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>