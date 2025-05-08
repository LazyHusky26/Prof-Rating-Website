<?php
include('site_database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if ($new_password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Check if the email exists in the professor table
        $prof_query = "SELECT id FROM prof_login WHERE email = '$email'";
        $prof_result = mysqli_query($conn, $prof_query);

        if (mysqli_num_rows($prof_result) > 0) {
            $update_query = "UPDATE prof_login SET password = '$hashed_password' WHERE email = '$email'";
            if (mysqli_query($conn, $update_query)) {
                header("Location: login.php?success=1");
                exit();
            } else {
                $error = "Error updating password for professor.";
            }
        } else {
            // Check if the email exists in the student table
            $student_query = "SELECT id FROM student_login WHERE email = '$email'";
            $student_result = mysqli_query($conn, $student_query);

            if (mysqli_num_rows($student_result) > 0) {
                $update_query = "UPDATE student_login SET password = '$hashed_password' WHERE email = '$email'";
                if (mysqli_query($conn, $update_query)) {
                    header("Location: login.php?success=1");
                    exit();
                } else {
                    $error = "Error updating password for student.";
                }
            } else {
                $error = "No user found with the provided email.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #000;
            color: #FFD700;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .container {
            background: #222;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(255, 215, 0, 0.5);
            width: 90%;
            max-width: 600px;
            text-align: center;
            box-sizing: border-box;
        }
        h2 {
            color: #FFD700;
            margin-bottom: 20px;
            font-size: 35px;
            font-weight: bold;
        }
        p {
            color: #FFD700;
            margin-bottom: 20px;
            font-size: 16px;
        }
        input {
            width: 100%;
            height: 45px;
            padding: 10px;
            margin: 8px 0;
            border: 2px solid #FFD700;
            border-radius: 5px;
            background: #333;
            color: #FFD700;
            font-size: 16px;
            box-sizing: border-box;
        }
        input::placeholder {
            color: #bbb;
        }
        button {
            width: 100%;
            height: 50px;
            background: #FFD700;
            color: #000;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px;
        }
        button:hover {
            background: #FFC000;
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .back-to-login {
            margin-top: 15px;
        }
        .back-to-login a {
            color: #FFD700;
            text-decoration: none;
            font-weight: bold;
        }
        .back-to-login a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reset Your Password</h2>
        <p>Enter your email and new password below:</p>

        <?php if (isset($error)): ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="new_password" placeholder="New Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit">Reset Password</button>
        </form>

        <p class="back-to-login">
            <a href="login.php">Back to Login</a>
        </p>
    </div>
</body>
</html>