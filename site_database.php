<?php
// Get the database URL from the environment variable (Render will set this automatically)
$db_url = getenv('DATABASE_URL');

// Parse the URL into components
$parsed_url = parse_url($db_url);

// Set up the connection details from the parsed URL
$host = $parsed_url['host'];  // The database host (Render's database address)
$user = $parsed_url['user'];  // The database user
$pass = $parsed_url['pass'];  // The database password
$dbname = ltrim($parsed_url['path'], '/');  // The database name (remove the leading '/')

// Check if the port is provided, else set a default (5432 for PostgreSQL)
$port = isset($parsed_url['port']) ? $parsed_url['port'] : 5432; // Use 5432 for PostgreSQL

// Create the DSN for PDO (Data Source Name) for PostgreSQL
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname"; // PostgreSQL DSN

// Try to establish the connection using PDO
try {
    $conn = new PDO($dsn, $user, $pass);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected to the PostgreSQL database successfully!";
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
