<?php
// Include database connection file
include('site_database.php');  // Include the connection to your database

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the email and password from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Sanitize inputs to prevent SQL injection
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // Query to find user with the provided email
    $sql = "SELECT id, name, email, password, university, veri_doc, reg_date FROM prof_login WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    // Check if a user with the provided email exists
    if (mysqli_num_rows($result) > 0) {
        // User found, fetch the user data
        $user = mysqli_fetch_assoc($result);

        // Verify the password (assuming it's hashed)
        if (password_verify($password, $user['password'])) {
            // Successful login
            session_start();
            $_SESSION['user_id'] = $user['id'];  // Store user ID in session
            $_SESSION['user_name'] = $user['name'];  // Store user name in session

            // Redirect to dashboard or home page
            header("Location: dashboard.php");
            exit();
        } else {
            // Invalid password
            header("Location: test.php?error=invalid_password");
            exit();
        }
    } else {
        // No user found with this email
        header("Location: test.php?error=user_not_found");
        exit();
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
      <a href="#" class="cta">Sign In</a>
    </div>
  </nav>

  <div class="login-container">
    <?php
    // Display error messages based on the query parameter
    if (isset($_GET['error'])) {
        if ($_GET['error'] == 'user_not_found') {
            echo "<script>alert('⚠ No user found with the provided email address. Please check and try again.');</script>";
        } elseif ($_GET['error'] == 'invalid_password') {
            echo "<script>alert('⚠ Incorrect password. Please try again.');</script>";
        }
    }
    ?>

    <form class="login-card animate-fade" method="POST" action="">
      <h2>Log In</h2>
      <p class="welcome-text">Welcome back! Please login to continue 🚀</p>
      <p class="signup">New to ProfRate? <a href="#">Sign up!</a></p>

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
