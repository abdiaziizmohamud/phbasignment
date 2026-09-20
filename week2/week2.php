<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php



    define("Age",123);
    echo Age;


    // exmple
    $Age =20;

    if($Age >=18)
        echo"Adult";
    else
        echo"child";

    // exmple NP


$marks = 100;

switch (true) {
    case ($marks >= 90):
        echo "A";
        break;

    case ($marks >= 80):
        echo "B";
        break;

    case ($marks >= 70):
        echo "C";
        break;

    case ($marks >= 60):
        echo "D";
        break;

    default:
        echo "F";
}




// exmple NP


$fuel = 1;

if ($fuel <= 1) {
    echo "Low";
} else {
    echo "Full";
}


// exmple




$count = 1;

while ($count <= 5) {
    echo $count;
    $count++;
}






// exmple


$count = 1;

do {
    echo $count . "<br>";
    $count++;
} while ($count <= 5);




// exmple


for ($row = 1; $row <= 5; $row++) {
    for ($col = 1; $col <= 5; $col++) {
        $result = $row * $col;
        echo "$row * $col = $result<br>";
    }
}

echo "<br><br>";

// Qaybta labaad ee muujinaysa "Row is X, Column is Y, Result is Z"
for ($row = 1; $row <= 5; $row++) {
    for ($col = 1; $col <= 5; $col++) {
        $result = $row * $col;
        echo "Row is $row, Column is $col, Result is $result<br>";
    }
}




    ?>
    
</body>
</html>