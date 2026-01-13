<?php
include 'connection.php';
session_start();
$message = '';
$messageType = ''; // success or error

if (isset($_POST['signup'])) {
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Check for duplicates & validation
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $message = "Email already registered!";
        $messageType = "error";
    } elseif ($password !== $confirm_password) {
        $message = "Passwords do not match!";
        $messageType = "error";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $insert = mysqli_query($conn, "INSERT INTO users (name, email, password) VALUES ('$name','$email','$hashed')");
        if ($insert) {
            $message = "Signup successful! You can now <a href='login.php'>login</a>.";
            $messageType = "success";
        } else {
            $message = "Something went wrong. Please try again!";
            $messageType = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Signup - Foodie</title>
<style>
/* Reset & base styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    background: linear-gradient(135deg, #fff6f3, #fff);
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

/* Signup box */
.signup-container {
    background: #fff;
    padding: 3rem 2.5rem;
    border-radius: 1rem;
    box-shadow: 0 1rem 2rem rgba(0,0,0,0.1);
    width: 36rem;
    max-width: 90%;
    text-align: center;
    animation: fadeIn 0.7s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Header */
.signup-container h1 {
    font-size: 2.2rem;
    margin-bottom: 0.5rem;
    color: #333;
    letter-spacing: 0.5px;
}

.signup-container p.subtitle {
    font-size: 1.1rem;
    color: #ff523b;
    margin-bottom: 1.8rem;
}

/* Messages */
.message {
    margin-bottom: 1.2rem;
    font-size: 1rem;
    padding: 0.8rem;
    border-radius: 0.5rem;
}
.message.error {
    color: #b00020;
    background: #ffe6e6;
}
.message.success {
    color: #0f5132;
    background: #d1e7dd;
}

/* Form styling */
.signup-container form {
    display: flex;
    flex-direction: column;
    gap: 1.3rem;
}

.signup-container input {
    padding: 1rem 0.8rem;
    font-size: 1rem;
    border: 1px solid #ddd;
    border-radius: 0.5rem;
    outline: none;
    transition: all 0.3s ease;
}

.signup-container input:focus {
    border-color: #ff523b;
    box-shadow: 0 0.4rem 0.8rem rgba(255,82,59,0.15);
}

/* Button */
.signup-container .btn-signup {
    padding: 1rem;
    font-size: 1.1rem;
    background: #ff523b;
    color: #fff;
    border-radius: 0.5rem;
    cursor: pointer;
    font-weight: 600;
    text-transform: uppercase;
    transition: all 0.3s ease;
    border: none;
}

.signup-container .btn-signup:hover {
    background: #ff744e;
    transform: translateY(-2px);
    box-shadow: 0 0.6rem 1.2rem rgba(255,82,59,0.25);
}

/* Login link */
.signup-container .login-link {
    margin-top: 1.2rem;
    font-size: 1rem;
    color: #333;
}

.signup-container .login-link a {
    color: #0066ff;
    text-decoration: none;
    font-weight: 500;
}

.signup-container .login-link a:hover {
    text-decoration: underline;
}

/* Responsive */
@media(max-width:768px){
    .signup-container {
        padding: 2.5rem 2rem;
        width: 90%;
    }
    .signup-container h1 {
        font-size: 1.8rem;
    }
    .signup-container p.subtitle {
        font-size: 1rem;
    }
    .signup-container input {
        font-size: 0.95rem;
    }
    .signup-container .btn-signup {
        font-size: 1rem;
    }
}
</style>
</head>
<body>

<section class="signup-container">
    <h1>Create Account</h1>
    <p class="subtitle">Join Foodie Today 🍴</p>

    <?php if($message): ?>
        <p class="message <?= $messageType ?>"><?= $message ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required minlength="6">
        <input type="password" name="confirm_password" placeholder="Confirm Password" required minlength="6">
        <button type="submit" name="signup" class="btn-signup">Sign Up</button>
    </form>

    <p class="login-link">Already have an account? <a href="login.php">Login here</a></p>
</section>

</body>
</html>
