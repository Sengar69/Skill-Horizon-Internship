<!DOCTYPE html>
<html>
<head>
    <title>Vulnerable Login Page</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        .container { max-width: 400px; margin: 0 auto; }
        input[type="text"], input[type="password"] { 
            width: 100%; padding: 10px; margin: 5px 0; 
            border: 1px solid #ccc; border-radius: 4px; 
        }
        button { 
            background-color: #4CAF50; color: white; 
            padding: 10px 20px; border: none; 
            border-radius: 4px; cursor: pointer; 
        }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login Page (VULNERABLE)</h2>
        
        <?php
        // Database connection
        $host = 'localhost';
        $dbname = 'vulnerable_app';
        $username = 'root';
        $password = '';
        
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "<div class='error'>Connection failed: " . $e->getMessage() . "</div>";
        }
        
        if ($_POST) {
            $user = $_POST['username'];
            $pass = $_POST['password'];
            
            // VULNERABLE CODE - Direct string concatenation
            $sql = "SELECT * FROM users WHERE username = '$user' AND password = '$pass'";
            
            echo "<div class='error'>Executing query: " . htmlspecialchars($sql) . "</div>";
            
            try {
                $result = $pdo->query($sql);
                $user_data = $result->fetch(PDO::FETCH_ASSOC);
                
                if ($user_data) {
                    echo "<div class='success'>Login successful! Welcome " . htmlspecialchars($user_data['username']) . "</div>";
                    echo "<div class='success'>User ID: " . htmlspecialchars($user_data['id']) . "</div>";
                    echo "<div class='success'>Email: " . htmlspecialchars($user_data['email']) . "</div>";
                } else {
                    echo "<div class='error'>Invalid username or password!</div>";
                }
            } catch(PDOException $e) {
                echo "<div class='error'>Query failed: " . $e->getMessage() . "</div>";
            }
        }
        ?>
        
        <form method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Login</button>
        </form>
        
        <hr>
        <h3>Test Accounts:</h3>
        <p><strong>admin</strong> / <strong>admin123</strong></p>
        <p><strong>user1</strong> / <strong>password1</strong></p>
        
        <hr>
        <h3>SQL Injection Examples:</h3>
        <p><strong>Username:</strong> admin' OR '1'='1' --</p>
        <p><strong>Password:</strong> anything</p>
        <p><em>This will bypass authentication!</em></p>
    </div>
</body>
</html>

