<?php
session_start();
include 'connection.php';

// Get pre-filled values from cart (simplified example)
$cart = $_SESSION['cart'] ?? [];
$totalPrice = 0;

// Prepare item list for display
$items = [];

foreach ($cart as $dish_id => $qty) {
    $dish_res = mysqli_query($conn, "SELECT * FROM dishes WHERE id = ".intval($dish_id));
    $dish = mysqli_fetch_assoc($dish_res);
    if ($dish) {
        $line_total = $dish['price'] * $qty;
        $totalPrice += $line_total;

        $items[] = [
            'name' => $dish['title'],
            'qty' => $qty,
            'price' => $dish['price'],
            'total' => $line_total
        ];
    }
}

// Fetch logged in user email for Paystack
$user_email = $_SESSION['user_email'] ?? 'customer@example.com';
$user_name = $_SESSION['user_name'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout | Foodie</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
body { margin:0; font-family:'Poppins', sans-serif; background:#f8f8f8; color:#333; }
header { width:100%; background:#fff; display:flex; justify-content:space-between; align-items:center; padding:12px 5%; box-shadow:0 2px 10px rgba(0,0,0,0.05); position:sticky; top:0; z-index:1000; }
header .logo { font-size:24px; font-weight:700; color:#ff4d4d; display:flex; align-items:center; gap:8px; }
.navbar { display:flex; gap:25px; }
.navbar a { font-size:16px; font-weight:500; color:#444; transition:.3s; }
.navbar a:hover, .navbar a.active { color:#ff4d4d; }
.icons a { font-size:20px; color:#ff4d4d; margin-left:12px; transition:.3s; }
.icons a:hover { color:#e03b3b; }
.checkout-container { max-width:900px; margin:2rem auto 4rem auto; background:#fff; padding:30px; border-radius:12px; box-shadow:0 6px 25px rgba(0,0,0,0.1); }

.order-summary-box {
    background:#fff5f5;
    border:1px solid #ffcccc;
    padding:20px;
    border-radius:10px;
    margin-bottom:25px;
}

.order-summary-box h3 {
    margin:0 0 15px 0;
    color:#ff4d4d;
    font-size:20px;
}

.order-item {
    display:flex;
    justify-content:space-between;
    padding:8px 0;
    border-bottom:1px solid #eee;
}

.order-item span { font-size:14px; }
.order-item .name { font-weight:600; }
.order-item .total { color:#ff4d4d; font-weight:bold; }

.total-summary {
    text-align:right;
    margin-top:10px;
    font-size:18px;
    font-weight:bold;
    color:#ff4d4d;
}

.checkout-container h2 { font-size:28px; margin-bottom:25px; text-align:center; }
.checkout-container h2 span { color:#ff4d4d; }
.input-group { display:flex; flex-wrap:wrap; gap:20px; margin-bottom:15px; }
.input-box { flex:1 1 45%; display:flex; flex-direction:column; }
.input-box label { margin-bottom:6px; font-weight:500; }
.input-box input, .input-box textarea { padding:10px 12px; border:1px solid #ccc; border-radius:6px; font-size:14px; width:100%; transition:.3s; }
.input-box input:focus, .input-box textarea:focus { border-color:#ff4d4d; outline:none; }
.input-box textarea { resize:none; }
.btn-pay { padding:12px 25px; background:#ff4d4d; color:#fff; font-size:16px; font-weight:600; border:none; border-radius:6px; cursor:pointer; transition:.3s; width:100%; margin-top:10px; }
.btn-pay:hover { background:#e03b3b; }
@media(max-width:768px) { .input-box { flex:1 1 100%; } .navbar { flex-wrap:wrap; justify-content:center; gap:15px; } }
</style>
</head>

<body>

<header>
    <a href="index.php" class="logo"><i class="fas fa-utensils"></i> Foodie</a>
    <nav class="navbar">
        <a href="index.php">Home</a>
        <a href="index.php#dishes">Dishes</a>
        <a href="index.php#menu">Menu</a>
        <a href="index.php#about">About</a>
        <a href="checkout.php" class="active">Checkout</a>
    </nav>
    <div class="icons">
        <a href="cart.php" title="View Cart" class="fas fa-shopping-cart"></a>
    </div>
</header>

<div class="checkout-container">

<h2>Confirm Your Order <span>Proceed to Payment</span></h2>

<!-- ⭐⭐⭐ ORDER SUMMARY ADDED ⭐⭐⭐ -->
<div class="order-summary-box">
    <h3>Order Summary</h3>

    <?php if (!empty($items)): ?>
        <?php foreach ($items as $item): ?>
            <div class="order-item">
                <span class="name"><?= htmlspecialchars($item['name']) ?> × <?= $item['qty'] ?></span>
                <span class="total">KES <?= number_format($item['total'], 2) ?></span>
            </div>
        <?php endforeach; ?>

        <div class="total-summary">
            Total: KES <?= number_format($totalPrice, 2) ?>
        </div>
    <?php else: ?>
        <p>No items in cart.</p>
    <?php endif; ?>
</div>
<!-- END SUMMARY -->

<form id="checkoutForm">
    <div class="input-group">
        <div class="input-box">
            <label for="name">Name</label>
            <input type="text" id="name" value="<?= htmlspecialchars($user_name) ?>" required>
        </div>
        <div class="input-box">
            <label for="email">Email</label>
            <input type="email" id="email" value="<?= htmlspecialchars($user_email) ?>" required>
        </div>
    </div>
    <div class="input-group">
        <div class="input-box">
            <label for="phone">Phone</label>
            <input type="tel" id="phone" placeholder="Enter phone number" required>
        </div>
        <div class="input-box">
            <label for="address">Delivery Address</label>
            <textarea id="address" placeholder="Enter your delivery address" required></textarea>
        </div>
    </div>

    <div class="input-group">
        <div class="input-box">
            <label>Total Amount (KES)</label>
            <input type="text" id="totalAmount" value="<?= number_format($totalPrice, 2) ?>" readonly>
        </div>
        <input type="hidden" id="totalPrice" value="<?= $totalPrice ?>">
    </div>

    <button type="button" id="payButton" class="btn-pay">Pay Now</button>
</form>
</div>

<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
const payButton = document.getElementById('payButton');

payButton.addEventListener('click', function() {
    let name = document.getElementById('name').value;
    let email = document.getElementById('email').value;
    let phone = document.getElementById('phone').value;
    let address = document.getElementById('address').value;
    let total = parseFloat(document.getElementById('totalPrice').value);

    if (!name || !email || !phone || !address) {
        alert("Please fill all required fields.");
        return;
    }

    let handler = PaystackPop.setup({
        key: 'pk_test_83ff4eb4fa4f5d7c2ef6c7350b01f0980b9c61ce',
        email: email,
        amount: total * 100,
        currency: "KES",
        ref: '' + Math.floor(Math.random() * 1000000000 + 1),

        callback: function(response) {

            // Send to verify_payment.php via POST
            fetch("verify_payment.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    reference: response.reference,
                    name: name,
                    email: email,
                    phone: phone,
                    address: address,
                    items: <?= json_encode($items) ?>, // send items list
                    total: total
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    window.location.href = "success.php?reference=" + response.reference;
                } else {
                    alert("Order could not be saved.");
                }
            });
        },

        onClose: function() {
            alert('Payment was cancelled.');
        }
    });

    handler.openIframe();
});
</script>


</body>
</html>
