<?php
session_start();

// Verificar se o usuário está logado como funcionário
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'funcionario') {
    header("Location: html/login.html"); // Se não for funcionário, redireciona para o login
    exit();
}

// Conectar ao banco de dados
include 'conexao-banco.php';

// Consultar reservas com status "Reservado"
$query_reservas = "SELECT r.id_reserva, v.modelo, v.placa, r.data_reserva, c.nome_cliente, r.status_reserva
                   FROM LOVETEC.Reserva r
                   JOIN LOVETEC.Veiculo v ON r.id_veiculo = v.id_veiculo
                   JOIN LOVETEC.Cliente c ON r.id_cliente = c.id_cliente
                   WHERE r.status_reserva = 'reservado'"; // Filtra reservas com status 'reservado'
$result_reservas = mysqli_query($conn, $query_reservas);

// Verificar se há uma ação de aceitar ou rejeitar reserva
if (isset($_GET['id_reserva'])) {
    $id_reserva = $_GET['id_reserva'];
    $status_reserva = $_GET['status_reserva']; // 'aprovado' ou 'rejeitado'

    if ($status_reserva === 'aprovado') {
        // Atualizar a reserva para "aprovada" e criar uma locação
        $query_update_reserva = "UPDATE LOVETEC.Reserva SET status_reserva = 'aprovado' WHERE id_reserva = '$id_reserva'";
        mysqli_query($conn, $query_update_reserva);

        // Obter os dados da reserva aprovada
        $query_reserva = "SELECT id_veiculo, id_cliente, data_reserva, valor_diaria FROM LOVETEC.Reserva WHERE id_reserva = '$id_reserva'";
        $result_reserva = mysqli_query($conn, $query_reserva);
        $reserva = mysqli_fetch_assoc($result_reserva);

        // Criar uma nova locação com os dados da reserva
        $query_insert_locacao = "INSERT INTO LOVETEC.Locacao (data_inicial, data_final, valor_diaria, valor_final, id_veiculo, id_cliente, status_locacao) 
                                 VALUES ('{$reserva['data_reserva']}', DATE_ADD('{$reserva['data_reserva']}', INTERVAL 1 DAY), '{$reserva['valor_diaria']}', '{$reserva['valor_diaria']}', '{$reserva['id_veiculo']}', '{$reserva['id_cliente']}', 'aprovado')";
        mysqli_query($conn, $query_insert_locacao);
        
        echo "Reserva aceita e transformada em locação!";
    } elseif ($status_reserva === 'rejeitado') {
        // Atualizar a reserva para "rejeitada"
        $query_update_reserva = "UPDATE LOVETEC.Reserva SET status_reserva = 'rejeitado' WHERE id_reserva = '$id_reserva'";
        mysqli_query($conn, $query_update_reserva);

        echo "Reserva rejeitada!";
    }

    // Redireciona para a página de gerenciamento após a ação
    header("Location: gerenciar_locacoes.php");
    exit();
}

// Consultar locações ativas com status 'aprovado'
$query_locacoes = "SELECT l.id_locacao, v.modelo, v.placa, l.data_inicial, l.data_final, l.valor_diaria, l.valor_final, c.nome_cliente, l.status_locacao
                   FROM LOVETEC.Locacao l
                   JOIN LOVETEC.Veiculo v ON l.id_veiculo = v.id_veiculo
                   JOIN LOVETEC.Cliente c ON l.id_cliente = c.id_cliente
                   WHERE l.status_locacao = 'aprovado'"; // Filtra locações com status 'aprovado'
$result_locacoes = mysqli_query($conn, $query_locacoes);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Locações e Reservas</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <h1>Gerenciar Locações e Reservas</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Início</a></li>
                <li><a href="perfil_funcionario.php">Meu Perfil</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Reservas "Reservadas"</h2>
        <?php
        if (mysqli_num_rows($result_reservas) > 0) {
            echo "<table><tr><th>Veículo</th><th>Placa</th><th>Data da Reserva</th><th>Cliente</th><th>Status</th><th>Ações</th></tr>";
            while ($reserva = mysqli_fetch_assoc($result_reservas)) {
                echo "<tr>
                        <td>{$reserva['modelo']}</td>
                        <td>{$reserva['placa']}</td>
                        <td>{$reserva['data_reserva']}</td>
                        <td>{$reserva['nome_cliente']}</td>
                        <td>{$reserva['status_reserva']}</td>
                        <td>
                            <a href='gerenciar_locacoes.php?id_reserva={$reserva['id_reserva']}&status_reserva=aprovado'>
                                <button>Aceitar</button>
                            </a>
                            <a href='gerenciar_locacoes.php?id_reserva={$reserva['id_reserva']}&status_reserva=rejeitado'>
                                <button>Rejeitar</button>
                            </a>
                        </td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Não há reservas 'Reservadas' no momento.</p>";
        }
        ?>

        <h2>Locações Ativas</h2>
        <?php
        if (mysqli_num_rows($result_locacoes) > 0) {
            echo "<table><tr><th>Veículo</th><th>Placa</th><th>Data Início</th><th>Data Fim</th><th>Valor Diário</th><th>Valor Final</th><th>Cliente</th><th>Status</th><th>Ações</th></tr>";
            while ($locacao = mysqli_fetch_assoc($result_locacoes)) {
                echo "<tr>
                        <td>{$locacao['modelo']}</td>
                        <td>{$locacao['placa']}</td>
                        <td>{$locacao['data_inicial']}</td>
                        <td>{$locacao['data_final']}</td>
                        <td>R$ " . number_format($locacao['valor_diaria'], 2, ',', '.') . "</td>
                        <td>R$ " . number_format($locacao['valor_final'], 2, ',', '.') . "</td>
                        <td>{$locacao['nome_cliente']}</td>
                        <td>{$locacao['status_locacao']}</td>
                        <td>
                            <a href='gerenciar_locacoes.php?id_locacao={$locacao['id_locacao']}&status_locacao=finalizada'>
                                <button>Finalizar Locação</button>
                            </a>
                        </td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Não há locações ativas no momento.</p>";
        }
        ?>
    </main>

    <footer>
        <p>&copy; 2024 LOVETEC. Todos os direitos reservados.</p>
    </footer>
</body>

</html>
