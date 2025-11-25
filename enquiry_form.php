<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Azmain Taraqqi">
    <meta name="keywords" content="HTML5, Root Flower, Enquiry, Form">
    <meta name="description" content="Enquiry form for Root Flower">
    <link href="styles/style.css" rel="stylesheet">
    <title>Enquiry Form - Root Flower</title>
</head>
<body>
    <?php include 'header.php'; ?>

    <main class="content">
        <h1>Enquiry Form</h1>
        <form method="post" action="enquiry_process.php">
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
                <div class="twintext">
                    <div>
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" title="Please enter a valid email address" required>
                    </div>
                    <div>
                        <label for="phone">Phone Number:</label>
                        <input type="tel" name="phone" id="phone" pattern="[0-9]{10,12}" minlength="10" maxlength="12" placeholder="+60-123456789" title="Phone number should be 10-12 digits" required>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>Enquiry Details</legend>
                <div class="selectdiv">
                    <label for="enquiry-type">Enquiry Type:</label>
                    <select name="enquiry-type" id="enquiry-type" title="Please select an enquiry type" required>
                        <option value="" selected>None</option>
                        <option value="product">Product</option>
                        <option value="workshop">Workshop</option>
                        <option value="membership">Membership</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="textareadiv">
                    <label for="comment">Enquiry:</label>
                    <textarea name="comment" id="comment" title="Please enter your enquiry message" required></textarea>
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