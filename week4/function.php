<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
// Create values
function sum($x, $y)
{
    // Create local variable
    $z = $x + $y;
    echo $z;
}

// Calling function
sum(10, 20);
echo "<br>";

$A = 10;
$B = 20;

// Two arguments — passing by value
sum($A, $B);
echo "<br>";


function showWelcome($class)
{
    echo "welcome " . $class . "<br>";

    for ($number = 1; $number <= 4; $number++) {
        echo $number . "<br>";
    }
}

showWelcome("CA233");
?>

</body>
</html>