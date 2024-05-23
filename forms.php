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

    $edit_name = "";
    $edit_email = "";
    $edit_age = "";
    $update_id = "";

    // Establishing Connection 
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if (isset($_REQUEST['update_id'])) {
        $update_id = $_REQUEST['update_id'];
        $query = "SELECT * FROM feedback_form WHERE id='" . $update_id . "'";
        $result = $conn->query($query);
        if ($result) {
            foreach ($result as $row) {
                $update_id = $row['id'];
                $edit_name = $row['name'];
                $edit_email = $row['email'];
                $edit_age = $row['age'];
            }
        }
    }




    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $age = trim($_POST['age']);

        // Validate Name
        if (empty($name) || (!preg_match("/^[a-zA-Z-' ]*$/", $name))) {
            $nameValid = "is-invalid";
        } else {
            $nameValid = "is-valid";
        }

        // Validate Email
        if (empty($email) || !preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)) {
            $emailValid = "is-invalid";
        } else {
            $emailValid = "is-valid";
        }

        // Validate Age
        if (empty($age) || !preg_match("/^[0-9]{1,2}$/", $age)) {
            $ageValid = "is-invalid";
        } else {
            $ageValid = "is-valid";
        }

        if ($nameValid == "is-invalid" || $emailValid == "is-invalid" || $ageValid == "is-invalid") {
            echo "All fields are required and must be valid.";
        } else {
            // Check if it's an update operation
            if (isset($_POST['update_id']) && !empty($_POST['update_id'])) {
                $update_id = $_POST['update_id'];
                $stmt = mysqli_prepare($conn, "UPDATE feedback_form SET name=?, email=?, age=? WHERE id=?");
                mysqli_stmt_bind_param($stmt, "ssii", $name, $email, $age, $update_id);
                header("location:feedback_table.php");
            } else {
                // Attempt to create table only if it doesn't exist
                $sql = "CREATE TABLE IF NOT EXISTS feedback_form (
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(30) NOT NULL,
                    email VARCHAR(50),
                    age INT(2)
                )";

                if (mysqli_query($conn, $sql)) {
                    // Inserting new data
                    $stmt = mysqli_prepare($conn, "INSERT INTO feedback_form (name, email, age) VALUES (?, ?, ?)");
                    mysqli_stmt_bind_param($stmt, "ssi", $name, $email, $age);

                } else {
                    echo "Error creating table: " . mysqli_error($conn);
                }
            }

            // Execute and close statement
            if (!mysqli_stmt_execute($stmt)) {
                echo "Error: " . mysqli_stmt_error($stmt);
            } else {
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
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
            <label class="" id="id-label" for="id">ID</label>
            <input type="text" name="update_id" class="form-control mb-4" value="<?php echo $update_id; ?>">
            <div class="form-group">
                <label id="name-label" for="name">Name</label>

                <input type="text" name="name" class="form-control <?php echo $nameValid; ?>"
                    value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?><?php echo $edit_name; ?>">
                <!-- Display validation feedback only if there's a submission attempt -->
                <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && $nameValid == "is-invalid"): ?>
                    <div class="invalid-feedback">Please enter a valid name.</div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label id="email-label" for="email">Email</label>
                <input type="email" name="email" class="form-control <?php echo $emailValid; ?>"
                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?><?php echo $edit_email; ?>">
                <!-- Display validation feedback -->
                <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && $emailValid == "is-invalid"): ?>
                    <div class="invalid-feedback">Please enter a valid email address.</div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label id="number-label" for="number">Age<span class="clue"></span></label>
                <input type="number" min="18" max="90" name="age" class="form-control mb-4 <?php echo $ageValid; ?>"
                    value="<?php echo isset($_POST['age']) ? htmlspecialchars($_POST['age']) : ''; ?><?php echo $edit_age; ?>">
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