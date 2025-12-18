<?php
include("connection.php");
session_start();

$msg = '';

if (isset($_POST['submit'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $run = mysqli_query($conn, $query);

    if (mysqli_num_rows($run) > 0) {

        $user = mysqli_fetch_assoc($run);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['first_name'];

        header("Location: home.php");
        exit;
    } else {
        $msg = "Incorrect email or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <meta charset="UTF-8"/>
  <link rel="stylesheet" href="login-style.css"/>
  <title>Login</title>
</head>

<body>
      <div class="nav-button">
              <button class="btn white-btn" onclick="window.location='login.php'">Sign In</button>
              <button class="btn" onclick="window.location='register.php'">Sign Up</button>
      </div>

<div class="form-box">

    <div class="login-container">

        <div class="top">
            <header>Login</header>
            <span>No account? <a href="register.php">Sign Up</a></span>
        </div>

        <?php if ($msg != ''): ?>
            <p class="msg"><?= $msg ?></p>
        <?php endif; ?>

        <form action="" method="POST">

            <div class="input-box">
                <input type="text" name="email" class="input-field"
                       placeholder="Email" required>
            </div>

            <div class="input-box">
                <input type="password" name="password" class="input-field"
                       placeholder="Password" required>
            </div>

            <div class="input-box">
                <input type="submit" name="submit" class="submit" value="Sign In">
            </div>

        </form>

    </div>

</div>
</body>
</html>
