<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learn PHP</title>
</head>

<body>
    <!--PHP-->
    <?php
    /*
    // for loop\
    for ($i = 1; $i <= 10; $i++) {
        echo ($i);
    }
    // While Loop
    $a = 1;
    while ($a <= 10) {
        echo $a;
        $a++;
    }
    // Do While Loop
    $b = 0;
    do {
        echo $b;
        $b++;
    } while ($b <= 10);
    */

    // foreach loop
    $persons = array("Kavin" => "65", "Muthu" => "33", "Vinoth" => "50");
    foreach ($persons as $x => $y) {
        echo ("$x age is $y <br/>");
    }



    ?>
</body>

</html>