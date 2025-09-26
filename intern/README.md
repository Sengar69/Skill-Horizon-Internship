# Vulnerable Web Application Module

## Project Overview
This project demonstrates SQL injection vulnerabilities in web applications and how to fix them. It includes both vulnerable and secure versions of a login page.

## Files Included

1. **`setup_database.php`** - Database setup script
2. **`vulnerable_login.php`** - Login page with SQL injection vulnerability
3. **`secure_login.php`** - Fixed login page with proper security measures
4. **`README.md`** - This documentation file

## Setup Instructions

### Prerequisites
- XAMPP/WAMP/LAMP server with PHP and MySQL
- Web browser

### Installation Steps

1. **Start your web server** (XAMPP/WAMP)
2. **Place all files** in your web server's document root (htdocs/www)
3. **Run the database setup**:
   - Open browser and go to: `http://localhost/setup_database.php`
   - This will create the database and test users
4. **Test the vulnerable version**:
   - Go to: `http://localhost/vulnerable_login.php`
5. **Test the secure version**:
   - Go to: `http://localhost/secure_login.php`

## Vulnerability Demonstration

### SQL Injection Attack

**Vulnerable Code:**
```php
$sql = "SELECT * FROM users WHERE username = '$user' AND password = '$pass'";
```

**Attack Payload:**
- Username: `admin' OR '1'='1' --`
- Password: `anything`

**What happens:**
The malicious input transforms the query to:
```sql
SELECT * FROM users WHERE username = 'admin' OR '1'='1' --' AND password = 'anything'
```

This bypasses authentication because `'1'='1'` is always true.

### How to Exploit

1. Open `vulnerable_login.php`
2. Enter the attack payload:
   - Username: `admin' OR '1'='1' --`
   - Password: `anything`
3. Click Login
4. You'll be logged in as admin without knowing the password!

## Security Fix

### Secure Code (Fixed Version)
```php
$sql = "SELECT * FROM users WHERE username = ? AND password = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user, $pass]);
```

### Security Measures Implemented

1. **Prepared Statements**: Uses parameterized queries
2. **Input Validation**: Required field validation
3. **Output Escaping**: `htmlspecialchars()` for XSS prevention
4. **Error Handling**: Proper exception handling

## Test Accounts

| Username | Password |
|----------|----------|
| admin    | admin123 |
| user1    | password1 |
| test     | test123  |

## Learning Objectives

After completing this module, you will understand:

1. **SQL Injection**: How malicious SQL code can be injected
2. **Vulnerable Patterns**: Direct string concatenation in queries
3. **Secure Coding**: Using prepared statements
4. **Input Validation**: Importance of validating user input
5. **Output Escaping**: Preventing XSS attacks

## Security Best Practices

1. **Always use prepared statements** for database queries
2. **Validate and sanitize** all user inputs
3. **Escape output** to prevent XSS
4. **Use least privilege** principle for database access
5. **Implement proper error handling**
6. **Use HTTPS** in production
7. **Regular security audits** and updates

## Screenshots for Documentation

### Vulnerable Version
- Show the SQL injection working
- Display the malicious query being executed
- Show successful unauthorized login

### Secure Version
- Show SQL injection attempt failing
- Display proper authentication
- Show security features implemented

## Conclusion

This module demonstrates the critical importance of secure coding practices. SQL injection remains one of the most common web vulnerabilities, but it can be easily prevented with proper coding techniques like prepared statements.

**Remember**: Security is not optional - it's essential for protecting user data and maintaining system integrity.
