<?php
session_start();
include 'connection.php';

$reference = $_GET['reference'] ?? '';
$status    = $_GET['status'] ?? '';

if (!$reference) {
    die("No order reference provided.");
}

// Fetch order info if payment succeeded
$order = null;
if ($status === 'success') {
    $stmt = mysqli_prepare($conn, "SELECT id, order_ref, total_price, created_at FROM orders WHERE order_ref = ?");
    mysqli_stmt_bind_param($stmt, "s", $reference);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result && mysqli_num_rows($result) > 0) {
        $order = mysqli_fetch_assoc($result);
    }
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Status | Foodie</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
body { font-family: 'Poppins', sans-serif; background: #f8f8f8; margin:0; padding:0; }
.container { max-width: 700px; margin: 80px auto; background:#fff; padding:40px; border-radius:12px; box-shadow:0 6px 25px rgba(0,0,0,0.1); text-align:center; }
h1 { font-size: 36px; margin-bottom: 20px; }
p { font-size: 18px; margin: 10px 0; }
.success { color: #28a745; }
.failed { color: #dc3545; }
.btn-home { display:inline-block; margin-top:20px; padding:12px 25px; background:#ff4d4d; color:#fff; border-radius:6px; text-decoration:none; transition:.3s; }
.btn-home:hover { background:#e03b3b; }
.order-info { margin-top: 20px; padding: 20px; background: #f1f1f1; border-radius:8px; text-align:left; display:inline-block; }
.order-info span { font-weight:600; }
</style>
</head>
<body>

<div class="container">
    <?php if ($status === 'success' && $order): ?>
        <h1 class="success"><i class="fas fa-check-circle"></i> Payment Successful!</h1>
        <p>Thank you for your order. Your payment has been confirmed.</p>
        <div class="order-info">
            <p><span>Order ID:</span> <?= htmlspecialchars($order['id']); ?></p>
            <p><span>Reference:</span> <?= htmlspecialchars($order['order_ref']); ?></p>
            <p><span>Total Paid:</span> Ksh <?= number_format($order['total_price'], 2); ?></p>
            <p><span>Order Date:</span> <?= date("F j, Y, g:i a", strtotime($order['created_at'])); ?></p>
        </div>
        <p>You can track your order using the Order ID.</p>
    <?php else: ?>
        <h1 class="failed"><i class="fas fa-times-circle"></i> Payment Failed!</h1>
        <p>Unfortunately, your payment was not successful.</p>
        <p>Please try again or contact support.</p>
    <?php endif; ?>

    <a href="index.php" class="btn-home">Go Back to Home</a>
</div>

</body>
</html>
