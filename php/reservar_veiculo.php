<?php
session_start();

// Verificar se o usuário está logado como cliente
if ($_SESSION['tipo_usuario'] != 'cliente') {
    header("Location: index.php");
    exit();
}

// Conectar ao banco de dados
include 'conexao-banco.php';

// Receber o ID do veículo a ser reservado
$id_veiculo = isset($_GET['id_veiculo']) ? $_GET['id_veiculo'] : null;

if ($id_veiculo) {
    // Consultar informações do veículo
    $query_veiculo = "SELECT id_veiculo, modelo, placa, valor_diaria, cor, ano_fabricacao FROM LOVETEC.Veiculo WHERE id_veiculo = '$id_veiculo'";
    $result_veiculo = mysqli_query($conn, $query_veiculo);

    if (mysqli_num_rows($result_veiculo) > 0) {
        $veiculo = mysqli_fetch_assoc($result_veiculo);
    } else {
        echo "Veículo não encontrado.";
        exit();
    }
} else {
    echo "ID do veículo não especificado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva de Veículo</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Reserva de Veículo</h1>
    </header>

    <main>
        <h2>Detalhes do Veículo</h2>
        <p><strong>Modelo:</strong> <?php echo $veiculo['modelo']; ?></p>
        <p><strong>Placa:</strong> <?php echo $veiculo['placa']; ?></p>
        <p><strong>Cor:</strong> <?php echo $veiculo['cor']; ?></p>
        <p><strong>Ano:</strong> <?php echo $veiculo['ano_fabricacao']; ?></p>
        <p><strong>Valor Diária:</strong> R$ <?php echo number_format($veiculo['valor_diaria'], 2, ',', '.'); ?></p>

        <h3>Realizar Reserva</h3>
        <form action="processa_reserva.php" method="POST">
            <input type="hidden" name="id_veiculo" value="<?php echo $veiculo['id_veiculo']; ?>">
            <label for="data_reserva">Data da Reserva:</label>
            <input type="date" id="data_reserva" name="data_reserva" required>
            <br><br>
            <button type="submit">Reservar</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 LOVETEC. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
