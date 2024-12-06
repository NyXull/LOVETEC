<?php
// Inclui o arquivo de conexão
include 'conexao-banco.php';

// // Verifique se a variável $pdo foi definida, ou seja, se a conexão foi bem-sucedida
// if (isset($pdo)) {
//     echo "A conexão com o banco de dados foi estabelecida com sucesso!";
// } else {
//     echo "A conexão falhou.";
// }
// 

// Consulta para selecionar todos os clientes
$stmt = $pdo->query("SELECT * FROM cliente");

// Exibe os dados de cada cliente em uma linha da tabela HTML
while ($cliente = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($cliente['id']) . "</td>";
    echo "<td>" . htmlspecialchars($cliente['nome_cliente']) . "</td>";
    echo "<td>" . htmlspecialchars($cliente['data_nasc']) . "</td>";
    echo "<td>" . htmlspecialchars($cliente['num_cnh']) . "</td>";
    echo "<td>" . htmlspecialchars($cliente['id_locacao']) . "</td>";
    echo "<td>" . htmlspecialchars($cliente['id_veiculo']) . "</td>";
    echo "<td>" . htmlspecialchars($cliente['id_endereco']) . "</td>";
    echo "<td>" . htmlspecialchars($cliente['id_telefone']) . "</td>";
    echo "</tr>";
}

?>