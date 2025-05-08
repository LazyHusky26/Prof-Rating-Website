<?php
include("site_database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $confirmPassword = filter_input(INPUT_POST, "confirmPassword", FILTER_SANITIZE_SPECIAL_CHARS);
    $userType = filter_input(INPUT_POST, "userType", FILTER_SANITIZE_SPECIAL_CHARS);

    // Handle file upload for student
    $student_id_name = "";
    if ($userType === "student") {
        $student_id_name = $_FILES['studentIdUpload']['name'];
        $student_id_tmp = $_FILES['studentIdUpload']['tmp_name'];
        $upload_dir = "uploads/";
        $upload_path = $upload_dir . basename($student_id_name);

        if (!move_uploaded_file($student_id_tmp, $upload_path)) {
            echo "<script>alert('⚠ Failed to upload student ID image.');</script>";
        }
    }

    // Handle file upload for professor
    $professor_doc_name = "";
    if ($userType === "professor") {
        $professor_doc_name = $_FILES['professorDocUpload']['name'];
        $professor_doc_tmp = $_FILES['professorDocUpload']['tmp_name'];
        $upload_dir = "uploads/";
        $upload_path = $upload_dir . basename($professor_doc_name);

        if (!move_uploaded_file($professor_doc_tmp, $upload_path)) {
            echo "<script>alert('⚠ Failed to upload professor verification document.');</script>";
        }
    }

    // Process password and confirm password
    if (!empty($password) && $password === $confirmPassword) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // Check for duplicate email
        $check_query = "SELECT * FROM " . ($userType === "student" ? "student_login" : "prof_login") . " WHERE email = '$email'";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            echo "<script>alert('⚠ Email already exists. Please use a different email.');</script>";
        } else {
            // Prepare SQL query based on user type
            if ($userType === "student") {
                $sql = "INSERT INTO student_login (name, email, password, student_id) VALUES ('$name', '$email', '$hash', '$student_id_name')";
            } else if ($userType === "professor") {
                $universityName = filter_input(INPUT_POST, "universityName", FILTER_SANITIZE_SPECIAL_CHARS);
                $department = filter_input(INPUT_POST, "department", FILTER_SANITIZE_SPECIAL_CHARS); // New department field
                $sql = "INSERT INTO prof_login (name, email, password, university, department, veri_doc) 
                        VALUES ('$name', '$email', '$hash', '$universityName', '$department', '$professor_doc_name')";
            }

            // Execute query
            if (mysqli_query($conn, $sql)) {
                header("Location: login.php?registered=1");
                exit();
            } else {
                echo "<script>alert('⚠ Registration failed. Please try again.');</script>";
            }
        }
    } else {
        echo "<script>alert('⚠ Passwords do not match or are empty.');</script>";
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
            min-height: 100vh; /* Ensure the body takes the full viewport height */
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .container {
            background: #222;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(255, 215, 0, 0.5);
            width: 90%; /* Make it responsive */
            max-width: 600px; /* Limit the maximum width */
            text-align: center;
            box-sizing: border-box;
        }
        h2 {
            color: #FFD700;
            margin-bottom: 20px;
            font-size: 35px;
            font-weight: bold;
        }
        input, select {
            width: 100%; /* Adjust width to fit container */
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
            width: 100%; /* Adjust width to fit container */
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
            width: 100%; /* Adjust width to fit container */
            display: inline-block;
        }
        .student-id-upload-container {
            margin: 15px 0;
            text-align: center;
        }
        .toggle-switch {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 5px;
            flex-direction: column;
        }
        .toggle-label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 30px;
            margin: 0 10px;
        }
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            background-color: #ccc;
            border-radius: 34px;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            transition: 0.4s;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            left: 4px;
            bottom: 4px;
            background-color: black;
            transition: 0.4s;
            border-radius: 50%;
        }
        input:checked + .slider {
            background-color: #FFD700;
        }
        input:checked + .slider:before {
            transform: translateX(30px);
        }
        .upload-label {
            text-align: left;
            color: #FFD700;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<?php if (isset($_GET['success'])): ?>
    <script>alert("🎉 Registration Successful!");</script>
<?php endif; ?>

<div class="container">
    <!-- Register as label and toggle switch -->
    <div class="toggle-switch">
        <span class="toggle-label">Register as:</span>
        <div style="display: flex; justify-content: space-between; width: 100%;">
            <span>Student</span>
            <label class="switch">
                <input type="checkbox" id="userTypeToggle">
                <span class="slider"></span>
            </label>
            <span>Professor</span>
        </div>
    </div>

    <h2>Create an Account</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="registerForm" enctype="multipart/form-data">
        <input type="hidden" id="hiddenUserType" name="userType" value="student">

        <input type="text" id="name" name="name" placeholder="Full Name" required>
        <div class="error" id="nameError"></div>

        <input type="email" id="email" name="email" placeholder="Email" required>
        <div class="error" id="emailError"></div>

        <input type="password" id="password" name="password" placeholder="Password" required>
        <div class="error" id="passwordError"></div>

        <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
        <div class="error" id="confirmError"></div>

        <!-- Student Section -->
        <div class="student-id-upload-container" id="studentIdSection">
            <label for="studentIdUpload" class="upload-label">Upload Student ID</label>
            <input type="file" id="studentIdUpload" name="studentIdUpload" accept="image/*" required>
            <div class="error" id="studentIdError"></div>
        </div>

        <!-- Professor Section -->
        <div class="student-id-upload-container" id="professorDocSection" style="display: none;">
            <input type="text" id="universityName" name="universityName" placeholder="University Name" required>
            <div class="error" id="universityError"></div>

            <input type="text" id="department" name="department" placeholder="Department" required> <!-- New department input -->
            <div class="error" id="departmentError"></div>

            <label for="professorDocUpload" class="upload-label">Verification Document</label>
            <input type="file" id="professorDocUpload" name="professorDocUpload" accept=".pdf,.doc,.docx,image/*" required>
            <div class="error" id="professorDocError"></div>
        </div>

        <button type="submit">Register</button>
    </form>
</div>

<script>
document.getElementById("userTypeToggle").addEventListener("change", function () {
    const isProfessor = this.checked;
    const studentSection = document.getElementById("studentIdSection");
    const professorSection = document.getElementById("professorDocSection");
    const hiddenType = document.getElementById("hiddenUserType");

    // Get all relevant fields
    const studentIdUpload = document.getElementById("studentIdUpload");
    const universityName = document.getElementById("universityName");
    const department = document.getElementById("department");
    const professorDocUpload = document.getElementById("professorDocUpload");

    if (isProfessor) {
        studentSection.style.display = "none";
        professorSection.style.display = "block";
        hiddenType.value = "professor";
        // Set required for professor fields
        universityName.required = true;
        department.required = true;
        professorDocUpload.required = true;
        // Remove required from student field
        studentIdUpload.required = false;
    } else {
        studentSection.style.display = "block";
        professorSection.style.display = "none";
        hiddenType.value = "student";
        // Set required for student field
        studentIdUpload.required = true;
        // Remove required from professor fields
        universityName.required = false;
        department.required = false;
        professorDocUpload.required = false;
    }
});
</script>

</body>
</html>
