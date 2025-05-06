<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | ProfRate</title>
    <link rel="stylesheet" href="search_bar.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <header>
        <div class="logo">ProfRate</div>
    </header>

    <div class="search-container">
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

        document.addEventListener('click', function(e) {
            if (!searchResults.contains(e.target) && e.target !== searchBar) {
                searchResults.style.display = 'none';
            }
        });
    </script>

</body>
</html>
