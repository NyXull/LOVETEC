<?php
session_start();

// Verificar se o usuário está logado como cliente
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'cliente') {
    header("Location: html\login.html"); // Se não for cliente, redireciona para o login
    exit();
}

// Conectar ao banco de dados
include 'conexao-banco.php';

// Pegar dados do cliente logado
$id_cliente = $_SESSION['id_usuario'];
$query_cliente = "SELECT nome_cliente, email, data_nasc, num_cnh FROM LOVETEC.Cliente WHERE id_cliente = '$id_cliente'";
$result_cliente = mysqli_query($conn, $query_cliente);
$cliente = mysqli_fetch_assoc($result_cliente);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Cliente</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <h1>Perfil do Cliente</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Início</a></li>
                <li><a href="perfil_cliente.php">Meu Perfil</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Dados Pessoais</h2>
        <?php
        // Exibir mensagem de sucesso ou erro
        if (isset($_GET['msg'])) {
            echo "<p>{$_GET['msg']}</p>";
        }
        ?>
        <form action="atualizar_perfil.php" method="post">
            <label for="nome_cliente">Nome:</label>
            <input type="text" id="nome_cliente" name="nome_cliente" value="<?php echo $cliente['nome_cliente']; ?>"
                readonly><br><br>

            <label for="data_nasc">Data de Nascimento:</label>
            <input type="date" id="data_nasc" name="data_nasc" value="<?php echo $cliente['data_nasc']; ?>"
                readonly><br><br>

            <label for="num_cnh">Número da CNH:</label>
            <input type="text" id="num_cnh" name="num_cnh" value="<?php echo $cliente['num_cnh']; ?>" readonly><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $cliente['email']; ?>" required><br><br>

            <label for="senha">Nova Senha:</label>
            <input type="password" id="senha" name="senha" placeholder="Digite a nova senha"><br><br>

            <label for="confirmar_senha">Confirmar Nova Senha:</label>
            <input type="password" id="confirmar_senha" name="confirmar_senha"
                placeholder="Confirme a nova senha"><br><br>

            <button type="submit">Atualizar Perfil</button>
        </form>

        <h2>Meus Aluguéis</h2>
        <?php
        // Consultar alugueis ativos do cliente
        $query_alugueis = "SELECT v.modelo, v.placa, l.data_inicial, l.data_final, l.valor_diaria
                   FROM LOVETEC.Locacao l
                   JOIN LOVETEC.Veiculo v ON l.id_veiculo = v.id_veiculo
                   WHERE l.id_cliente = '$id_cliente' AND l.data_final >= CURDATE()";
        // Locação ativa
        $result_alugueis = mysqli_query($conn, $query_alugueis);

        if (mysqli_num_rows($result_alugueis) > 0) {
            echo "<table><tr><th>Veículo</th><th>Placa</th><th>Data Início</th><th>Data Fim</th><th>Valor Diária</th></tr>";
            while ($aluguel = mysqli_fetch_assoc($result_alugueis)) {
                echo "<tr>
                        <td>{$aluguel['modelo']}</td>
                        <td>{$aluguel['placa']}</td>
                        <td>{$aluguel['data_inicial']}</td>
                        <td>{$aluguel['data_final']}</td>
                        <td>R$ " . number_format($aluguel['valor_diaria'], 2, ',', '.') . "</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Você não tem alugueis ativos no momento.</p>";
        }
        ?>

        <h2>Minhas Reservas</h2>
        <?php
        // Consultar reservas do cliente
        // Aqui você pode ajustar a consulta para pegar todas as reservas ou apenas as ativas
        $query_reservas = "SELECT r.id_reserva, v.modelo, v.placa, r.data_reserva, r.status_reserva
                           FROM LOVETEC.Reserva r
                           JOIN LOVETEC.Veiculo v ON r.id_veiculo = v.id_veiculo
                           WHERE r.id_cliente = '$id_cliente'";
        $result_reservas = mysqli_query($conn, $query_reservas);

        if (mysqli_num_rows($result_reservas) > 0) {
            echo "<table><tr><th>Veículo</th><th>Placa</th><th>Data da Reserva</th><th>Status</th><th>Ação</th></tr>";
            while ($reserva = mysqli_fetch_assoc($result_reservas)) {
                echo "<tr>
                        <td>{$reserva['modelo']}</td>
                        <td>{$reserva['placa']}</td>
                        <td>{$reserva['data_reserva']}</td>
                        <td>{$reserva['status_reserva']}</td>
                        <td>
                            <a href='cancelar_reserva.php?id_reserva={$reserva['id_reserva']}'>
                                <button>Cancelar Reserva</button>
                            </a>
                        </td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Você não tem reservas realizadas.</p>";
        }
        ?>
    </main>

    <footer>
        <p>&copy; 2024 LOVETEC. Todos os direitos reservados.</p>
    </footer>
</body>

</html>