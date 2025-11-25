<?php
// Include database connection
require_once 'db_conn.php';

// Initialize variables for error handling
$errors = [];
$success = false;

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Sanitize and validate input
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $login_id = trim($_POST['login-id'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    // Validation
    if (empty($first_name) || !preg_match("/^[a-zA-Z]{1,25}$/", $first_name)) {
        $errors[] = "First name is required and must contain only letters (max 25 characters).";
    }
    
    if (empty($last_name) || !preg_match("/^[a-zA-Z]{1,25}$/", $last_name)) {
        $errors[] = "Last name is required and must contain only letters (max 25 characters).";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid email address is required.";
    }
    
    if (empty($login_id) || !preg_match("/^[a-zA-Z0-9_]{3,10}$/", $login_id)) {
        $errors[] = "Login ID is required (3-10 characters, letters, numbers, underscore).";
    }
    
    if (empty($password) || !preg_match("/^(?=.*[a-zA-Z])(?=.*[0-9]).{6,25}$/", $password)) {
        $errors[] = "Password is required (6-25 characters, must include letters and numbers).";
    }
    
    // Check if login_id already exists
    if (empty($errors)) {
        $check_stmt = $conn->prepare("SELECT id FROM membership WHERE login_id = ?");
        $check_stmt->bind_param("s", $login_id);
        $check_stmt->execute();
        $check_stmt->store_result();
        
        if ($check_stmt->num_rows > 0) {
            $errors[] = "This Login ID is already taken. Please choose a different one.";
        }
        
        $check_stmt->close();
    }
    
    // If no errors, insert into database
    if (empty($errors)) {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Prepare SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO membership (first_name, last_name, email, login_id, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $first_name, $last_name, $email, $login_id, $hashed_password);
        
        if ($stmt->execute()) {
            $success = true;
        } else {
            $errors[] = "Database error: " . $stmt->error;
        }
        
        $stmt->close();
    }
    
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Azmain Taraqqi">
    <meta name="keywords" content="HTML5, Root Flower, Membership, Confirmation">
    <meta name="description" content="Membership registration confirmation">
    <link href="styles/style.css" rel="stylesheet">
    <title>Membership Confirmed - Root Flower</title>
</head>
<body>
    <?php include 'header.php'; ?>

    <main class="content">
        <?php if ($success): ?>
            <div class="confirmation-container success">
                <h1>✓ Membership Registration Successful!</h1>
                <div class="confirmation-message">
                    <p>Welcome, <strong><?php echo htmlspecialchars($first_name . ' ' . $last_name); ?></strong>!</p>
                    <p>Your membership account has been successfully created.</p>
                    
                    <div class="confirmation-details">
                        <h3>Account Details</h3>
                        <ul>
                            <li><strong>Login ID:</strong> <?php echo htmlspecialchars($login_id); ?></li>
                            <li><strong>Name:</strong> <?php echo htmlspecialchars($first_name . ' ' . $last_name); ?></li>
                            <li><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></li>
                        </ul>
                    </div>
                    
                    <p class="confirmation-note">You can now use your Login ID and password to access member-only features.</p>
                    
                    <div class="confirmation-actions">
                        <a href="login_form.php" class="btn-primary">Login Now</a>
                        <a href="index.php" class="btn-secondary">Return to Home</a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="confirmation-container error">
                <h1>✗ Membership Registration Failed</h1>
                <div class="confirmation-message">
                    <p><strong>Please correct the following errors:</strong></p>
                    <ul class="error-list">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    
                    <div class="confirmation-actions">
                        <a href="membership_form.php" class="btn-primary">Go Back to Form</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
