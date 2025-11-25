<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Azmain Taraqqi">
    <meta name="keywords" content="HTML5, Root Flower, Membership, Form">
    <meta name="description" content="Membership form for Root Flower">
    <link href="styles/style.css" rel="stylesheet">
    <title>Membership Form - Root Flower</title>
</head>
<body>
    <?php include 'header.php'; ?>

    <main class="content">

        <h1>Membership Registration Form</h1>
        <form method="post" action="membership_process.php">
            <fieldset>
                <legend>Personal Details</legend>
                <div class="twintext">
                    <div>
                        <label for="first_name">First Name:</label>
                        <input type="text" name="first_name" id="first_name" pattern="[a-zA-Z]{1,25}" maxlength="25" title="First name should contain only letters (1-25 characters)" required>
                    </div>
                    <div>
                        <label for="last_name">Last Name:</label>
                        <input type="text" name="last_name" id="last_name" pattern="[a-zA-Z]{1,25}" maxlength="25" title="Last name should contain only letters (1-25 characters)" required>
                    </div>
                </div>
                <div class="singletext">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" title="Please enter a valid email address" required>
                </div>
            </fieldset>
            <fieldset>
                <legend>Account Details</legend>
                <div class="singletext">
                    <label for="login-id">Login ID:</label>
                    <input type="text" name="login-id" id="login-id" pattern="[a-zA-Z0-9_]{3,10}" minlength="3" maxlength="10" title="Login ID: 3-10 characters (letters, numbers, underscore)" required>
                </div>
                <div class="singletext">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" pattern="(?=.*[a-zA-Z])(?=.*[0-9]).{6,25}" minlength="6" maxlength="25" title="Password: 6-25 characters (must include letters and numbers)" required>
                </div>
            </fieldset>
            <div class="subres">
                <input type="submit" value="Submit">
                <input type="reset" value="Reset">
            </div>    
        </form>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>