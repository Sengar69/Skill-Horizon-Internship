<?php
// Database setup script for vulnerable web app
$host = 'localhost';
$username = 'root';
$password = '';

try {
    // Connect to MySQL server
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS vulnerable_app");
    echo "Database 'vulnerable_app' created successfully!<br>";
    
    // Use the database
    $pdo->exec("USE vulnerable_app");
    
    // Create users table
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        password VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    $pdo->exec($sql);
    echo "Table 'users' created successfully!<br>";
    
    // Insert test data
    $users = [
        ['admin', 'admin123', 'admin@example.com'],
        ['user1', 'password1', 'user1@example.com'],
        ['test', 'test123', 'test@example.com']
    ];
    
    foreach ($users as $user) {
        $stmt = $pdo->prepare("INSERT IGNORE INTO users (username, password, email) VALUES (?, ?, ?)");
        $stmt->execute($user);
    }
    
    echo "Test users inserted successfully!<br>";
    echo "<br><strong>Test Accounts:</strong><br>";
    echo "admin / admin123<br>";
    echo "user1 / password1<br>";
    echo "test / test123<br>";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
