<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php
    // echo unique numbers from the given array
    $given_array = array(1, 5, 2, 3, 5, 2, 4, 6, 7);
    $result = array(); // creating an empty array to hold the result
    for ($i = 0; $i < count($given_array); $i++) {
        $a = $given_array[$i];
        $is_unique = true; // Assume $a is unique until found otherwise

        for ($j = 0; $j < count($given_array); $j++) {
            if ($i != $j && $a == $given_array[$j]) {
                $is_unique = false; // $a is not unique
                break;
            }
        }

        if ($is_unique == true) {
            $result[] = $a; // Add to result only if $a is unique
        }
    }

    echo implode(', ', array_unique($result));







    ?>




</body>

</html>