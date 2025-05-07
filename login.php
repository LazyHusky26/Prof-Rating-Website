<?php
session_start();
include('site_database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    $prof_query = "SELECT id, name, email, password FROM prof_login WHERE email = '$email'";
    $prof_result = mysqli_query($conn, $prof_query);

    $student_query = "SELECT id, name, email, password FROM student_login WHERE email = '$email'";
    $student_result = mysqli_query($conn, $student_query);

    if (mysqli_num_rows($prof_result) > 0) {
        $user = mysqli_fetch_assoc($prof_result);

        if (password_verify($password, $user['password'])) {
            $_SESSION['prof_id'] = $user['id'];
            $_SESSION['prof_name'] = $user['name'];
            header("Location: search_bar.php"); // Redirect to search_bar.php
            exit();
        } else {
            echo "<script>alert('Failed: Incorrect password.');</script>";
        }
    } elseif (mysqli_num_rows($student_result) > 0) {
        $user = mysqli_fetch_assoc($student_result);

        if (password_verify($password, $user['password'])) {
            $_SESSION['student_id'] = $user['id'];
            $_SESSION['student_name'] = $user['name'];
            header("Location: search_bar.php"); // Redirect to search_bar.php
            exit();
        } else {
            echo "<script>alert('Failed: Incorrect password.');</script>";
        }
    } else {
        echo "<script>alert('Failed: No user found with the provided email address.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>ProfRate - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="login.css" />
</head>
<body>
  <div class="stars-bg"></div>
  <div class="fog-overlay"></div>
  <div class="particles"></div>

  <nav class="navbar">
    <div class="logo">ProfRate 🚀</div>
    <div class="nav-links">
      <a href="#">Blog</a>
      <a href="#">Help</a>
      <a href="register.php" class="cta">Sign In</a>
    </div>
  </nav>

  <div class="login-container">
    <?php
    if (isset($_GET['error'])) {
        if ($_GET['error'] == 'user_not_found') {
            echo "<script>alert('⚠ No user found with the provided email address. Please check and try again.');</script>";
        } elseif ($_GET['error'] == 'invalid_password') {
            echo "<script>alert('⚠ Incorrect password. Please try again.');</script>";
        }
    }
    if (isset($_GET['success']) && $_GET['success'] == 1) {
        echo "<script>alert('🎉 Account successfully created! Please log in.');</script>";
    }
    ?>

    <form class="login-card animate-fade" method="POST" action="">
      <h2>Log In</h2>
      <p class="welcome-text">Welcome back! Please login to continue 🚀</p>
      <p class="signup">New to ProfRate? <a href="register.php">Sign up!</a></p>

      <input type="email" name="email" placeholder="Email Address" required />
      <input type="password" name="password" placeholder="Password" required />

      <div class="forgot">
        <a href="#">Forgot password?</a>
      </div>

      <button type="submit" class="login-btn">Log In</button>
    </form>
  </div>

  <div class="footer-quote">
    Empowering students, one review at a time ✨
  </div>

</body>
</html>
