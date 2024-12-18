<?php

// Function to establish a database connection using PDO
function getDB() {
    try {
        // Set up database connection using PDO
        $db = new PDO('mysql:host=localhost;dbname=passwords', 'passwords_user', 'k(D2Whiue9d8yD');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error mode to exceptions
        return $db;
    } catch (PDOException $e) {
        echo "Database connection failed: " . $e->getMessage();
        exit;
    }
}

// Insert a new account into the Accounts table
function insertAccount($userId, $siteName, $url, $password, $comment) {
    try {
        $db = getDB();

        // Prepare SQL query for inserting the account
        $sql = "INSERT INTO Accounts (user_id, site_name, url, password, comment) 
                VALUES (:userId, :siteName, :url, AES_ENCRYPT(:password, 'encryption_key'), :comment)";
        $stmt = $db->prepare($sql);

        // Bind parameters to prevent SQL injection
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':siteName', $siteName);
        $stmt->bindParam(':url', $url);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':comment', $comment);

        // Execute the query
        $stmt->execute();
        echo "Account successfully added!";
    } catch (PDOException $e) {
        echo "Error inserting account: " . $e->getMessage();
    }
}

// Search for accounts by site name or comment
function searchAccounts($searchTerm) {
    try {
        $db = getDB();

        // SQL query for searching based on site_name or comment
        $sql = "SELECT a.account_id, a.user_id, a.site_name, a.url, u.email, u.username,a.comment, a.created_at 
                FROM Accounts a
                JOIN Users u ON a.user_id = u.user_id
                WHERE a.site_name LIKE :searchTerm OR a.comment LIKE :searchTerm";
        $stmt = $db->prepare($sql);

        // Bind the parameter for search term (wildcards for LIKE)
        $searchTermWithWildcards = '%' . $searchTerm . '%';
        $stmt->bindParam(':searchTerm', $searchTermWithWildcards);
        
        // Execute the query
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error searching accounts: " . $e->getMessage();
    }
}

// Update an account's attribute based on a pattern match
function updateAccount($currentAttribute, $newAttribute, $queryAttribute, $pattern) {
    try {
        $db = getDB();

        // Build the dynamic SQL query for updating the account
        $sql = "UPDATE Accounts 
                SET $currentAttribute = :newAttribute 
                WHERE $queryAttribute = :pattern";
        $stmt = $db->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':newAttribute', $newAttribute);
        $stmt->bindParam(':pattern', $pattern);

        // Execute the update
        $stmt->execute();
        echo "Account successfully updated!";
    } catch (PDOException $e) {
        echo "Error updating account: " . $e->getMessage();
    }
}

// Delete an account based on a pattern match for a specific attribute
function deleteAccount($currentAttribute, $pattern) {
    try {
        $db = getDB();

        // SQL query for deleting an account based on attribute match
        $sql = "DELETE FROM Accounts WHERE $currentAttribute = :pattern";
        $stmt = $db->prepare($sql);

        // Bind parameter
        $stmt->bindParam(':pattern', $pattern);

        // Execute the delete
        $stmt->execute();
        echo "Account successfully deleted!";
    } catch (PDOException $e) {
        echo "Error deleting account: " . $e->getMessage();
    }
}

?>
