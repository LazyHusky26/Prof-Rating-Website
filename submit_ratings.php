<?php
session_start();
include 'site_database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prof_id = intval($_POST['prof_id']);

    if (!isset($_SESSION['student_id'])) {
        die("You must be logged in to rate a professor.");
    }
    $student_id = $_SESSION['student_id'];

    if ($prof_id <= 0) {
        die("Invalid professor ID.");
    }

    $ratings = [
        $_POST['teachingStyle'],
        $_POST['answeringQuestions'],
        $_POST['workload'],
        $_POST['examBasedOn'],
        $_POST['approachability'],
        $_POST['respect'],
        $_POST['assignments'],
        $_POST['feedback'],
        $_POST['classTimeliness'],
        $_POST['academicGrowth'],
        $_POST['recommendation']
    ];

    $avg_rating = round(array_sum($ratings) / count($ratings), 2);
    $rounded_rating = round($avg_rating);

    $query = "
        INSERT INTO prof_avg_ratings (prof_id, student_id, avg_rating, rounded_rating)
        VALUES ($prof_id, $student_id, $avg_rating, $rounded_rating)
        ON DUPLICATE KEY UPDATE
        avg_rating = $avg_rating, 
        rounded_rating = $rounded_rating,
        updated_at = CURRENT_TIMESTAMP;
    ";

    if (mysqli_query($conn, $query)) {
        echo "Thank you for your feedback!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
