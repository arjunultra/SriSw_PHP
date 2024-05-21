<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- PHP code -->
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mydb";

    // Function to redirect to the given URL
    function redirect($url)
    {
        header('Location: ' . $url);
        exit();
    }

    // Check for the POST request and validate input fields
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Assuming you have sanitized and validated input
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $age = $_POST['age'] ?? '';

        if (empty($name) || empty($email) || empty($age)) {
            // Optionally set a session or cookie data to show error message later
            echo "All fields are required.";
            exit; // Exit if any field is empty
        }

        // Create connection in an object-oriented manner
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Attempt to create table only if it doesn't exist
        $sql = "CREATE TABLE IF NOT EXISTS surveyform (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30) NOT NULL,
        email VARCHAR(50),
        age INT(2)
    )";
        $conn->query($sql);

        // Inserting data
        $stmt = $conn->prepare("INSERT INTO surveyform(name, email, age) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $name, $email, $age);

        if ($stmt->execute()) {
            // Use session or cookie to show success message on the redirected page
        }

        $stmt->close();
        $conn->close();

        // Redirect to the same page or a confirmation page
        redirect('forms.php'); // Replace 'your_form_page.php' with the actual page you want to redirect to
    }
    ?>





    <div class="container">
        <header class="header">
            <h1 id="title" class="text-center">Sri Software Feedback Form</h1>
            <p id="description" class="description text-center">
                Thank you for taking the time to help us improve our products & services.
            </p>
        </header>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label id="name-label" for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name" />
                <span class="error"></span>
            </div>
            <div class="form-group">
                <label id="email-label" for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your Email" />
            </div>
            <div class="form-group">
                <label id="number-label" for="number">Age<span class="clue">(optional)</span></label>
                <input type="number" name="age" id="number" min="10" max="99" class="form-control" placeholder="Age" />
            </div>
            <div class="form-group">
                <p>Any comments or suggestions?</p>
                <textarea id="comments" class="input-textarea" name="comment"
                    placeholder="Enter your comment here..."></textarea>
            </div>

            <div class="form-group">
                <button type="submit" id="submit" class="submit-button">
                    Submit
                </button>
            </div>
        </form>
        <div class="error">
        </div>
    </div>
</body>

</html>