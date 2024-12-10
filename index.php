<?php
session_start();

// Conectar ao banco de dados
include 'php/conexao-banco.php';

// Consultar veículos disponíveis
$query_veiculos = "SELECT id_veiculo, modelo, placa, valor_diaria, cor, ano_fabricacao FROM LOVETEC.Veiculo";
$result_veiculos = mysqli_query($conn, $query_veiculos);

// Verificar se o usuário está logado
$tipo_usuario = isset($_SESSION['tipo_usuario']) ? $_SESSION['tipo_usuario'] : null;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOVETEC - Página Inicial</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Bem-vindo à LOVETEC</h1>
        <nav>
            <ul>
                <li><a href="index.php">Início</a></li>
                <?php if (!$tipo_usuario): ?>
                    <!-- Se o usuário não estiver logado, exibe os links para login e cadastro -->
                    <li><a href="html/login.html">Login</a></li>
                    <li><a href="html/cadastro_cliente.html">Cadastrar</a></li>
                <?php else: ?>
                    <!-- Se o usuário estiver logado, exibe o link para o perfil e logout -->
                    <li><a href="php\perfil_funcionario.php">Perfil</a></li>
                    <li><a href="php\logout.php">Sair</a></li>
                    <?php if ($tipo_usuario == 'funcionario'): ?>
                        <!-- Se for funcionário, exibe a área do funcionário -->
                        <li><a href="php\gerenciar_locacoes.php">Área do Funcionário</a></li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Veículos Disponíveis</h2>
        <table>
            <tr>
                <th>Modelo</th>
                <th>Placa</th>
                <th>Valor Diária</th>
                <th>Cor</th>
                <th>Ano</th>
                <?php if ($tipo_usuario == 'cliente'): ?>
                    <!-- Exibe a coluna de Ação apenas para clientes -->
                    <th>Ação</th>
                <?php endif; ?>
            </tr>
            <?php while ($veiculo = mysqli_fetch_assoc($result_veiculos)): ?>
                <tr>
                    <td><?php echo $veiculo['modelo']; ?></td>
                    <td><?php echo $veiculo['placa']; ?></td>
                    <td><?php echo "R$ " . number_format($veiculo['valor_diaria'], 2, ',', '.'); ?></td>
                    <td><?php echo $veiculo['cor']; ?></td>
                    <td><?php echo $veiculo['ano_fabricacao']; ?></td>
                    <?php if ($tipo_usuario == 'cliente'): ?>
                        <!-- Para clientes logados, exibe o link para reservar -->
                        <td><a href="php\reservar_veiculo.php?id_veiculo=<?php echo $veiculo['id_veiculo']; ?>">Reservar</a></td>
                    <?php elseif (!$tipo_usuario): ?>
                        <!-- Para usuários não logados, exibe o link para login -->
                        <td><a href="html/login.html">Login para Reservar</a></td>
                    <?php endif; ?>
                </tr>
            <?php endwhile; ?>
        </table>

        <!-- Se for cliente, pode reservar, se não, verá a opção de login -->
        <?php if ($tipo_usuario == 'cliente'): ?>
            <h2>Meus Aluguéis</h2>
            <!-- Aqui você pode mostrar uma lista de alugueis do cliente -->
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2024 LOVETEC. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
