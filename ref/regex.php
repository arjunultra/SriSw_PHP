<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP_Regex</title>
</head>

<body>
    <?php
    $str = "I love learning on codedamn!";
    $pattern = "/codedamn|code damn/";
    $match = [];

    if (preg_match_all($pattern, $str)) {
        echo $match;
    } else {
        echo "Match not found.";
    }


    ?>
</body>

</html>