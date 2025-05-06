<?php
include 'site_database.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$query = isset($_GET['query']) ? mysqli_real_escape_string($conn, $_GET['query']) : '';
$searchType = isset($_GET['type']) ? $_GET['type'] : 'professors';

if (!empty($query)) {
    if ($searchType === 'universities') {
        $sql = "SELECT DISTINCT university FROM prof_login WHERE university LIKE '%$query%' LIMIT 10";
    } else {
        $sql = "SELECT id, name, department, university FROM prof_login WHERE name LIKE '%$query%' LIMIT 10";
    }

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($searchType === 'universities') {
                echo "<div class='result-item'>";
                echo "<strong>" . htmlspecialchars($row['university']) . "</strong>";
                echo "</div>";
            } else {
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
