<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection settings
$servername = "localhost";
$username = "id22299453_apple";
$password = "Zuhair@arif1"; // Replace with your MySQL root password
$dbname = "id22299453_apple"; // The database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Process form submission
$message = ""; // Initialize message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $favoriteDell = isset($_POST['dell']) ? sanitizeInput($_POST['dell']) : null;

    if ($favoriteDell) {
        // Prepare and bind SQL statement for inserting into dell_company table
        $stmt = $conn->prepare("INSERT INTO dell_company (favorite_dell_laptop) VALUES (?)");
        if ($stmt === false) {
            $message = "Error preparing statement: " . $conn->error;
        } else {
            $stmt->bind_param("s", $favoriteDell);

            // Execute the statement
            if ($stmt->execute()) {
                $message = "Thank you for participating in our survey! Your favorite Dell laptop model is: <strong>$favoriteDell</strong>";
            } else {
                $message = "Error executing statement: " . $stmt->error;
            }

            // Close statement
            $stmt->close();
        }
    } else {
        $message = "No Dell laptop model selected. Please go back and select your favorite Dell laptop model.";
    }
} else {
    $message = "Invalid request method.";
}

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dell Laptop | Survey Surfers</title>
  <link rel="stylesheet" href="https://unpkg.com/@picocss/pico">
</head>
<body>
  <main class="container">
    <h1>Dell Laptop Survey</h1>
    <article>
      <header><strong>Q1: Which one is your favourite Dell's Laptop ?</strong></header>
      <form method="POST" action="dell.php">
        <fieldset>
          <label>
            <input type="radio" name="dell" value="Dell XPS 13" checked>
            Dell XPS 13
          </label>
          <label>
            <input type="radio" name="dell" value="Dell Inspiron 15">
            Dell Inspiron 15
          </label>
          <label>
            <input type="radio" name="dell" value="Dell Latitude 14">
            Dell Latitude 14
          </label>
          <label>
            <input type="radio" name="dell" value="Dell G3">
            Dell G3
          </label>
        </fieldset>
        <input type="submit" value="submit">
      </form>
      <p><?php echo isset($message) ? $message : ''; ?></p>
    </article>
  </main>
</body>
</html>
