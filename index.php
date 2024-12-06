<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>
    <link rel="stylesheet" href="css\index.css"> <!-- Arquivo CSS para estilos -->
</head>

<body>

    <h1>Clientes Cadastrados</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
            </tr>
        </thead>
        <tbody>
            <!-- Aqui os dados da tabela cliente serão inseridos pelo PHP -->
            <?php
            // Inclui o script PHP que buscará os dados no banco
            include 'teste.php';
            ?>
        </tbody>
    </table>

</body>

</html>