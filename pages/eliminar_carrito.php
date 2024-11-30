<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_producto']) && isset($_POST['cantidad'])) {
    $id_producto = $_POST['id_producto'];
    $cantidad_a_eliminar = (int)$_POST['cantidad'];

    // Verificar si el producto está en el carrito
    if (isset($_SESSION['carrito'][$id_producto])) {
        // Restar la cantidad solicitada
        $_SESSION['carrito'][$id_producto]['cantidad'] -= $cantidad_a_eliminar;

        // Si la cantidad llega a 0, eliminar el producto del carrito
        if ($_SESSION['carrito'][$id_producto]['cantidad'] <= 0) {
            unset($_SESSION['carrito'][$id_producto]);
        }
    }

    // Redirigir de nuevo al carrito
    header('Location: carrito.php');
    exit();
}
