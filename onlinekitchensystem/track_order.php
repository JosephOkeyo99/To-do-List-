<?php
session_start();
include 'connection.php';

// Redirect non-logged-in users
if(!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$order_status = '';
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = intval($_POST['order_id']);
    $user_id  = $_SESSION['user_id'];

    $query = mysqli_query($conn, "SELECT * FROM orders WHERE id='$order_id' AND user_id='$user_id'");
    
    if(mysqli_num_rows($query) > 0) {
        $order = mysqli_fetch_assoc($query);
        
        // Check payment status
        if($order['payment_status'] === 'Completed') {
            // Format delivery time
            $delivery_time = date("h:i A, d M Y", strtotime($order['delivery_time']));
            $order_status = "✅ Your order #{$order['id']} has been received and is being prepared. 
                             It is expected to reach you by <strong>$delivery_time</strong>. 
                             Total: Ksh {$order['total_price']}";
        } else {
            $order_status = "⚠️ Your order #{$order['id']} is not yet completed. Current status: <strong>{$order['payment_status']}</strong>.";
        }

    } else {
        $order_status = "❌ No order found with ID: $order_id";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Track Your Order | Foodie</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
<style>
body { font-family:'Poppins', sans-serif; background:#f8f8f8; color:#333; margin:0; padding:0; }
header { position:sticky; top:0; width:100%; background:#fff; z-index:1000; box-shadow:0 2px 10px rgba(0,0,0,0.05); padding:12px 5%; display:flex; justify-content:space-between; align-items:center; }
.logo { font-size:24px; font-weight:700; color:#ff4d4d; display:flex; align-items:center; gap:8px; }
.nav-links a { margin-left:20px; color:#444; font-weight:500; text-decoration:none; transition:.3s; }
.nav-links a:hover, .nav-links a.active { color:#ff4d4d; }
.container { max-width:600px; margin:80px auto; background:#fff; padding:30px; border-radius:12px; box-shadow:0 6px 25px rgba(0,0,0,0.1); }
.container h2 { text-align:center; margin-bottom:25px; color:#ff4d4d; }
.input-box { margin-bottom:20px; display:flex; flex-direction:column; }
.input-box label { margin-bottom:6px; font-weight:500; }
.input-box input { padding:10px 12px; border:1px solid #ccc; border-radius:6px; font-size:14px; }
.btn { padding:12px 25px; background:#ff4d4d; color:#fff; font-size:16px; font-weight:600; border:none; border-radius:6px; cursor:pointer; transition:.3s; }
.btn:hover { background:#e03b3b; }
.status { margin-top:20px; font-size:16px; text-align:center; }
</style>
</head>
<body>

<header>
    <a href="index.php" class="logo"><i class="fas fa-utensils"></i> Foodie</a>
    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="track_order.php" class="active">Track Order</a>
        <a href="logout.php">Logout</a>
    </div>
</header>

<div class="container">
    <h2>Track Your Order</h2>
    <form method="POST">
        <div class="input-box">
            <label for="order_id">Enter Your Order ID</label>
            <input type="number" id="order_id" name="order_id" placeholder="Order ID" required>
        </div>
        <input type="submit" value="Check Status" class="btn">
    </form>

    <?php if($order_status): ?>
        <div class="status"><?= $order_status; ?></div>
    <?php endif; ?>
</div>

</body>
</html>
