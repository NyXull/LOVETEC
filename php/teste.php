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
$stmt = $pdo->query("SELECT nome_cliente, data_nasc, num_cnh, rua, numero_telefone
FROM cliente
INNER JOIN telefone ON (cliente.id_telefone = telefone.id_telefone)
INNER JOIN endereco ON (cliente.id_endereco = endereco.id_endereco);");

// Exibe os dados de cada cliente em uma linha da tabela HTML
while ($cliente = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($cliente['nome_cliente']) . "<br> </td>";
    echo "<td>" . htmlspecialchars($cliente['data_nasc']) . "<br> </td>";
    echo "<td>" . htmlspecialchars($cliente['num_cnh']) . "<br> </td>";
    echo "<td>" . htmlspecialchars($cliente['rua']) . "<br> </td>";
    echo "<td>" . htmlspecialchars($cliente['numero_telefone']) . "<br> </td>";
    echo "</tr>";
}

?>