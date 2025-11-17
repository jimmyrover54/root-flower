<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Azmain Taraqqi">
    <meta name="keywords" content="HTML5, Root Flower, Login, Form">
    <meta name="description" content="Login page for Root Flower">
    <link href="styles/style.css" rel="stylesheet">
    <title>Login - Root Flower</title>
</head>
<body>
    <?php include 'header.php'; ?>

    <main class="content">
        <h1>Login</h1>
        <form method="post" action="mailto:105804016@students.swinburne.edu.my">
            <fieldset>
                <div class="singletext">
                    <label for="login-id">Login ID:</label>
                    <input type="text" name="login-id" id="login-id" pattern="[a-zA-Z]{0-10}" required="required">
                </div>
                <div class="singletext">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" required="required">
                </div>
            </fieldset>
            <div class="subres">
                <input type="submit" value="Login">
            </div>
        </form>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>