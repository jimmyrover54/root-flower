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
        <form method="post" action="mailto:105804016@students.swinburne.edu.my">
            <fieldset>
                <legend>Personal Details</legend>
                <div class="twintext">
                    <div>
                        <label for="first_name">First Name:</label>
                        <input type="text" name="first_name" id="first_name" pattern="[a-zA-Z]{0-25}" required="required">
                    </div>
                    <div>
                        <label for="last_name">Last Name:</label>
                        <input type="text" name="last_name" id="last_name" pattern="[a-zA-Z]{0-25}" required="required">
                    </div>
                </div>
                <div class="singletext">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required="required">
                </div>
            </fieldset>
            <fieldset>
                <legend>Account Details</legend>
                <div class="twintext">
                    <div>
                        <label for="login-id">Login ID:</label>
                        <input type="text" name="login-id" id="login-id" pattern="[a-zA-Z]{0-10}" required="required">
                    </div>
                    <div>
                        <label for="password">Password:</label>
                        <input type="text" name="password" id="password" pattern="[a-zA-Z]{0-25}" required="required">
                    </div>
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