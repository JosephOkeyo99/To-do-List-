<?php
include 'connection.php';
session_start();

// Fetch dishes
$popularDishes = mysqli_query($conn, "SELECT * FROM dishes WHERE category='dishes' ORDER BY id DESC");
$menuDishes    = mysqli_query($conn, "SELECT * FROM dishes WHERE category='menu' ORDER BY id DESC");

// Calculate total cart items
$cart_count = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $quantity) {
        $cart_count += intval($quantity);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Foodie — Fresh & Fast Meals</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
<style>
/* ===== GLOBAL ===== */
body { margin:0; font-family:'Poppins', sans-serif; background:#f8f8f8; color:#333; }
a { text-decoration:none; }
h1,h2,h3,p { margin:0; }
section { padding:60px 5%; }

/* ===== HEADER / NAVBAR ===== */
header { position:sticky; top:0; width:100%; background:#fff; z-index:1000; box-shadow:0 2px 10px rgba(0,0,0,0.05); }
.nav-container { display:flex; justify-content:space-between; align-items:center; padding:15px 5%; flex-wrap:wrap; gap:10px; }
.logo { font-size:24px; font-weight:700; color:#ff4d4d; display:flex; align-items:center; gap:8px; }
.nav-links { display:flex; gap:30px; flex:1; justify-content:center; }
.nav-links a { color:#444; font-weight:500; font-size:16px; transition:.3s; }
.nav-links a:hover, .nav-links a.active { color:#ff4d4d; }
.nav-actions { display:flex; align-items:center; gap:10px; flex-shrink:0; }
.user-greeting { font-weight:500; font-size:15px; color:#333; }
.nav-btn { padding:8px 18px; border-radius:6px; font-size:14px; font-weight:500; cursor:pointer; text-decoration:none; color:#fff; transition:.3s; border:none; }
.nav-btn.login { background:#ff4d4d; }
.nav-btn.signup { background:#333; }
.nav-btn.logout { background:#444; }
.nav-btn:hover { opacity:.85; }
.cart-icon-link { position:relative; display:flex; align-items:center; justify-content:center; font-size:20px; color:#444; width:30px; height:30px; }
.cart-icon-link:hover { color:#ff4d4d; }
.cart-count { position:absolute; top:-8px; right:-10px; background:#ff4d4d; color:#fff; border-radius:50%; padding:2px 6px; font-size:12px; font-weight:600; line-height:1; border:2px solid #fff; display:flex; align-items:center; justify-content:center; }

/* HAMBURGER MOBILE */
.hamburger { display:none; font-size:22px; cursor:pointer; color:#444; }
@media (max-width:900px){
    .hamburger { display:block; }
    .nav-links { display:none; flex-direction:column; width:100%; background:#fff; gap:15px; padding:15px 0; border-top:1px solid #eee; }
    .nav-links.active { display:flex; }
    .nav-actions { width:100%; justify-content:center; margin-top:10px; flex-wrap:wrap; gap:10px; }
}

/* ===== HERO ===== */
.hero { height:70vh; background:url('uploads/picb.jfif') no-repeat center/cover; display:flex; justify-content:center; align-items:center; position:relative; }
.hero-overlay { background:rgba(0,0,0,0.6); width:100%; height:100%; display:flex; justify-content:center; align-items:center; }
.hero-content { text-align:center; color:#fff; padding:0 10%; }
.hero-content h1 { font-size:48px; font-weight:700; }
.hero-content p { margin-top:10px; font-size:18px; }
.btn-hero { margin-top:20px; background:#ff4d4d; padding:12px 26px; border-radius:8px; font-size:17px; color:#fff; display:inline-block; transition:.3s; }
.btn-hero:hover { background:#e03b3b; }

/* ===== SECTIONS ===== */
.heading { font-size:32px; text-align:center; margin-bottom:40px; font-weight:700; }
.heading span { color:#ff4d4d; }

/* ===== DISH CARDS ===== */
.box-container { display:grid; gap:25px; grid-template-columns:repeat(auto-fit,minmax(260px,1fr)); }
.box { background:#fff; border-radius:14px; overflow:hidden; padding-bottom:20px; box-shadow:0 4px 20px rgba(0,0,0,0.08); transition:.3s ease-in-out; }
.box:hover { transform:translateY(-5px); }
.box img { width:100%; height:200px; object-fit:cover; }
.box h3 { font-size:20px; margin:12px; }
.box p { font-size:14px; padding:0 12px; color:#666; }
.price-display { font-size:18px; margin:10px 12px; font-weight:600; color:#ff4d4d; }
.box a.btn, .box form button.btn { display:inline-block; margin:10px 12px; background:#ff4d4d; padding:10px 18px; border-radius:6px; color:#fff; font-size:14px; font-weight:500; text-align:center; transition:.3s; border:none; cursor:pointer; }
.box a.btn:hover, .box form button.btn:hover { background:#e03b3b; }

/* ===== ABOUT ===== */
.about .row { display:flex; flex-wrap:wrap; gap:35px; align-items:center; }
.about .row .image { flex:1 1 450px; }
.about .row .image img { width:100%; border-radius:15px; box-shadow:0 6px 18px rgba(0,0,0,0.1); }
.about .content { flex:1 1 450px; }
.about .content h3 { font-size:28px; margin-bottom:10px; }
.about .icons-container { display:flex; gap:20px; margin:20px 0; }
.about .icons { display:flex; align-items:center; gap:10px; }
.about .icons i { font-size:20px; color:#ff4d4d; }

/* ===== RESPONSIVE ===== */
@media (max-width:500px){
    .hero-content h1 { font-size:36px; }
    .hero-content p { font-size:16px; }
    .box-container { grid-template-columns:1fr; }
    .about .row { flex-direction:column; }
}
</style>
</head>
<body>

<header>
    <div class="nav-container">
        <a href="index.php" class="logo"><i class="fas fa-utensils"></i> Foodie</a>
        <div class="hamburger" id="hamburger"><i class="fas fa-bars"></i></div>
        <nav class="nav-links" id="nav-links">
            <a href="#home" class="active">Home</a>
            <a href="#dishes">Dishes</a>
            <a href="#menu">Menu</a>
            <a href="#about">About</a>
            <?php if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])): ?>
                <a href="track_order.php">Track Order</a>
            <?php endif; ?>
        </nav>
        <div class="nav-actions">
            <a href="cart.php" class="cart-icon-link">
                <i class="fas fa-shopping-cart"></i>
                <span class="cart-count"><?= $cart_count > 0 ? $cart_count : ''; ?></span>
            </a>
            <?php if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])): ?>
                <span class="user-greeting">Hello, <?= htmlspecialchars($_SESSION['user_name']); ?>!</span>
                <a href="logout.php" class="nav-btn logout">Logout</a>
            <?php else: ?>
                <a href="login.php" class="nav-btn login">Login</a>
                <a href="signup.php" class="nav-btn signup">Signup</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<script>
// Mobile Hamburger toggle
const hamburger = document.getElementById('hamburger');
const navLinks = document.getElementById('nav-links');
hamburger.addEventListener('click', () => navLinks.classList.toggle('active'));
</script>

<section class="hero" id="home">
    <div class="hero-overlay">
        <div class="hero-content">
            <h1>Fresh, Fast & Delicious Meals</h1>
            <p>Get your favourite dishes delivered right to your doorstep.</p>
            <a href="#menu" class="btn-hero">Order Now</a>
        </div>
    </div>
</section>

<section id="dishes">
    <h2 class="heading">Popular Dishes <span>Our Best Picks</span></h2>
    <div class="box-container">
        <?php while($dish = mysqli_fetch_assoc($popularDishes)): ?>
            <div class="box">
                <img src="uploads/<?= htmlspecialchars($dish['image']); ?>" alt="<?= htmlspecialchars($dish['title']); ?>">
                <h3><?= htmlspecialchars($dish['title']); ?></h3>
                <p><?= htmlspecialchars($dish['description']); ?></p>
                <span class="price-display">Ksh <?= number_format($dish['price']); ?></span>
                <form method="POST" action="add_to_cart.php">
                    <input type="hidden" name="dish_id" value="<?= $dish['id']; ?>">
                    <button class="btn">Add to Cart</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>
</section>

<section id="menu">
    <h2 class="heading">Today's Special <span>Our Menu</span></h2>
    <div class="box-container">
        <?php while($dish = mysqli_fetch_assoc($menuDishes)): ?>
            <div class="box">
                <img src="uploads/<?= htmlspecialchars($dish['image']); ?>" alt="<?= htmlspecialchars($dish['title']); ?>">
                <h3><?= htmlspecialchars($dish['title']); ?></h3>
                <p><?= htmlspecialchars($dish['description']); ?></p>
                <span class="price-display">Ksh <?= number_format($dish['price']); ?></span>
                <form method="POST" action="add_to_cart.php">
                    <input type="hidden" name="dish_id" value="<?= $dish['id']; ?>">
                    <button class="btn">Add to Cart</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>
</section>

<section id="about" class="about">
    <h2 class="heading">Why Choose Us <span>About Us</span></h2>
    <div class="row">
        <div class="image"><img src="uploads/pic1.jfif" alt="About Foodie"></div>
        <div class="content">
            <h3>Best Food in Town</h3>
            <p>We serve the best freshly prepared meals with high-quality ingredients.</p>
            <div class="icons-container">
                <div class="icons"><i class="fas fa-shipping-fast"></i><span>Fast Delivery</span></div>
                <div class="icons"><i class="fas fa-dollar-sign"></i><span>Affordable</span></div>
                <div class="icons"><i class="fas fa-headset"></i><span>24/7 Support</span></div>
            </div>
            <a href="#menu" class="btn btn-hero">Learn More</a>
        </div>
    </div>
</section>
</body>
</html>
