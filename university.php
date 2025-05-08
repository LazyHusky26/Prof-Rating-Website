<?php
// filepath: c:\xampp\htdocs\Learning\SE_Project\university.php
include('site_database.php');

// Get the university name from the URL
$university_name = isset($_GET['university']) ? mysqli_real_escape_string($conn, $_GET['university']) : '';

if (empty($university_name)) {
    die("Invalid university name.");
}

// Fetch professors in the specific university
$professors_query = "SELECT id, name FROM prof_login WHERE university = '$university_name'";
$professors_result = mysqli_query($conn, $professors_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professors at <?php echo htmlspecialchars($university_name); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
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
            font-family: 'Poppins', sans-serif;
        }

        /* Main Content */
        .main-content {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background: #111;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
            color: #e6bd09;
            margin-bottom: 30px;
            font-family: 'Poppins', sans-serif; /* Match the font of "ProfRate" */
            font-weight: 600;
        }

        .professor-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            list-style: none;
            padding: 0;
        }

        .professor-card {
            background: #222;
            color: #e6bd09;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .professor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.3);
        }

        .professor-card a {
            text-decoration: none;
            color: #e6bd09;
            font-weight: bold;
            font-size: 18px;
        }

        .professor-card a:hover {
            text-decoration: underline;
        }

        .no-professors {
            text-align: center;
            font-size: 18px;
            color: #fff;
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

    <!-- Main Content -->
    <div class="main-content">
        <h1>Professors at <?php echo htmlspecialchars($university_name); ?></h1>
        <ul class="professor-list">
            <?php if (mysqli_num_rows($professors_result) > 0): ?>
                <?php while ($professor = mysqli_fetch_assoc($professors_result)): ?>
                    <li class="professor-card">
                        <a href="profile.php?id=<?php echo $professor['id']; ?>" style="display: block; text-decoration: none;">
                            <div>
                                <?php echo htmlspecialchars($professor['name']); ?>
                            </div>
                        </a>
                    </li>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="no-professors">No professors found for this university.</p>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>