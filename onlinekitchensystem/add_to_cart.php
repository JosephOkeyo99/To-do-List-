<?php
session_start();
include 'connection.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dish_id'])) {
    $dish_id = (int) $_POST['dish_id'];

    // Initialize cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Increment quantity if dish already in cart, otherwise set to 1
    if (isset($_SESSION['cart'][$dish_id])) {
        $_SESSION['cart'][$dish_id]++;
    } else {
        $_SESSION['cart'][$dish_id] = 1;
    }

    // Optional: Set a flash message
    $_SESSION['message'] = "Dish added to cart successfully!";

    // Redirect back to previous page or menu page
    $redirect = $_SERVER['HTTP_REFERER'] ?? 'index.php';
    header("Location: $redirect");
    exit;
} else {
    // Invalid access
    header("Location: index.php");
    exit;
}
