<?php
// Defina as variáveis de conexão
$host = 'localhost'; // Host do banco de dados
$dbname = 'lovetec'; // Nome do banco de dados
$username = 'root'; // Nome de usuário do banco de dados
$password = ''; // Senha do banco de dados

// Tente criar a conexão com o banco de dados
try {
    // Cria a conexão com PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Defina o modo de erro do PDO para exceções
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Caso a conexão seja bem-sucedida, exibe uma mensagem
    // echo "Conexão bem-sucedida ao banco de dados!";
} catch (PDOException $e) {
    // Se ocorrer um erro, exibe a mensagem de erro
    // echo "Erro de conexão: " . $e->getMessage();
}

?>