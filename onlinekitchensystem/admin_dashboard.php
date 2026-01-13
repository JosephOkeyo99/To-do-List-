<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// Add Dish
if (isset($_POST['add_dish'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    $image = '';
    if ($_FILES['image']['name']) {
        $image = time() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/$image");
    }

    mysqli_query($conn, "INSERT INTO dishes (title, description, price, category, image) VALUES ('$title','$description','$price','$category','$image')");
    header("Location: admin_dashboard.php");
    exit;
}

// Delete Dish
if (isset($_GET['delete_dish'])) {
    $id = intval($_GET['delete_dish']);
    mysqli_query($conn, "DELETE FROM dishes WHERE id=$id");
    header("Location: admin_dashboard.php");
    exit;
}

$dishes = mysqli_query($conn, "SELECT * FROM dishes ORDER BY id DESC");
$users = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
$orders = mysqli_query($conn, "SELECT * FROM orders ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Foodie — Admin Dashboard</title>

<style>
/* ===== GLOBAL STYLES ===== */
body {
    font-family: "Poppins", sans-serif;
    margin: 0;
    display: flex;
    background: #f1f3f6;
}

/* ===== SIDEBAR ===== */
.sidebar {
    width: 260px;
    height: 100vh;
    background: #212529;
    padding: 20px;
    position: fixed;
    color: #fff;
}
.sidebar h2 {
    font-size: 1.3rem;
    font-weight: bold;
    margin-bottom: 1.5rem;
}
.sidebar a {
    display: block;
    padding: 12px 15px;
    color: #d7d7d7;
    text-decoration: none;
    margin: 8px 0;
    border-radius: 6px;
    transition: .3s;
}
.sidebar a:hover,
.sidebar a.active {
    background: #ff523b;
    color: #fff;
}

/* ===== MAIN AREA ===== */
.main {
    margin-left: 260px;
    padding: 20px;
    width: calc(100% - 260px);
}

/* HEADER */
.topbar {
    background: #fff;
    padding: 15px 25px;
    border-radius: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}
.topbar h1 {
    margin: 0;
    font-size: 1.4rem;
}
.topbar .admin-info {
    font-weight: 600;
}

/* SECTIONS */
.section-card {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.05);
    margin-bottom: 25px;
    display: none;
}
.section-card.active {
    display: block;
}

.section-card h2 {
    margin-top: 0;
    font-size: 1.3rem;
    margin-bottom: 15px;
}

/* TABLE */
.table {
    width: 100%;
    border-collapse: collapse;
}
.table th, .table td {
    padding: 12px;
    border-bottom: 1px solid #eee;
}
.table th {
    background: #f9fafc;
}

/* BUTTONS */
.btn {
    padding: 8px 16px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-weight: 600;
}
.btn-primary {
    background: #ff523b;
    color: #fff;
}
.btn-danger {
    background: #dc3545;
    color: #fff;
}
.btn:hover {
    opacity: 0.9;
}

/* FORM */
form input, form select {
    width: 100%;
    padding: 10px;
    margin: 8px 0;
    border-radius: 8px;
    border: 1px solid #ccc;
}
</style>

</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>🍴 Foodie Admin</h2>
    <a href="#" onclick="showSection('orders')" class="active">📦 Orders</a>
    <a href="#" onclick="showSection('dishes')">🍕 Dishes</a>
    <a href="#" onclick="showSection('users')">👥 Users</a>
    <a href="logout.php">🚪 Logout</a>
</div>

<!-- MAIN CONTENT -->
<div class="main">

    <div class="topbar">
        <h1>Dashboard Overview</h1>
        <div class="admin-info">Welcome, Admin</div>
    </div>

    <!-- ORDERS -->
    <div id="orders" class="section-card active">
        <h2>Orders</h2>
        <table class="table">
            <thead>
                <tr><th>ID</th><th>Name</th><th>Phone</th><th>Items</th><th>Qty</th><th>Delivery</th><th>Status</th></tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($orders) > 0): 
                while($order = mysqli_fetch_assoc($orders)): ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td><?= htmlspecialchars($order['name']) ?></td>
                    <td><?= htmlspecialchars($order['phone']) ?></td>
                    <td><?= htmlspecialchars($order['items']) ?></td>
                    <td><?= $order['quantity'] ?></td>
                    <td><?= htmlspecialchars($order['delivery_address']) ?></td>
                    <td><?= $order['payment_status'] ?></td>
                </tr>
                <?php endwhile; else: ?>
                <tr><td colspan="7">No orders available</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- DISHES -->
    <div id="dishes" class="section-card">
        <h2>Manage Dishes</h2>

        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Dish title" required>
            <input type="text" name="description" placeholder="Description" required>
            <input type="number" name="price" step="0.01" placeholder="Price" required>
            <input type="text" name="category" placeholder="Category" required>
            <input type="file" name="image" required>
            <button type="submit" name="add_dish" class="btn btn-primary">Add Dish</button>
        </form>

        <br><h3>Existing Dishes</h3>
        <table class="table">
            <thead><tr><th>ID</th><th>Title</th><th>Price</th><th>Action</th></tr></thead>
            <tbody>
                <?php if (mysqli_num_rows($dishes) > 0):
                while($dish = mysqli_fetch_assoc($dishes)): ?>
                <tr>
                    <td><?= $dish['id'] ?></td>
                    <td><?= htmlspecialchars($dish['title']) ?></td>
                    <td>Ksh <?= $dish['price'] ?></td>
                    <td><a href="?delete_dish=<?= $dish['id'] ?>"><button class="btn btn-danger">Delete</button></a></td>
                </tr>
                <?php endwhile; else: ?>
                <tr><td colspan="4">No dishes found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- USERS -->
    <div id="users" class="section-card">
        <h2>Users</h2>
        <table class="table">
            <thead><tr><th>ID</th><th>Name</th><th>Email</th></tr></thead>
            <tbody>
                <?php if (mysqli_num_rows($users) > 0):
                while($user = mysqli_fetch_assoc($users)): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                </tr>
                <?php endwhile; else: ?>
                <tr><td colspan="4">No users</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<script>
function showSection(sectionId) {
    document.querySelectorAll('.section-card').forEach(s => s.classList.remove('active'));
    document.getElementById(sectionId).classList.add('active');

    document.querySelectorAll('.sidebar a').forEach(a => a.classList.remove('active'));
    event.target.classList.add('active');
}
</script>

</body>
</html>
