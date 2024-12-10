<?php
session_start();

// Verificar se o usuário está logado como cliente
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'cliente') {
    header("Location: html/login.html"); // Se não for cliente, redireciona para o login
    exit();
}

// Conectar ao banco de dados
include 'conexao-banco.php';

// Verificar se o id_reserva foi passado via GET
if (isset($_GET['id_reserva'])) {
    $id_reserva = $_GET['id_reserva'];

    // Pegar o id_cliente do cliente logado
    $id_cliente = $_SESSION['id_usuario'];

    // Verificar se a reserva pertence ao cliente
    $query_reserva = "SELECT id_cliente FROM LOVETEC.Reserva WHERE id_reserva = '$id_reserva' AND id_cliente = '$id_cliente'";
    $result_reserva = mysqli_query($conn, $query_reserva);

    // Se a reserva pertence ao cliente, deletar
    if (mysqli_num_rows($result_reserva) > 0) {
        // Deletar a reserva
        $query_delete = "DELETE FROM LOVETEC.Reserva WHERE id_reserva = '$id_reserva'";
        if (mysqli_query($conn, $query_delete)) {
            // Redirecionar para o perfil do cliente com uma mensagem de sucesso
            header("Location: perfil_cliente.php?msg=Reserva cancelada com sucesso.");
            exit();
        } else {
            // Caso ocorra um erro ao excluir
            echo "Erro ao cancelar a reserva. Tente novamente.";
        }
    } else {
        // Caso a reserva não pertença ao cliente
        echo "Você não tem permissão para cancelar esta reserva.";
    }
} else {
    echo "Reserva não encontrada.";
}
?>
