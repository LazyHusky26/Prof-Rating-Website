<?php
include("site_database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $confirmPassword = filter_input(INPUT_POST, "confirmPassword", FILTER_SANITIZE_SPECIAL_CHARS);

    $student_id_name = $_FILES['studentIdUpload']['name'];
    $student_id_tmp = $_FILES['studentIdUpload']['tmp_name'];

    $upload_dir = "uploads/";
    $upload_path = $upload_dir . basename($student_id_name);

    if (move_uploaded_file($student_id_tmp, $upload_path)) {
        if (!empty($password)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO student_login (name, email, password, student_id) 
                    VALUES ('$name', '$email', '$hash', '$student_id_name')";
            if (mysqli_query($conn, $sql)) {
                header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
                exit();
            }
        }
    } else {
        echo "<script>alert('⚠ Failed to upload image.');</script>";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Professor Rating</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            color: #FFD700;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #222;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(255, 215, 0, 0.5);
            width: 600px;
            text-align: center;
        }
        h2 {
            color: #FFD700;
            margin-bottom: 20px;
            font-size: 35px; 
            font-weight: bold;
        }
        input {
            width: 90%;
            height: 45px;
            padding: 10px;
            margin: 8px 0;
            border: 2px solid #FFD700;
            border-radius: 5px;
            background: #333;
            color: #FFD700;
            font-size: 16px;
        }
        input::placeholder {
            color: #bbb;
        }
        button {
            width: 90%;
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
        .error {
            color: red;
            font-size: 13px;
            margin-bottom: 5px;
            text-align: left;
            width: 90%;
            display: inline-block;
        }
        .student-id-upload-container {
            margin: 15px 0;
            text-align: center;
        }
        .student-id-preview {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border: 2px solid #FFD700;
            display: block;
            margin: auto;
        }
    </style>
</head>
<body>

<?php if (isset($_GET['success'])): ?>
    <script>alert("🎉 Registration Successful!");</script>
<?php endif; ?>

<div class="container">
    <h2>Create an Account</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="registerForm" enctype="multipart/form-data">
        <input type="text" id="name" name="name" placeholder="Full Name" required>
        <div class="error" id="nameError"></div>

        <input type="email" id="email" name="email" placeholder="Email" required>
        <div class="error" id="emailError"></div>

        <input type="password" id="password" name="password" placeholder="Password" required>
        <div class="error" id="passwordError"></div>

        <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
        <div class="error" id="confirmError"></div>

        <div class="student-id-upload-container">
            <label for="studentIdUpload" style="color: #FFD700; font-weight: bold;">Upload Student ID</label>
            <input type="file" id="studentIdUpload" name="studentIdUpload" accept="image/*" required>
            <div class="error" id="studentIdError"></div>
        </div>

        <button type="submit">Register</button>
    </form>
</div>

<script>
document.getElementById("registerForm").addEventListener("submit", function(event) {
    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value.trim();
    let confirmPassword = document.getElementById("confirmPassword").value.trim();
    let studentIdUpload = document.getElementById("studentIdUpload").files[0];

    let nameError = document.getElementById("nameError");
    let emailError = document.getElementById("emailError");
    let passwordError = document.getElementById("passwordError");
    let confirmError = document.getElementById("confirmError");
    let studentIdError = document.getElementById("studentIdError");

    nameError.textContent = "";
    emailError.textContent = "";
    passwordError.textContent = "";
    confirmError.textContent = "";
    studentIdError.textContent = "";

    let valid = true;
    let emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    let passwordRegex = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,}$/;

    if (name.length < 3) {
        nameError.textContent = "⚠ Name must be at least 3 characters.";
        valid = false;
    }

    if (!emailRegex.test(email)) {
        emailError.textContent = "⚠ Enter a valid email.";
        valid = false;
    }

    if (!passwordRegex.test(password)) {
        passwordError.textContent = "⚠ Password must be at least 6 characters, include a number & special character.";
        valid = false;
    }

    if (password !== confirmPassword) {
        confirmError.textContent = "⚠ Passwords do not match.";
        valid = false;
    }

    if (!studentIdUpload) {
        studentIdError.textContent = "⚠ Please upload a picture of your student ID.";
        valid = false;
    }

    if (!valid) {
        event.preventDefault();
    }
});

document.getElementById("studentIdUpload").addEventListener("change", function(event) {
    const file = event.target.files[0];
    if (file && file.type.startsWith('image')) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.querySelector('.student-id-preview');
            if (preview) {
                preview.src = e.target.result;
            } else {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('student-id-preview');
                document.querySelector('.student-id-upload-container').appendChild(img);
            }
        };
        reader.readAsDataURL(file);
    } else {
        alert("⚠ Please upload a valid image file.");
    }
});
</script>

</body>
</html>
