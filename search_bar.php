<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | ProfRate</title>
    <link rel="stylesheet" href="search_bar.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <!-- Navigation Bar -->
    <header>
        <div class="logo">ProfRate 🚀</div>
        <div class="auth-buttons">
            <?php if (isset($_SESSION['prof_id']) || isset($_SESSION['student_id'])): ?>
                <!-- Logout Button -->
                <button class="logout" onclick="window.location.href='logout.php'">Logout</button>
            <?php else: ?>
                <!-- Login and Get Started Buttons -->
                <button class="login" onclick="window.location.href='login.php'">Log In</button>
                <button class="signup" onclick="window.location.href='register.php'">Get Started</button>
            <?php endif; ?>
        </div>
    </header>

    <!-- Search Bar (Centered in the Page) -->
    <div class="search-container">
        <!-- Toggle Switch -->
        <label class="toggle-switch">
            <input type="checkbox" id="toggle">
            <span class="slider">
                <span class="toggle-text left">Professors</span>
                <span class="toggle-text right">Universities</span>
            </span>
        </label>
        <input type="text" class="search-bar" id="search-bar" placeholder="Search professors...">
        <div class="search-results" id="search-results"></div>
    </div>

    <!-- Quote Box -->
    <div class="quote-box" id="quote-box"></div>

    <script>
        const toggle = document.getElementById('toggle');
        const searchBar = document.getElementById('search-bar');
        const searchResults = document.getElementById('search-results');

        // Toggle between professors and universities
        toggle.addEventListener('change', function () {
            searchBar.placeholder = this.checked ? "Search universities..." : "Search professors...";
        });

        // AJAX Search Functionality
        searchBar.addEventListener('input', function () {
            const query = this.value;
            const searchType = toggle.checked ? 'universities' : 'professors';

            if (query.length > 0) {
                $.ajax({
                    url: 'search_handler.php',
                    method: 'GET',
                    data: { query: query, type: searchType },
                    success: function (data) {
                        console.log("Response received:", data);
                        searchResults.innerHTML = data;
                        searchResults.style.display = 'block';
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                    }
                });
            } else {
                searchResults.innerHTML = '';
                searchResults.style.display = 'none';
            }
        });

        // Hide search results when clicking outside
        document.addEventListener('click', function (e) {
            if (!searchResults.contains(e.target) && e.target !== searchBar) {
                searchResults.style.display = 'none';
            }
        });

        // Quote Box Functionality
        const quotes = [
            "“Rate my prof? More like roast my prof.”",
            "“Searching for a good professor is my cardio.”",
            "“Behind every crying student is a highly-rated professor... allegedly.”",
            "“Some profs teach you a subject. Others teach you pain.”",
            "“Looking for a good university? Same energy as finding your lost socks.”",
            "“All professors are cool… until the grading starts.”",
            "“You don’t choose the professor life. The professor life chooses you.”"
        ];

        const quoteBox = document.getElementById("quote-box");
        quoteBox.textContent = quotes[Math.floor(Math.random() * quotes.length)];
    </script>

</body>
</html>
