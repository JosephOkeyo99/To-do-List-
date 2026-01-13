<?php
session_start();
include 'connection.php';

$message = '';
$messageType = ''; // success or error

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // First check admin
    $adminResult = mysqli_query($conn, "SELECT * FROM admins WHERE email='$email' LIMIT 1");
    if(mysqli_num_rows($adminResult) > 0) {
        $admin = mysqli_fetch_assoc($adminResult);
        if(password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['username'];
            header("Location: admin_dashboard.php");
            exit;
        } else {
            $message = "Incorrect password!";
            $messageType = 'error';
        }
    } else {
        // Check normal users
        $userResult = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' LIMIT 1");
        if(mysqli_num_rows($userResult) > 0) {
            $user = mysqli_fetch_assoc($userResult);
            if(password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                header("Location: index.php");
                exit;
            } else {
                $message = "Incorrect password!";
                $messageType = 'error';
            }
        } else {
            $message = "Email not registered!";
            $messageType = 'error';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - Foodie</title>
<style>
/* Reset & base */
* { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
body { background: linear-gradient(135deg, #fff6f3, #fff); display:flex; justify-content:center; align-items:center; min-height:100vh; }

/* Login box */
.login-container { background:#fff; padding:3rem 2.5rem; border-radius:1rem; box-shadow:0 1rem 2rem rgba(0,0,0,0.1); width:36rem; max-width:90%; text-align:center; animation:fadeIn 0.7s ease-in-out; }
@keyframes fadeIn { from { opacity:0; transform:translateY(10px);} to { opacity:1; transform:translateY(0);} }

.login-container h1 { font-size:2.2rem; margin-bottom:0.5rem; color:#333; letter-spacing:0.5px; }
.login-container p.subtitle { font-size:1.1rem; color:#ff523b; margin-bottom:1.8rem; }

/* Messages */
.message { margin-bottom:1.2rem; font-size:1rem; padding:0.8rem; border-radius:0.5rem; }
.message.error { color:#b00020; background:#ffe6e6; }
.message.success { color:#0f5132; background:#d1e7dd; }

/* Form styling */
.login-container form { display:flex; flex-direction:column; gap:1.3rem; }
.login-container input { padding:1rem 0.8rem; font-size:1rem; border:1px solid #ddd; border-radius:0.5rem; outline:none; transition:all 0.3s ease; }
.login-container input:focus { border-color:#ff523b; box-shadow:0 0.4rem 0.8rem rgba(255,82,59,0.15); }

/* Button */
.login-container .btn-login { padding:1rem; font-size:1.1rem; background:#ff523b; color:#fff; border-radius:0.5rem; cursor:pointer; font-weight:600; text-transform:uppercase; transition:all 0.3s ease; border:none; }
.login-container .btn-login:hover { background:#ff744e; transform:translateY(-2px); box-shadow:0 0.6rem 1.2rem rgba(255,82,59,0.25); }

/* Signup link */
.login-container .signup-link { margin-top:1.2rem; font-size:1rem; color:#333; }
.login-container .signup-link a { color:#0066ff; text-decoration:none; font-weight:500; }
.login-container .signup-link a:hover { text-decoration:underline; }

/* Responsive */
@media(max-width:768px){
    .login-container { padding:2.5rem 2rem; width:90%; }
    .login-container h1 { font-size:1.8rem; }
    .login-container p.subtitle { font-size:1rem; }
    .login-container input { font-size:0.95rem; }
    .login-container .btn-login { font-size:1rem; }
}
</style>
</head>
<body>

<section class="login-container">
    <h1>Welcome Back</h1>
    <p class="subtitle">Access Your Foodie Account 🍴</p>

    <?php if($message): ?>
        <p class="message <?= $messageType ?>"><?= $message ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login" class="btn-login">Login</button>
    </form>

    <p class="signup-link">Don't have an account? <a href="signup.php">Sign up here</a></p>
</section>

</body>
</html>
