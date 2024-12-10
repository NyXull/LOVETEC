<?php
session_start();

// Verificar se o usuário está logado como funcionário
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'funcionario') {
    header("Location: html/login.html"); // Se não for funcionário, redireciona para o login
    exit();
}

// Conectar ao banco de dados
include 'conexao-banco.php';

// Pegar dados do funcionário logado
$id_funcionario = $_SESSION['id_usuario'];
$query_funcionario = "SELECT f.nome_funcionario, f.email, f.senha, e.rua, e.bairro, e.cidade, e.estado, t.numero_telefone 
                       FROM LOVETEC.Funcionario f
                       JOIN LOVETEC.Endereco e ON f.id_endereco = e.id_endereco
                       JOIN LOVETEC.Telefone t ON f.id_telefone = t.id_telefone
                       WHERE f.id_funcionario = '$id_funcionario'";
$result_funcionario = mysqli_query($conn, $query_funcionario);
$funcionario = mysqli_fetch_assoc($result_funcionario);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Funcionário</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <h1>Perfil do Funcionário</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Início</a></li>
                <li><a href="perfil_funcionario.php">Meu Perfil</a></li>
                <li><a href="gerenciar_locacoes.php">Área do Funcionário</a></li>   
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
        <form action="atualizar_perfil_funcionario.php" method="post">
            <label for="nome_funcionario">Nome:</label>
            <input type="text" id="nome_funcionario" name="nome_funcionario"
                value="<?php echo $funcionario['nome_funcionario']; ?>" readonly><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $funcionario['email']; ?>" readonly><br><br>

            <label for="senha">Nova Senha:</label>
            <input type="password" id="senha" name="senha" placeholder="Digite a nova senha"><br><br>

            <label for="confirmar_senha">Confirmar Nova Senha:</label>
            <input type="password" id="confirmar_senha" name="confirmar_senha"
                placeholder="Confirme a nova senha"><br><br>

            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone" value="<?php echo $funcionario['numero_telefone']; ?>"
                required><br><br>

            <h3>Endereço:</h3>
            <label for="rua">Rua:</label>
            <input type="text" id="rua" name="rua" value="<?php echo $funcionario['rua']; ?>" required><br><br>

            <label for="bairro">Bairro:</label>
            <input type="text" id="bairro" name="bairro" value="<?php echo $funcionario['bairro']; ?>" required><br><br>

            <label for="cidade">Cidade:</label>
            <input type="text" id="cidade" name="cidade" value="<?php echo $funcionario['cidade']; ?>" required><br><br>

            <label for="estado">Estado (UF):</label><br>
            <select id="estado" name="estado" required>
                <option value="" disabled selected>Selecione o Estado</option>
                <option value="AC" <?php if ($funcionario['estado'] == 'AC')
                    echo 'selected'; ?>>Acre</option>
                <option value="AL" <?php if ($funcionario['estado'] == 'AL')
                    echo 'selected'; ?>>Alagoas</option>
                <option value="AP" <?php if ($funcionario['estado'] == 'AP')
                    echo 'selected'; ?>>Amapá</option>
                <option value="AM" <?php if ($funcionario['estado'] == 'AM')
                    echo 'selected'; ?>>Amazonas</option>
                <option value="BA" <?php if ($funcionario['estado'] == 'BA')
                    echo 'selected'; ?>>Bahia</option>
                <option value="CE" <?php if ($funcionario['estado'] == 'CE')
                    echo 'selected'; ?>>Ceará</option>
                <option value="DF" <?php if ($funcionario['estado'] == 'DF')
                    echo 'selected'; ?>>Distrito Federal</option>
                <option value="ES" <?php if ($funcionario['estado'] == 'ES')
                    echo 'selected'; ?>>Espírito Santo</option>
                <option value="GO" <?php if ($funcionario['estado'] == 'GO')
                    echo 'selected'; ?>>Goiás</option>
                <option value="MA" <?php if ($funcionario['estado'] == 'MA')
                    echo 'selected'; ?>>Maranhão</option>
                <option value="MT" <?php if ($funcionario['estado'] == 'MT')
                    echo 'selected'; ?>>Mato Grosso</option>
                <option value="MS" <?php if ($funcionario['estado'] == 'MS')
                    echo 'selected'; ?>>Mato Grosso do Sul
                </option>
                <option value="MG" <?php if ($funcionario['estado'] == 'MG')
                    echo 'selected'; ?>>Minas Gerais</option>
                <option value="PA" <?php if ($funcionario['estado'] == 'PA')
                    echo 'selected'; ?>>Pará</option>
                <option value="PB" <?php if ($funcionario['estado'] == 'PB')
                    echo 'selected'; ?>>Paraíba</option>
                <option value="PR" <?php if ($funcionario['estado'] == 'PR')
                    echo 'selected'; ?>>Paraná</option>
                <option value="PE" <?php if ($funcionario['estado'] == 'PE')
                    echo 'selected'; ?>>Pernambuco</option>
                <option value="PI" <?php if ($funcionario['estado'] == 'PI')
                    echo 'selected'; ?>>Piauí</option>
                <option value="RJ" <?php if ($funcionario['estado'] == 'RJ')
                    echo 'selected'; ?>>Rio de Janeiro</option>
                <option value="RN" <?php if ($funcionario['estado'] == 'RN')
                    echo 'selected'; ?>>Rio Grande do Norte
                </option>
                <option value="RS" <?php if ($funcionario['estado'] == 'RS')
                    echo 'selected'; ?>>Rio Grande do Sul
                </option>
                <option value="RO" <?php if ($funcionario['estado'] == 'RO')
                    echo 'selected'; ?>>Rondônia</option>
                <option value="RR" <?php if ($funcionario['estado'] == 'RR')
                    echo 'selected'; ?>>Roraima</option>
                <option value="SC" <?php if ($funcionario['estado'] == 'SC')
                    echo 'selected'; ?>>Santa Catarina</option>
                <option value="SP" <?php if ($funcionario['estado'] == 'SP')
                    echo 'selected'; ?>>São Paulo</option>
                <option value="SE" <?php if ($funcionario['estado'] == 'SE')
                    echo 'selected'; ?>>Sergipe</option>
                <option value="TO" <?php if ($funcionario['estado'] == 'TO')
                    echo 'selected'; ?>>Tocantins</option>
            </select><br><br>

            <button type="submit">Atualizar Perfil</button>
        </form>

    </main>

    <footer>
        <p>&copy; 2024 LOVETEC. Todos os direitos reservados.</p>
    </footer>
</body>

</html>