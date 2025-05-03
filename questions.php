<?php
// Include database connection
include('site_database.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prof_id = intval($_POST['prof_id']);
    $ratings = $_POST['ratings']; // Array of question_id => rating

    // Prepare the SQL query
    $sql = "INSERT INTO prof_ratings (prof_id, question_id, rating, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);

    // Insert each rating into the database
    foreach ($ratings as $question_id => $rating) {
        $stmt->bind_param("iii", $prof_id, $question_id, $rating);
        $stmt->execute();
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Redirect to the professor's profile page with a success message
    header("Location: profile.php?id=$prof_id&success=1");
    exit();
}

// Get professor ID from the query string
$professor_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch questions from the database
$questions_sql = "SELECT question_id, question_text FROM questions";
$questions_result = mysqli_query($conn, $questions_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professor Rating - Questionnaire</title>
    <style>
       body {
  font-family: Arial, sans-serif;
  background-color: #000;
  color: #cccccc;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 20px;
  overflow-y: auto; /* Allows scrolling if needed */
  height: 100vh;
  background-image: url('https://img.freepik.com/premium-photo/abstract-yellow-black-gradient-plain-studio-background_570543-10544.jpg'); /* Use relative path */
  background-size: cover; /* Ensures the image covers the entire background */
  background-position: center; /* Centers the image */
  background-attachment: fixed; /* Keeps the background fixed when scrolling */
}



        h2 {
            font-size: 5vw;
            text-align: center;
            margin-bottom: 30px;
            width: 90%;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .question {
            width: 100%;
            max-width: 1200px; /* Allows expansion on large screens */
            margin-bottom: 50px;
            padding: 30px;
        }

        .question label {
            display: block;
            font-size: min(3vw, 24px); /* Scales dynamically but caps at 24px */
            margin-bottom: 15px;
            word-wrap: break-word;
            overflow-wrap: break-word;
            white-space: normal; /* Ensures text wraps properly */
            width: 100%; /* Makes sure label uses full width */
        }

        .rating {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .rating label {
            font-size: 1vw; /* Smaller than the question */
        }

        .rating input {
            margin-right: 10px;
        }

        button {
            width: 100%;
            max-width: 600px;
            padding: 15px;
            background: #FFD700;
            color: #000;
            border: none;
            border-radius: 5px;
            font-size: 2.5vw;
            cursor: pointer;
            font-weight: bold;
            margin-top: 30px;
        }

        button:hover {
            background: #FFC000;
        }

        /* Navigation Bar */
        nav {
            background-color: rgba(0, 0, 0, 0.8);
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            padding: 20px;
        }

        nav .logo {
            font-size: 24px;
            font-weight: 600;
            color: #fff;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav>
        <div class="logo">ProfRate</div>
    </nav>

    <h2>Professor Rating Questionnaire</h2>

    <form action="submit_ratings.php" method="POST">
        <input type="hidden" name="prof_id" value="<?php echo $professor_id; ?>">

        <?php while ($question = mysqli_fetch_assoc($questions_result)): ?>
            <div class="question">
                <label><?php echo htmlspecialchars($question['question_text']); ?></label>
                <div class="rating">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <label>
                            <input type="radio" name="ratings[<?php echo $question['question_id']; ?>]" value="<?php echo $i; ?>" required>
                            <?php echo $i; ?>
                        </label>
                    <?php endfor; ?>
                </div>
            </div>
        <?php endwhile; ?>

        <button type="submit">Submit</button>
    </form>

    <script>
        // JavaScript function to deselect the radio button on double-click
        function deselectRadio(radioButton) {
            if (radioButton.checked) {
                radioButton.checked = false; // Uncheck the radio button
            }
        }
    </script>

</body>
</html>
