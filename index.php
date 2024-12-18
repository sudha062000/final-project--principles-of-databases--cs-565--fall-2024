<?php

require_once('includes/php/db.php');

// Initialize the $results variable to handle the search result
$results = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submitted'])) {
        switch ($_POST['submitted']) {
            case '1': // Search
                // Search the database and return results
                $results = searchAccounts($_POST['search']);
                break;

            case '2': // Update
                // Call the update function
                updateAccount($_POST['current-attribute'], $_POST['new-attribute'], $_POST['query-attribute'], $_POST['pattern']);
                break;

            case '3': // Insert
                // Insert a new account into the database
                insertAccount($_POST['user-id'], $_POST['site-name'], $_POST['url'], $_POST['password'], $_POST['comment']);
                break;

            case '4': // Delete
                // Delete an account based on the pattern match
                deleteAccount($_POST['current-attribute'], $_POST['pattern']);
                break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Final Project | CS 565 | Passwords Assignment</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>CRUD Operations via a Web Interface</h1>
    </header>

    <!-- Insert Form -->
    <?php require_once "includes/html/insert-form.html"; ?>

    <!-- Search Form -->
    <?php require_once "includes/html/search-form.html"; ?>

    <!-- Update Form -->
    <?php require_once "includes/html/update-form.html"; ?>

    <!-- Delete Form -->
    <?php require_once "includes/html/delete-form.html"; ?>

    <!-- Display search results if applicable -->
    <?php if (isset($results) && count($results) > 0) : ?>
        <h2>Search Results</h2>
        <table>
            <tr>
                <th>Account ID</th>
                <th>User ID</th>
                <th>Site Name</th>
                <th>URL</th>
                <th>Email</th>
                <th>Username</th>
                <th>Comment</th>
                <th>Created At</th>
            </tr>
            <?php foreach ($results as $account) : ?>
            <tr>
                <td><?= htmlspecialchars($account['account_id']) ?></td>
                <td><?= htmlspecialchars($account['user_id']) ?></td>
                <td><?= htmlspecialchars($account['site_name']) ?></td>
                <td><?= htmlspecialchars($account['url']) ?></td>
                <td><?= htmlspecialchars($account['email']) ?></td>
                <td><?= htmlspecialchars($account['username']) ?></td>
                <td><?= htmlspecialchars($account['comment']) ?></td>
                <td><?= htmlspecialchars($account['created_at']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php elseif (isset($results) && count($results) == 0) : ?>
        <!-- If no results were found, show this message -->
        <p>No matching accounts found.</p>
    <?php endif; ?>

</body>
</html>
