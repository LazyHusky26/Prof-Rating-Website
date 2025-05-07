<?php
include('site_database.php'); // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prof_id = intval($_POST['prof_id']); // Get the professor ID from the form
    $comment = mysqli_real_escape_string($conn, $_POST['review']); // Sanitize the review text

    // Insert the review into the database
    $sql = "INSERT INTO reviews (prof_id, comment) VALUES ($prof_id, '$comment')";
    if (mysqli_query($conn, $sql)) {
        // Redirect back to the professor's profile page
        header("Location: profile.php?id=$prof_id");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>