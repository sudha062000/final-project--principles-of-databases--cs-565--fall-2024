<?php
require_once "config.php";

function connectDB() {
    try {
        $dsn = "mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8mb4";
        $pdo = new PDO($dsn, DBUSER, DBPASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        return $pdo;
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}

// INSERT Operation
function insertAccount($userId, $siteName, $url, $password, $comment) {
    $pdo = connectDB();
    $stmt = $pdo->prepare("
        INSERT INTO Accounts (user_id, site_name, url, password, comment)
        VALUES (?, ?, ?, AES_ENCRYPT(?, 'encryption_key'), ?)
    ");
    $stmt->execute([$userId, $siteName, $url, $password, $comment]);
}

// SEARCH Operation
function searchAccounts($searchTerm) {
    $pdo = connectDB();
    $stmt = $pdo->prepare("
        SELECT u.first_name, u.last_name, u.username, u.email, a.site_name, a.url, 
               CAST(AES_DECRYPT(a.password, 'encryption_key') AS CHAR) AS password, a.comment
        FROM Users u
        JOIN Accounts a ON u.id = a.user_id
        WHERE u.first_name LIKE ? OR u.last_name LIKE ? OR u.username LIKE ? OR u.email LIKE ?
           OR a.site_name LIKE ? OR a.url LIKE ? OR a.comment LIKE ?
    ");
    $likeTerm = "%" . $searchTerm . "%";
    $stmt->execute([$likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm, $likeTerm]);
    return $stmt->fetchAll();
}

// UPDATE Operation
function updateAccount($column, $newValue, $whereColumn, $whereValue) {
    $pdo = connectDB();
    $stmt = $pdo->prepare("
        UPDATE Accounts
        SET $column = ?
        WHERE $whereColumn = ?
    ");
    $stmt->execute([$newValue, $whereValue]);
}

// DELETE Operation
function deleteAccount($column, $value) {
    $pdo = connectDB();
    $stmt = $pdo->prepare("
        DELETE FROM Accounts
        WHERE $column = ?
    ");
    $stmt->execute([$value]);
}
?>
