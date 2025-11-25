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
    $address = trim($_POST['address'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $state = trim($_POST['state'] ?? '');
    $postcode = trim($_POST['postcode'] ?? '');
    $participants = trim($_POST['participants'] ?? '');
    $date = trim($_POST['date'] ?? '');
    $comments = trim($_POST['comments'] ?? '');
    
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
    
    if (empty($phone) || !preg_match("/^[0-9]{1,10}$/", $phone)) {
        $errors[] = "Phone number is required and must be up to 10 digits.";
    }
    
    if (empty($address) || !preg_match("/^[a-zA-Z0-9\s,.()\\/\-]{1,40}$/", $address)) {
        $errors[] = "Street address is required (max 40 characters).";
    }
    
    if (empty($city) || !preg_match("/^[a-zA-Z\s]{1,20}$/", $city)) {
        $errors[] = "City/Town is required (max 20 characters).";
    }
    
    if (empty($state)) {
        $errors[] = "State is required.";
    }
    
    if (empty($postcode) || !preg_match("/^[0-9]{5}$/", $postcode)) {
        $errors[] = "Postcode is required and must be 5 digits.";
    }
    
    if (empty($participants) || !preg_match("/^[0-9]{1,2}$/", $participants) || $participants < 1) {
        $errors[] = "Number of participants is required and must be a valid number.";
    }
    
    if (empty($date)) {
        $errors[] = "Preferred date is required.";
    }
    
    // If no errors, insert into database
    if (empty($errors)) {
        // Prepare SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO register (first_name, last_name, email, phone, address, city, state, postcode, participants, preferred_date, comments) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssss", $first_name, $last_name, $email, $phone, $address, $city, $state, $postcode, $participants, $date, $comments);
        
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
    <meta name="keywords" content="HTML5, Root Flower, Workshop, Confirmation">
    <meta name="description" content="Workshop registration confirmation">
    <link href="styles/style.css" rel="stylesheet">
    <title>Registration Confirmed - Root Flower</title>
</head>
<body>
    <?php include 'header.php'; ?>

    <main class="content">
        <?php if ($success): ?>
            <div class="confirmation-container success">
                <h1>✓ Workshop Registration Successful!</h1>
                <div class="confirmation-message">
                    <p>Thank you, <strong><?php echo htmlspecialchars($first_name . ' ' . $last_name); ?></strong>!</p>
                    <p>Your workshop registration has been successfully submitted.</p>
                    
                    <div class="confirmation-details">
                        <h3>Registration Details</h3>
                        <ul>
                            <li><strong>Name:</strong> <?php echo htmlspecialchars($first_name . ' ' . $last_name); ?></li>
                            <li><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></li>
                            <li><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></li>
                            <li><strong>Participants:</strong> <?php echo htmlspecialchars($participants); ?></li>
                            <li><strong>Preferred Date:</strong> <?php echo htmlspecialchars(date('F j, Y', strtotime($date))); ?></li>
                            <li><strong>Address:</strong> <?php echo htmlspecialchars($address . ', ' . $city . ', ' . $state . ' ' . $postcode); ?></li>
                        </ul>
                    </div>
                    
                    <p class="confirmation-note">We will contact you at <strong><?php echo htmlspecialchars($email); ?></strong> to confirm your workshop details.</p>
                    
                    <div class="confirmation-actions">
                        <a href="workshop_form.php" class="btn-primary">Register for Another Workshop</a>
                        <a href="index.php" class="btn-secondary">Return to Home</a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="confirmation-container error">
                <h1>✗ Registration Submission Failed</h1>
                <div class="confirmation-message">
                    <p><strong>Please correct the following errors:</strong></p>
                    <ul class="error-list">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    
                    <div class="confirmation-actions">
                        <a href="workshop_form.php" class="btn-primary">Go Back to Form</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
