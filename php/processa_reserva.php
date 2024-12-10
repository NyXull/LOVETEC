<?php
session_start();

// Verificar se o usuário está logado como cliente
if ($_SESSION['tipo_usuario'] != 'cliente') {
    header("Location: index.php");
    exit();
}

// Conectar ao banco de dados
include 'conexao-banco.php';

// Pegar o ID do veículo e data da reserva do formulário
$id_veiculo = isset($_POST['id_veiculo']) ? $_POST['id_veiculo'] : null;
$data_reserva = isset($_POST['data_reserva']) ? $_POST['data_reserva'] : null;
$id_cliente = $_SESSION['id_usuario']; // ID do cliente logado

if ($id_veiculo && $data_reserva) {
    // Verificar se o cliente já tem esse veículo reservado ou alugado
    $query_verifica_reserva = "SELECT COUNT(*) AS carro_reservado
                               FROM LOVETEC.Reserva 
                               WHERE id_cliente = '$id_cliente' 
                               AND id_veiculo = '$id_veiculo' 
                               AND (status_reserva = 'Ativo' OR status_reserva = 'Reservado')";
    
    $result_verifica = mysqli_query($conn, $query_verifica_reserva);
    $reserva = mysqli_fetch_assoc($result_verifica);

    if ($reserva['carro_reservado'] > 0) {
        echo "Você já tem esse veículo reservado ou alugado.";
        exit();
    }

    // Inserir a nova reserva no banco de dados
    $query_reserva = "INSERT INTO LOVETEC.Reserva (id_cliente, id_veiculo, data_reserva, status_reserva) 
                      VALUES ('$id_cliente', '$id_veiculo', '$data_reserva', 'Reservado')";

    if (mysqli_query($conn, $query_reserva)) {
        echo "Reserva realizada com sucesso!";
        header("Location: perfil_cliente.php"); // Redireciona para o perfil do cliente após a reserva
    } else {
        echo "Erro ao realizar a reserva: " . mysqli_error($conn);
    }
} else {
    echo "Dados inválidos para realizar a reserva.";
}
?>
