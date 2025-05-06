<?php
include 'site_database.php'; // Include the database connection

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get the search query and toggle state
$query = isset($_GET['query']) ? mysqli_real_escape_string($conn, $_GET['query']) : '';
$searchType = isset($_GET['type']) ? $_GET['type'] : 'professors'; // Default to professors

if (!empty($query)) {
    if ($searchType === 'universities') {
        // Fetch unique universities matching the query
        $sql = "SELECT DISTINCT university FROM prof_login WHERE university LIKE '%$query%' LIMIT 10";
    } else {
        // Fetch professors matching the query
        $sql = "SELECT id, name, department, university FROM prof_login WHERE name LIKE '%$query%' LIMIT 10";
    }

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn)); // Debug: Log query errors
    }

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($searchType === 'universities') {
                // Display universities
                echo "<div class='result-item'>";
                echo "<strong>" . htmlspecialchars($row['university']) . "</strong>";
                echo "</div>";
            } else {
                // Display professors with a link to their profile
                echo "<div class='result-item' onclick=\"window.location.href='profile.php?id=" . $row['id'] . "'\">";
                echo "<strong>" . htmlspecialchars($row['name']) . "</strong><br>";
                echo "<small>" . htmlspecialchars($row['department']) . " - " . htmlspecialchars($row['university']) . "</small>";
                echo "</div>";
            }
        }
    } else {
        echo "<div class='result-item'>No results found</div>";
    }
} else {
    echo "<div class='result-item'>Please enter a search term</div>";
}

mysqli_close($conn);
?>