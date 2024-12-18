<?php
// Database connection
function getDB() {
    include_once "includes/php/config.php";
    try {
        $db = new PDO('mysql:host=' . DBHOST . ';dbname=' . DBNAME, DBUSER, DBPASS);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        echo "Error connecting to database: " . $e->getMessage();
        exit;
    }
}

// Insert a new account
function insertAccount($user_id, $site_name, $url, $password, $comment) {
    $db = getDB();
    $sql = "INSERT INTO Accounts (user_id, site_name, url, password, comment) 
            VALUES (:user_id, :site_name, :url, AES_ENCRYPT(:password, 'encryption_key'), :comment)";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':user_id' => $user_id,
        ':site_name' => $site_name,
        ':url' => $url,
        ':password' => $password,
        ':comment' => $comment
    ]);
}

// Search for accounts by site_name or comment
function searchAccounts($searchTerm) {
    $db = getDB();
    $sql = "SELECT * FROM Accounts WHERE site_name LIKE :searchTerm OR comment LIKE :searchTerm";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':searchTerm' => '%' . $searchTerm . '%'
    ]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Update account based on selected criteria
function updateAccount($currentAttribute, $newAttribute, $queryAttribute, $pattern) {
    $db = getDB();
    $sql = "UPDATE Accounts SET $currentAttribute = :newAttribute WHERE $queryAttribute = :pattern";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':newAttribute' => $newAttribute,
        ':pattern' => $pattern
    ]);
}

// Delete an account based on a pattern
function deleteAccount($currentAttribute, $pattern) {
    $db = getDB();
    $sql = "DELETE FROM Accounts WHERE $currentAttribute = :pattern";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':pattern' => $pattern
    ]);
}
