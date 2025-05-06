<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | ProfRate</title>
    <link rel="stylesheet" href="search_bar.css"> <!-- Link to external CSS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery -->
</head>
<body>

    <!-- Navigation Bar -->
    <header>
        <div class="logo">ProfRate</div>
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
        <div class="search-results" id="search-results"></div> <!-- Container for search results -->
    </div>

    <!-- JavaScript to handle toggle logic and AJAX -->
    <script>
        const toggle = document.getElementById('toggle');
        const searchBar = document.getElementById('search-bar');
        const searchResults = document.getElementById('search-results');

        toggle.addEventListener('change', function() {
            if (this.checked) {
                searchBar.placeholder = "Search universities...";
            } else {
                searchBar.placeholder = "Search professors...";
            }
        });

        // AJAX to fetch search results
        searchBar.addEventListener('input', function () {
            const query = this.value;
            const searchType = toggle.checked ? 'universities' : 'professors'; // Determine search type based on toggle

            if (query.length > 0) {
                $.ajax({
                    url: 'search_handler.php', // Backend script to handle search
                    method: 'GET',
                    data: { query: query, type: searchType }, // Send query and search type
                    success: function (data) {
                        console.log("Response received:", data); // Debug: Log the response
                        searchResults.innerHTML = data; // Populate results
                        searchResults.style.display = 'block'; // Show the results
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", status, error); // Debug: Log AJAX errors
                    }
                });
            } else {
                searchResults.innerHTML = '';
                searchResults.style.display = 'none'; // Hide the results if the query is empty
            }
        });

        // Hide results when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchResults.contains(e.target) && e.target !== searchBar) {
                searchResults.style.display = 'none';
            }
        });
    </script>

</body>
</html>
