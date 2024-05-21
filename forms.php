<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="ref/style.css">
</head>

<body>
    <!-- PHP code -->
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "mydb";
    // validation variables
    $nameValid = $emailValid = $ageValid = "";

    // Function to redirect to the given URL
    function redirect($url)
    {
        header('Location: ' . $url);
        exit();
    }

    // Check for the POST request and validate input fields
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $age = trim($_POST['age']);

        // Validate Name: Allow letters and white spaces
        if (empty($name) || (!preg_match("/^[a-zA-Z-' ]*$/", $name))) {
            $nameValid = "is-invalid";
        } else {
            $nameValid = "is-valid";
        }

        // Validate Email using regex
        if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)) {
            $emailValid = "is-invalid";
        } else {
            $emailValid = "is-valid";
        }

        // Validate Age: Allow integers only
        if (!preg_match("/^[0-9]{1,2}$/", $age)) {
            $ageValid = "is-invalid";
        } else {
            $ageValid = "is-valid";
        }

        // Check if any field is invalid before proceeding
        if ($nameValid == "is-invalid" || $emailValid == "is-invalid" || $ageValid == "is-invalid") {
            // Do not proceed to database operations
            echo "All fields are required and must be valid.";
        } else {
            // Proceed with database connection and operations since all inputs are valid
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Attempt to create table only if it doesn't exist
            $sql = "CREATE TABLE IF NOT EXISTS feedback_form (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(30) NOT NULL,
            email VARCHAR(50),
            age INT(2)
        )";

            if (!mysqli_query($conn, $sql)) {
                echo "Error creating table: " . mysqli_error($conn);
            }

            // Inserting data
            $stmt = mysqli_prepare($conn, "INSERT INTO feedback_form (name, email, age) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "ssi", $name, $email, $age);
            if (!mysqli_stmt_execute($stmt)) {
                echo "Error inserting data: " . mysqli_stmt_error($stmt);
            } else {
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                redirect('forms.php');
            }
        }
    }
    ?>



    <div class="container">
        <header class="header">
            <h1 id="title" class="text-center"><span class="h1 text-bg-success rounded-pill px-3">Sri Software</span>
                Feedback Form</h1>
            <p id="description" class="description text-center">
                Thank you for taking the time to help us improve our products & services.
            </p>
        </header>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label id="name-label" for="name">Name</label>
                <input type="text" name="name" class="form-control <?php echo $nameValid; ?>"
                    value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                <!-- Display validation feedback only if there's a submission attempt -->
                <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && $nameValid == "is-invalid"): ?>
                    <div class="invalid-feedback">Please enter a valid name.</div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label id="email-label" for="email">Email</label>
                <input type="email" name="email" class="form-control <?php echo $emailValid; ?>"
                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                <!-- Display validation feedback -->
                <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && $emailValid == "is-invalid"): ?>
                    <div class="invalid-feedback">Please enter a valid email address.</div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label id="number-label" for="number">Age<span class="clue"></span></label>
                <input type="number" min="18" max="90" name="age" class="form-control <?php echo $ageValid; ?>"
                    value="<?php echo isset($_POST['age']) ? htmlspecialchars($_POST['age']) : ''; ?>">
                <!-- Display validation feedback -->
                <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && $ageValid == "is-invalid"): ?>
                    <div class="invalid-feedback">Please enter a valid age.</div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <button type="submit" id="submit" class="submit-button btn btn-primary">
                    Submit
                </button>
            </div>
        </form>
    </div>
</body>

</html>