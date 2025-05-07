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

// Calculate the total average rating for the professor from `prof_avg_ratings`
$avg_rating_sql = "SELECT COALESCE(AVG(avg_rating), 0) AS avg_rating FROM prof_avg_ratings WHERE prof_id = $professor_id";
$avg_rating_result = mysqli_query($conn, $avg_rating_sql);

if ($avg_rating_result && mysqli_num_rows($avg_rating_result) > 0) {
    $avg_rating_row = mysqli_fetch_assoc($avg_rating_result);
    $avg_rating = number_format($avg_rating_row['avg_rating'], 1); // Format to 1 decimal place
} else {
    $avg_rating = "0.0"; // Default value if no ratings exist
}

// Fetch rounded rating distribution for the professor
$ratings_sql = "SELECT rounded_rating, COUNT(*) as count FROM prof_avg_ratings WHERE prof_id = $professor_id GROUP BY rounded_rating ORDER BY rounded_rating DESC";
$ratings_result = mysqli_query($conn, $ratings_sql);

$rating_distribution = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
$total_ratings = 0;

while ($row = mysqli_fetch_assoc($ratings_result)) {
    $rating_distribution[$row['rounded_rating']] = $row['count'];
    $total_ratings += $row['count']; // Calculate total ratings
}

// Calculate percentage for each rating
foreach ($rating_distribution as $rating => $count) {
    $rating_distribution[$rating] = $total_ratings > 0 ? ($count / $total_ratings) * 100 : 0;
}

// Fetch reviews for the professor
$comments_sql = "SELECT comment FROM reviews WHERE prof_id = $professor_id ORDER BY created_at DESC";
$comments_result = mysqli_query($conn, $comments_sql);
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
        }

        /* Navbar */
        .navbar {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            background-color: #000000;
            padding: 10px 20px;
            width: 100%;
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

        /* Main Content */
        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Professor Name */
        .professor-name {
            font-size: 40px;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 20px;
        }

        .highlighted-name {
            color: #e6bd09;
        }

        /* Rating */
        .professor-rating {
            font-size: 30px;
            color: #ffffff;
            font-family: 'UnifrakturMaguntia', cursive;
            margin-bottom: 20px;
        }

        .rating-number {
            font-size: 50px;
            font-family: 'UnifrakturMaguntia', cursive;
        }

        .highlighted-rating {
            color: #e6bd09;
        }

        /* Department & University */
        .professor-info {
            font-size: 20px;
            color: #ffffff;
            margin-bottom: 20px;
        }

        .highlighted-department {
            color: #e6bd09;
            font-weight: bold;
        }

        .highlighted-university {
            color: #e6bd09;
            font-weight: bold;
        }

        /* Rating Distribution */
        .rating-distribution {
            margin-top: 40px;
        }

        .bar-container {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .bar-label {
            width: 50px;
            font-size: 18px;
            color: #ffffff;
        }

        .bar {
            height: 30px;
            background-color: #e6bd09;
            margin-left: 10px;
            border-radius: 10px;
            transition: width 0.8s ease-in-out;
        }

        /* Rate Button */
        .rate-button-container {
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

        /* Review Section */
        .review-section {
            margin-top: 40px;
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
            border: 2px solid #e6bd09;
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

        /* Reviews Section */
        .reviews-list {
            margin-top: 20px;
            background-color: #111;
            padding: 20px;
            border-radius: 10px;
            color: #e6bd09;
        }

        .reviews-list h2 {
            margin-bottom: 20px;
            font-family: Arial, sans-serif;
            text-align: center;
            color: #e6bd09;
        }

        .review-item {
            background-color: #222;
            margin-bottom: 15px;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .review-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.3);
        }

        .review-content {
            font-size: 16px;
            color: #fff;
            line-height: 1.5;
        }

        .review-item:last-child {
            margin-bottom: 0;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">Profrate</div>
        <div>
            <a href="search_bar.php">Home</a>
        </div>
    </div>

    <div class="main-content">
        <!-- Professor Name -->
        <div class="professor-name">
            Professor Name: <span class="highlighted-name"><?php echo htmlspecialchars($professor_name); ?></span>
        </div>

        <!-- Rating -->
        <div class="professor-rating">
            <span class="rating-number highlighted-rating"><?php echo $avg_rating; ?></span> / 5
        </div>

        <!-- Department and University Info -->
        <div class="professor-info">
            <span class="highlighted-name"><?php echo htmlspecialchars($professor_name); ?></span> works in the Department of 
            <span class="highlighted-department"><?php echo htmlspecialchars($department); ?></span> at 
            <span class="highlighted-university"><?php echo htmlspecialchars($university); ?></span>.
        </div>

        <!-- Rate Button -->
        <div class="rate-button-container">
            <a href="questions.php?id=<?php echo $professor_id; ?>" class="rate-button">Rate This Professor</a>
        </div>

        <!-- Rating Distribution -->
        <div class="rating-distribution">
            <h3>Rating Distribution (<?php echo $total_ratings; ?> Ratings)</h3>
            <?php foreach ($rating_distribution as $rating => $percentage): ?>
            <div class="bar-container">
                <div class="bar-label"><?php echo $rating; ?></div>
                <div class="bar" style="width: <?php echo $percentage; ?>%;"></div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Leave a Review Section -->
        <div class="review-section">
            <h2>Leave a Review</h2>
            <form action="submit_review.php" method="POST">
                <textarea class="review-box" name="review" placeholder="Write your review here..." required></textarea>
                <input type="hidden" name="prof_id" value="<?php echo $professor_id; ?>">
                <br>
                <button type="submit" class="submit-review">Submit Review</button>
            </form>
        </div>

        <!-- Reviews Section -->
        <div class="reviews-list">
            <h2>Reviews</h2>
            <?php if (mysqli_num_rows($comments_result) > 0): ?>
                <?php while ($comment = mysqli_fetch_assoc($comments_result)): ?>
                    <div class="review-item">
                        <div class="review-content">
                            <p><?php echo htmlspecialchars($comment['comment']); ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No reviews yet. Be the first to leave a review!</p>
            <?php endif; ?>
        </div>
    </div>

</body>

</html>
