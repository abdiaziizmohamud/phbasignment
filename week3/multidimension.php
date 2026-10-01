<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $info = array(
        array("abdi aziiz", 1990, "hiliwaa", "0614434455"),
        array("mahamud", 2001, "deynile", "0612665941"),
        array("hussein", 1986, "kaxda", "0617373383"),
    );

    echo "<br>";
    echo $info[0][0];

    foreach ($info as $list) {
        echo $list[0], $list[1];
    }

    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>Name</th>";
    echo "<th>year of Birth</th>";
    echo "<th>Adress</th>";
    echo "<th>Phone</th>";
    echo "</tr>";

    foreach ($info as $list) {
        echo "<tr>";
        foreach ($list as $item) {
            echo "<td>" . $item . "</td>";
        }
        echo "</tr>";
    }

    echo "</table>";

    if (is_array($info)) {
        echo "this is an array";
    } else {
        echo "this is not an array";
    }

    echo "<br>";

    if (in_array("mohamed", $info[0])) {
        echo "this is in the array";
    } else {
        echo "this is not in the array";
    }

    echo "<br>";
    echo "the size of the array is " . count($info);
    echo "<br>";
    echo "<h1>Function</h1>";
    function sum($number1, $number2) {
        $result = $number1 + $number2;
        echo $result;
    }
    sum(10, 20);
    echo "<br>";
    ?>
</body>
</html>