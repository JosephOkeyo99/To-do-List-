<?php
session_start();
include 'connection.php';

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle quantity update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update'])) {
        foreach ($_POST['quantities'] as $dish_id => $qty) {
            $qty = (int)$qty;
            if ($qty > 0) {
                $_SESSION['cart'][$dish_id] = $qty;
            } else {
                unset($_SESSION['cart'][$dish_id]);
            }
        }
    } elseif (isset($_POST['remove'])) {
        $dish_id = (int)$_POST['remove'];
        unset($_SESSION['cart'][$dish_id]);
    }
    header("Location: cart.php");
    exit;
}

// Fetch dish details for items in cart
$cartItems = [];
$totalPrice = 0;

if (!empty($_SESSION['cart'])) {
    $ids = implode(',', array_keys($_SESSION['cart']));
    $query = "SELECT * FROM dishes WHERE id IN ($ids)";
    $result = mysqli_query($conn, $query);

    while ($dish = mysqli_fetch_assoc($result)) {
        $dish_id = $dish['id'];
        $dish['quantity'] = $_SESSION['cart'][$dish_id];
        $dish['subtotal'] = $dish['quantity'] * $dish['price'];
        $totalPrice += $dish['subtotal'];
        $cartItems[] = $dish;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Cart — Foodie</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
body { font-family: 'Poppins', sans-serif; background: #f8f8f8; margin:0; padding:0; }
.container { max-width: 1000px; margin: 50px auto; padding: 0 20px; }
h1 { text-align: center; margin-bottom: 30px; color: #ff4d4d; }
table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
th, td { padding: 15px; text-align: center; }
th { background: #ff4d4d; color: #fff; font-weight: 600; }
td img { width: 80px; height: 80px; object-fit: cover; border-radius: 6px; }
input[type=number] { width: 60px; padding: 5px; }
button { padding: 8px 15px; border: none; border-radius: 6px; cursor: pointer; transition: 0.3s; }
button.update { background: #ff4d4d; color: #fff; }
button.update:hover { background: #e84343; }
button.remove { background: #aaa; color: #fff; }
button.remove:hover { background: #777; }
.total { text-align: right; font-size: 20px; font-weight: 700; margin-top: 20px; }
.empty { text-align: center; font-size: 18px; margin-top: 50px; color: #666; }
.checkout-btn { display: block; text-align: center; margin-top: 20px; background: #333; color: #fff; padding: 12px 30px; border-radius: 8px; text-decoration: none; transition: 0.3s; }
.checkout-btn:hover { background: #111; }
@media(max-width:768px){ table, th, td { font-size: 14px; } td img { width: 60px; height: 60px; } input[type=number]{ width:50px; } }
</style>
</head>
<body>

<div class="container">
    <h1>Your Cart</h1>

    <?php if(empty($cartItems)): ?>
        <p class="empty">Your cart is empty. <a href="index.php">Go back to menu</a></p>
    <?php else: ?>
        <form method="POST" action="">
            <table>
                <tr>
                    <th>Dish</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
                <?php foreach($cartItems as $item): ?>
                <tr>
                    <td>
                        <img src="uploads/<?= $item['image']; ?>" alt="<?= htmlspecialchars($item['title']); ?>">
                        <br><?= htmlspecialchars($item['title']); ?>
                    </td>
                    <td>Ksh <?= number_format($item['price']); ?></td>
                    <td><input type="number" name="quantities[<?= $item['id']; ?>]" value="<?= $item['quantity']; ?>" min="1"></td>
                    <td>Ksh <?= number_format($item['subtotal']); ?></td>
                    <td>
                        <button type="submit" name="remove" value="<?= $item['id']; ?>" class="remove"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <button type="submit" name="update" class="update">Update Cart</button>
        </form>
        <p class="total">Total: Ksh <?= number_format($totalPrice); ?></p>
        <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
    <?php endif; ?>
</div>

</body>
</html>
