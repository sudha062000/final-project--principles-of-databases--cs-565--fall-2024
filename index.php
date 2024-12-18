<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Passwords Assignment</title>
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    <header>
      <h1>CRUD Operations via a Web Interface</h1>
    </header>
    <form id="clear-results" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    </form>
<?php
require_once "includes/php/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submitted"])) {
    $action = $_POST["submitted"];
    try {
        if ($action == "3") { // INSERT
            insertAccount($_POST['user-id'], $_POST['site-name'], $_POST['url'], $_POST['password'], $_POST['comment']);
            echo "<p>New account added successfully.</p>";
        } elseif ($action == "1") { // SEARCH
            $results = searchAccounts($_POST['search']);
            if ($results) {
                echo "<table border='1'>";
                echo "<tr><th>First Name</th><th>Last Name</th><th>Username</th><th>Email</th><th>Site Name</th><th>URL</th><th>Password</th><th>Comment</th></tr>";
                foreach ($results as $row) {
                    echo "<tr>";
                    foreach ($row as $value) {
                        echo "<td>" . htmlspecialchars($value) . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No results found.</p>";
            }
        } elseif ($action == "2") { // UPDATE
            updateAccount($_POST['column'], $_POST['new-value'], $_POST['where-column'], $_POST['where-value']);
            echo "<p>Account updated successfully.</p>";
        } elseif ($action == "4") { // DELETE
            deleteAccount($_POST['column'], $_POST['value']);
            echo "<p>Account deleted successfully.</p>";
        }
    } catch (Exception $e) {
        echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}

require_once "includes/html/search-form.html";
require_once "includes/html/update-form.html";
require_once "includes/html/insert-form.html";
require_once "includes/html/delete-form.html";
?>
  </body>
</html>
