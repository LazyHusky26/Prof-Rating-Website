<?php
// Include database connection file
include('site_database.php');

// Get professor ID from the query string (e.g., profile.php?id=1)
$professor_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch professor details from the database
$sql = "SELECT name, department, university FROM prof_login WHERE id = $professor_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $professor = mysqli_fetch_assoc($result);
    $professor_name = $professor['name'];
    $department = $professor['department'];
    $university = $professor['university'];
} else {
    // Redirect to an error page if the professor is not found
    header("Location: error.php?error=professor_not_found");
    exit();
}

// Calculate the average rating for the professor
$avg_rating_sql = "SELECT COALESCE(AVG(rating), 0) AS avg_rating FROM prof_ratings WHERE prof_id = $professor_id";
$avg_rating_result = mysqli_query($conn, $avg_rating_sql);

if ($avg_rating_result && mysqli_num_rows($avg_rating_result) > 0) {
    $avg_rating_row = mysqli_fetch_assoc($avg_rating_result);
    $avg_rating = number_format($avg_rating_row['avg_rating'], 1); // Format to 1 decimal place
} else {
    $avg_rating = "0.0"; // Default value if no ratings exist
}

// Fetch rating distribution for the professor
$ratings_sql = "SELECT rating, COUNT(*) as count FROM prof_ratings WHERE prof_id = $professor_id GROUP BY rating ORDER BY rating DESC";
$ratings_result = mysqli_query($conn, $ratings_sql);

$rating_distribution = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
$total_ratings = 0;

while ($row = mysqli_fetch_assoc($ratings_result)) {
    $rating_distribution[$row['rating']] = $row['count'];
    $total_ratings += $row['count'];
}

// Calculate percentage for each rating
foreach ($rating_distribution as $rating => $count) {
    $rating_distribution[$rating] = $total_ratings > 0 ? ($count / $total_ratings) * 100 : 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professor Profile - Profrate</title>
    <link href="https://fonts.googleapis.com/css2?family=UnifrakturMaguntia&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            color: #e6bd09;
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow-x: hidden;
        }

        /* Profrate Navbar */
        .navbar {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            background-color: #000000;
            padding: 10px 20px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }

        .navbar a {
            text-decoration: none;
            color: #ffffff;
            font-size: 18px;
            margin-left: 50px;
        }

        .navbar a:hover {
            color: #fff;
        }

        .navbar .logo {
            font-size: 24px;
            font-weight: bold;
        }

        /* Professor Name */
        .professor-name {
            position: absolute;
            top: 100px;
            left: 20px;
            font-size: 70px;
            font-weight: bold;
            color: #ffffff;
        }
        .highlighted-name {
    color: #e6bd09;
}


        /* Rating */
        .professor-rating {
    position: absolute;
    top: 300px;
    left: 20px;
    font-size: 45px;
    color: #ffffff;
    font-family: 'UnifrakturMaguntia', cursive; /* updated font */
}
        .rating-number {
    font-size: 70px; /* Bigger size for just 4.0 */
    font-family: 'UnifrakturMaguntia', cursive; /* Same font */
}




        /* Department & University */
        .professor-info {
            position: absolute;
            top: 250px;
            left: 20px;
            font-size: 20px;
            color: #ffffff;
        }

        /* Rating Distribution */
        .rating-distribution {
            position: absolute;
            top: 120px;
            right: 40px;
            width: 650px;
        }

        .bar-container {
            display: flex;
            align-items: center;
            margin-bottom: 45px;
        }

        .bar-label {
            width: 50px;
            font-size: 18px;
            color: #ffffff;
        }

        .bar {
    height: 30px; /* Increased from 20px to 30px */
    background-color: #e6bd09;
    margin-left: 10px;
    border-radius: 10px;
    transition: width 0.8s ease-in-out;
}
.rate-button-container {
    position: absolute;
    top: 400px; /* Adjust as needed */
    left: 20px;
    margin-top: 20px;
}

.rate-button {
    display: inline-block;
    background-color: #e6bd09;
    color: black;
    font-size: 20px;
    font-weight: bold;
    padding: 12px 24px;
    text-decoration: none;
    border-radius: 8px;
    transition: background-color 0.3s ease;
    font-family: Arial, sans-serif;
}

.rate-button:hover {
    background-color: #d4aa00;
}

.review-section {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    width: 80%;
    background-color: #111;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
}

.review-section h2 {
    color: #e6bd09;
    font-family: Arial, sans-serif;
    margin-bottom: 20px;
}

.review-box {
    width: 90%;
    height: 100px;
    padding: 10px;
    font-size: 16px;
    border-radius: 8px;
    border: 2px solid #e6bd09; /* <-- Yellow border added here */
    resize: none;
    background-color: #2e2b2b;
    color: #fff;
}



.submit-review {
    margin-top: 15px;
    background-color: #e6bd09;
    color: black;
    font-size: 18px;
    font-weight: bold;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.submit-review:hover {
    background-color: #d4aa00;
}






        /* Hidden Content */
        .content {
            display: none;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">Profrate</div>
        <div>
            <a href="home.html">Home</a>
        </div>
    </div>

    <!-- Professor Name -->
    <div class="professor-name">
        Professor Name: <span class="highlighted-name"><?php echo htmlspecialchars($professor_name); ?></span>
    </div>
    

    <!-- Rating -->
    <div class="professor-rating">
        <span class="rating-number"><?php echo $avg_rating; ?></span> / 5
    </div>
    

    <!-- Department and University Info -->
    <div class="professor-info">
        <?php echo htmlspecialchars($professor_name); ?> works in the Department of <?php echo htmlspecialchars($department); ?> at <?php echo htmlspecialchars($university); ?>.
    </div>

    <div class="rate-button-container">
        <a href="rate_professor.php?id=<?php echo $professor_id; ?>" class="rate-button">Rate This Professor</a>
    </div>
    

    <!-- Rating Distribution -->
    <div class="rating-distribution">
        <?php foreach ($rating_distribution as $rating => $percentage): ?>
        <div class="bar-container">
            <div class="bar-label"><?php echo $rating; ?></div>
            <div class="bar" style="width: <?php echo $percentage; ?>%;"></div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Hidden Content -->
    <div class="content"></div>

    <div class="review-section">
        <h2>Leave a Review</h2>
        <form action="submit_review.php" method="POST">
            <textarea class="review-box" name="review" placeholder="Write your review here..." required></textarea>
            <input type="hidden" name="prof_id" value="<?php echo $professor_id; ?>">
            <br>
            <button type="submit" class="submit-review">Submit Review</button>
        </form>
    </div>
    

</body>

</html>
