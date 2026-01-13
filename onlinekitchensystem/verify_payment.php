<?php
session_start();
include 'connection.php';

if (!isset($_GET['reference'])) {
    die("Invalid request. No payment reference found.");
}

$reference = $_GET['reference'];
$user_id = $_SESSION['user_id'] ?? 0;
$cart = $_SESSION['cart'] ?? [];

// Paystack Secret Key
$secret_key = "sk_test_c6e6b53e8e399b9bb10c267020345f94865b1d8c";

// Step 1: Verify payment with Paystack API
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "accept: application/json",
        "authorization: Bearer $secret_key",
        "cache-control: no-cache"
    ],
]);

$response = curl_exec($curl);
curl_close($curl);

$result = json_decode($response, true);

if (!$result || !isset($result['data'])) {
    die("Invalid Paystack response: " . htmlspecialchars($response));
}

// Step 2: Check if payment was successful
if ($result['data']['status'] === 'success') {
    
    $amount = $result['data']['amount'] / 100; 
    $status = 'Completed';
    $order_ref = mysqli_real_escape_string($conn, $reference);

    // Collect customer info from session
    $name = mysqli_real_escape_string($conn, $_SESSION['checkout_name'] ?? '');
    $email = mysqli_real_escape_string($conn, $_SESSION['checkout_email'] ?? '');
    $phone = mysqli_real_escape_string($conn, $_SESSION['checkout_phone'] ?? '');
    $address = mysqli_real_escape_string($conn, $_SESSION['checkout_address'] ?? '');

    // INSERT ORDER
    $insertOrder = "INSERT INTO orders 
        (user_id, order_ref, total_price, payment_status, name, email, phone, address, created_at)
        VALUES 
        ('$user_id', '$order_ref', '$amount', '$status', '$name', '$email', '$phone', '$address', NOW())";

    if (mysqli_query($conn, $insertOrder)) {

        $order_id = mysqli_insert_id($conn);

        // INSERT ORDER ITEMS
        foreach ($cart as $dish_id => $quantity) {

            $dish_res = mysqli_query($conn, "SELECT * FROM dishes WHERE id=" . intval($dish_id));
            $dish = mysqli_fetch_assoc($dish_res);

            if ($dish) {
                $dish_name = mysqli_real_escape_string($conn, $dish['title']);
                $price = floatval($dish['price']);
                $line_total = $price * $quantity;

                mysqli_query($conn, 
                    "INSERT INTO order_items (order_id, dish_id, dish_name, quantity, price, total)
                     VALUES ('$order_id', '$dish_id', '$dish_name', '$quantity', '$price', '$line_total')"
                );
            }
        }

        // Clear cart
        unset($_SESSION['cart']);

        // Redirect to success
        header("Location: success.php?reference=$reference&status=success");
        exit;

    } else {
        die("Failed to save order: " . mysqli_error($conn));
    }

} else {
    // Payment failed
    header("Location: success.php?reference=$reference&status=failed");
    exit;
}
?>
