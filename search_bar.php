<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home | ProfRate</title>
  <link rel="stylesheet" href="ssb.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet" />
</head>
<body>

  <!-- Navigation Bar -->
  <header>
    <div class="logo">ProfRate 🚀</div>
  </header>

  <!-- Search Bar (Centered in the Page) -->
  <div class="search-container">
    <!-- Toggle Switch -->
    <label class="toggle-switch">
      <input type="checkbox" id="toggle" />
      <span class="slider">
        <span class="toggle-text left">Professors</span>
        <span class="toggle-text right">Universities</span>
      </span>
    </label>
    <input type="text" class="search-bar" placeholder="Search professors..." />
  </div>

  <!-- Quote Box -->
  <div class="quote-box" id="quote-box"></div>

  <!-- JavaScript -->
  <script>
    const toggle = document.getElementById('toggle');
    const searchBar = document.querySelector('.search-bar');

    toggle.addEventListener('change', function () {
      searchBar.placeholder = this.checked ? "Search universities..." : "Search professors...";
    });

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
