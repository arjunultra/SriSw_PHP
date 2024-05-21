<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            <h1 id="title" class="text-center">freeCodeCamp Survey Form</h1>
            <p id="description" class="description text-center">
                Thank you for taking the time to help us improve the platform
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
                <p>Which option best describes your current role?</p>
                <select id="dropdown" name="role" class="form-control">
                    <option disabled selected value>Select current role</option>
                    <option value="student">Student</option>
                    <option value="job">Full Time Job</option>
                    <option value="learner">Full Time Learner</option>
                    <option value="preferNo">Prefer not to say</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div class="form-group">
                <p>Would you recommend freeCodeCamp to a friend?</p>
                <label>
                    <input name="user-recommend" value="definitely" type="radio" class="input-radio"
                        checked />Definitely</label>
                <label>
                    <input name="user-recommend" value="maybe" type="radio" class="input-radio" />Maybe</label>

                <label><input name="user-recommend" value="not-sure" type="radio" class="input-radio" />Not sure</label>
            </div>

            <div class="form-group">
                <p>
                    What is your favorite feature of freeCodeCamp?
                </p>
                <select id="most-like" name="mostLike" class="form-control">
                    <option disabled selected value>Select an option</option>
                    <option value="challenges">Challenges</option>
                    <option value="projects">Projects</option>
                    <option value="community">Community</option>
                    <option value="openSource">Open Source</option>
                </select>
            </div>

            <div class="form-group">
                <p>
                    What would you like to see improved?
                    <span class="clue">(Check all that apply)</span>
                </p>

                <label><input name="prefer" value="front-end-projects" type="checkbox"
                        class="input-checkbox" />Front-end
                    Projects</label>
                <label>
                    <input name="prefer" value="back-end-projects" type="checkbox" class="input-checkbox" />Back-end
                    Projects</label>
                <label><input name="prefer" value="data-visualization" type="checkbox" class="input-checkbox" />Data
                    Visualization</label>
                <label><input name="prefer" value="challenges" type="checkbox"
                        class="input-checkbox" />Challenges</label>
                <label><input name="prefer" value="open-source-community" type="checkbox" class="input-checkbox" />Open
                    Source Community</label>
                <label><input name="prefer" value="gitter-help-rooms" type="checkbox" class="input-checkbox" />Gitter
                    help
                    rooms</label>
                <label><input name="prefer" value="videos" type="checkbox" class="input-checkbox" />Videos</label>
                <label><input name="prefer" value="city-meetups" type="checkbox" class="input-checkbox" />City
                    Meetups</label>
                <label><input name="prefer" value="wiki" type="checkbox" class="input-checkbox" />Wiki</label>
                <label><input name="prefer" value="forum" type="checkbox" class="input-checkbox" />Forum</label>
                <label><input name="prefer" value="additional-courses" type="checkbox"
                        class="input-checkbox" />Additional
                    Courses</label>
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