<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect value of input field
    $name = $_POST['name'];

    // Function to validate name
    function validateName($name)
    {
        // Regular expression for name validation
        $pattern = "/^[a-zA-Z ]*$/";

        // Check if name matches the pattern
        if (preg_match($pattern, $name)) {
            return true; // Valid name
        } else {
            return false; // Invalid name
        }
    }

    // Validate user name
    if (validateName($name)) {
        echo "Name is valid.";
    } else {
        echo "Name is not valid.";
    }
}
?>