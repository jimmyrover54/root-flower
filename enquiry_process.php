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
    $phone = trim($_POST['phone'] ?? '');
    $enquiry_type = trim($_POST['enquiry-type'] ?? '');
    $comment = trim($_POST['comment'] ?? '');
    
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
    
    if (empty($phone) || !preg_match("/^[0-9]{10,12}$/", $phone)) {
        $errors[] = "Phone number is required and must be 10-12 digits.";
    }
    
    if (empty($enquiry_type)) {
        $errors[] = "Enquiry type is required.";
    }
    
    if (empty($comment)) {
        $errors[] = "Enquiry message is required.";
    }
    
    // If no errors, insert into database
    if (empty($errors)) {
        // Prepare SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO enquiry (first_name, last_name, email, phone, enquiry_type, comment) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $first_name, $last_name, $email, $phone, $enquiry_type, $comment);
        
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
    <meta name="keywords" content="HTML5, Root Flower, Enquiry, Confirmation">
    <meta name="description" content="Enquiry submission confirmation">
    <link href="styles/style.css" rel="stylesheet">
    <title>Enquiry Submitted - Root Flower</title>
</head>
<body>
    <?php include 'header.php'; ?>

    <main class="content">
        <?php if ($success): ?>
            <div class="confirmation-container success">
                <h1>✓ Enquiry Submitted Successfully!</h1>
                <div class="confirmation-message">
                    <p>Thank you, <strong><?php echo htmlspecialchars($first_name . ' ' . $last_name); ?></strong>!</p>
                    <p>Your enquiry has been successfully submitted. We will get back to you at <strong><?php echo htmlspecialchars($email); ?></strong> as soon as possible.</p>
                    
                    <div class="confirmation-details">
                        <h3>Submission Details</h3>
                        <ul>
                            <li><strong>Name:</strong> <?php echo htmlspecialchars($first_name . ' ' . $last_name); ?></li>
                            <li><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></li>
                            <li><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></li>
                            <li><strong>Enquiry Type:</strong> <?php echo htmlspecialchars(ucfirst($enquiry_type)); ?></li>
                        </ul>
                    </div>
                    
                    <div class="confirmation-actions">
                        <a href="enquiry_form.php" class="btn-primary">Submit Another Enquiry</a>
                        <a href="index.php" class="btn-secondary">Return to Home</a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="confirmation-container error">
                <h1>✗ Enquiry Submission Failed</h1>
                <div class="confirmation-message">
                    <p><strong>Please correct the following errors:</strong></p>
                    <ul class="error-list">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    
                    <div class="confirmation-actions">
                        <a href="enquiry_form.php" class="btn-primary">Go Back to Form</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
