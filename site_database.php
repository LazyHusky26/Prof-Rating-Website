<?php
// Get the database URL from the environment variable (Render will set this automatically)
$db_url = getenv('DATABASE_URL');

// Parse the URL into components
$parsed_url = parse_url($db_url);

// Set up the connection details from the parsed URL
$host = $parsed_url['host'];  // The database host (Render's database address)
$port = $parsed_url['port'];  // The database port (usually 3306 for MySQL)
$user = $parsed_url['user'];  // The database user
$pass = $parsed_url['pass'];  // The database password
$dbname = ltrim($parsed_url['path'], '/');  // The database name (remove the leading '/')

// Create the MySQL connection using the parsed URL
$conn = mysqli_connect($host, $user, $pass, $dbname, $port);

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
} else {
    echo "Connected to the database successfully!";
}
?>
