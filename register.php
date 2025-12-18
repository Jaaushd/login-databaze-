<?php
include "connection.php";

$msg = ""; 

if(isset($_POST['submit'])){

    // zober správne polia
    $first = $_POST['name'];
    $last = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Skontroluj email
    $checkSql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $checkSql);

    if(mysqli_num_rows($result) > 0){
        $msg = "Email už existuje!";
    } else {

        // Uloženie do DB – OPRAVENÉ STĹPCE
        $sql = "INSERT INTO users(first_name, last_name, email, password) 
                VALUES('$first', '$last', '$email', '$password')";

        if(mysqli_query($conn, $sql)){
            // 🔥 PREsmerovanie na home.php po registrácii
            session_start();
            $_SESSION['user_name'] = $first;
            header("Location: home.php");
            exit;
        } 
        else {
            $msg = "Chyba pri registrácii!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="login-style.css">
    <title>Register</title>
</head>
<body>
  
    <div class="nav-button">
        <button class="btn" onclick="window.location='login.php'">Sign In</button>
        <button class="btn white-btn">Sign Up</button>
    </div>
<div class="form-box">

    

    <div class="register-container">
        <div class="top">
            <span>Have an account? <a href="login.php">Login</a></span>
            <header>Sign Up</header>
        </div>

        <?php if ($msg != ''): ?>
            <p class="msg"><?= $msg ?></p>
        <?php endif; ?>

        <form action="" method="POST">

            <div class="two-forms">
                <div class="input-box">
                    <input type="text" name="name" class="input-field"
                           placeholder="First name" required>
                </div>

                <div class="input-box">
                    <input type="text" name="last_name" class="input-field"
                           placeholder="Last name" required>
                </div>
            </div>

            <div class="input-box">
                <input type="email" name="email" class="input-field"
                       placeholder="Email" required>
            </div>

            <div class="input-box">
                <!-- 🔥 DOPLNENÉ ID KTORÉ CHÝBALO -->
                <input type="password" id="password" name="password" class="input-field"
                       placeholder="Password" required>
            </div>

            <div class="password-checklist" id="password-checklist" aria-hidden="true">
                <h3 class="checklist-title">Password should be</h3>
                  <div class="checklist-grid">
                    <ul class="checklist right-side">
                       <li id="length" class="list-item">At least 8 characters long</li>
                       <li id="number" class="list-item">At least 1 number</li>
                       <li id="lowercase" class="list-item">At least 1 lowercase letter</li>
                     </ul>
                        <ul class="checklist left-side">
                          <li id="uppercase" class="list-item">At least 1 uppercase letter</li>
                          <li id="special" class="list-item">At least 1 special character</li>
                        </ul>
                    </div>
              </div>

            <div class="input-box">
                <input type="submit" name="submit" class="submit" value="Register">
            </div>

        </form>
    </div>
</div>

<script>
    const loginBtn = document.getElementById("loginbtn");
    const registerBtn = document.getElementById("registerbtn");
    const loginForm = document.getElementById("login");
    const registerForm = document.getElementById("register");

    function login() {
      loginForm.style.left = "4px";
      registerForm.style.right = "-520px";
      loginBtn.classList.add("white-btn");
      registerBtn.classList.remove("white-btn");
    }

    function register(){
      loginForm.style.left = "-520px";
      registerForm.style.right = "4px";
      registerBtn.classList.add("white-btn");
      loginBtn.classList.remove("white-btn");
    }

    // Password validation + floating checklist
    const passwordInput = document.getElementById("password");
    const checklist = document.getElementById("password-checklist");
    const lengthItem = document.getElementById("length");
    const numberItem = document.getElementById("number");
    const lowercaseItem = document.getElementById("lowercase");
    const uppercaseItem = document.getElementById("uppercase");
    const specialItem = document.getElementById("special");

    passwordInput.addEventListener("focus", () => {
      checklist.classList.add("show");
      checklist.setAttribute('aria-hidden', 'false');
    });

    passwordInput.addEventListener("blur", () => {
      if (passwordInput.value === "") {
        checklist.classList.remove("show");
        checklist.setAttribute('aria-hidden', 'true');
      }
    });

    // Hide checklist after all conditions are valid
    passwordInput.addEventListener("input", () => {
      const value = passwordInput.value;
      const hasLength = value.length >= 8;
      const hasNumber = /[0-9]/.test(value);
      const hasLowercase = /[a-z]/.test(value);
      const hasUppercase = /[A-Z]/.test(value);
      const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(value);

      function update(item, condition) {
        item.classList.toggle("valid", condition);
        item.classList.toggle("invalid", !condition);
      }

      update(lengthItem, hasLength);
      update(numberItem, hasNumber);
      update(lowercaseItem, hasLowercase);
      update(uppercaseItem, hasUppercase);
      update(specialItem, hasSpecial);

      const allValid = hasLength && hasNumber && hasLowercase && hasUppercase && hasSpecial;

      if (allValid) {
        setTimeout(() => {
          checklist.classList.remove("show");
          checklist.setAttribute('aria-hidden', 'true');
        }, 300);
      } else {
        if (value.length > 0) {
          checklist.classList.add("show");
          checklist.setAttribute('aria-hidden', 'false');
        } else {
          checklist.classList.remove("show");
          checklist.setAttribute('aria-hidden', 'true');
        }
      }
    });

    // Block copy / cut / context menu
    passwordInput.addEventListener("copy", (e) => e.preventDefault());
    passwordInput.addEventListener("cut", (e) => e.preventDefault());
    passwordInput.addEventListener("contextmenu", (e) => e.preventDefault());
    passwordInput.addEventListener("selectstart", (e) => e.preventDefault());
    passwordInput.addEventListener("keydown", (e) => {
      if ((e.ctrlKey || e.metaKey) && (e.key === 'c' || e.key === 'C' || e.key === 'x' || e.key === 'X')) {
        e.preventDefault();
      }
    });
</script>

</body>
</html>
