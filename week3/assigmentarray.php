
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<?php
// Question 1:

$numbers = [5, -7, 12, 10, -7, 11, -6, 12, 1, -7, 2, 9];

// 1. Print all elements
echo "Array Elements: " . implode(", ", $numbers) . "<br>";

// Variables for calculations
$total = 0;
$totalEven = 0;
$totalOdd = 0;

$min = $numbers[0];
$max = $numbers[0];

// Find min and max values first
foreach ($numbers as $num) {
    $total += $num;
    
    if ($num % 2 == 0) {
        $totalEven += $num;
    } else {
        $totalOdd += $num;
    }
    
    if ($num < $min) {
        $min = $num;
    }
    if ($num > $max) {
        $max = $num;
    }
}

// Find all index positions for min and max
$minPositions = array_keys($numbers, $min);
$maxPositions = array_keys($numbers, $max);

// Print results
echo "Total of all elements: " . $total . "<br>";
echo "Total of even elements: " . $totalEven . "<br>";
echo "Total of odd elements: " . $totalOdd . "<br>";
echo "Minimum element: " . $min . " (at index positions: " . implode(", ", $minPositions) . ")<br>";
echo "Maximum element: " . $max . " (at index positions: " . implode(", ", $maxPositions) . ")<br><br>";


// Question 2:

$colors = [
    "Light" => [
        "Red" => "Light Red",
        "Green" => "Light Green",
        "Blue" => "Light Blue"
    ],
    "Normal" => [
        "Red" => "Normal Red",
        "Green" => "Normal Green",
        "Blue" => "Normal Blue"
    ],
    "Dark" => [
        "Red" => "Dark Red",
        "Green" => "Dark Green",
        "Blue" => "Dark Blue"
    ]
];

echo "<h3>Color Table</h3>";
echo "<table class='color-table'>";
echo "<tr><th></th><th>Red</th><th>Green</th><th>Blue</th></tr>";

foreach ($colors as $rowName => $columns) {
    echo "<tr>";
    echo "<th>" . $rowName . "</th>";
    foreach ($columns as $colorValue) {
        echo "<td>" . $colorValue . "</td>";
    }
    echo "</tr>";
}
echo "</table><br><br>";



// Question 3:

$students = [
    "CA221" => [
        "Name" => "Mohamed Ahmed Ali",
        "Phone" => "0648440403",
        "Address" => "Laba Dhagax, Wardhiigley"
    ],
    "CA223" => [
        "Name" => "Ahmed Abdi Jama",
        "Phone" => "0647223201",
        "Address" => "Taleex, Hodan"
    ],
    "CA221_2" => [ // Unique key used to preserve repeated row key in array
        "Name" => "Amina Nur Adan",
        "Phone" => "0646990276",
        "Address" => "Macmacaanka, Dharkeynley"
    ]
];

echo "<h3>Student Details</h3>";
echo '<style>
.color-table, .student-table { width: 75%; margin: 0 auto; border-collapse: collapse; table-layout: fixed; font-family: Georgia, "Times New Roman", serif; font-size: 22px; }
.color-table th, .color-table td, .student-table th, .student-table td { border: 1px solid #111; padding: 3px 10px; text-align: left; vertical-align: top; overflow-wrap: break-word; }
.color-table tr:first-child th, .color-table th:first-child, .student-table thead th, .student-table tbody th { background: #ddd; font-weight: normal; }
.color-table th { width: 25%; }
.student-table th:nth-child(1) { width: 15%; }
.student-table th:nth-child(2) { width: 20%; }
.student-table th:nth-child(3) { width: 36%; }
.student-table th:nth-child(4) { width: 29%; }
@media (max-width: 700px) {
    .color-table, .student-table { width: 100%; font-size: 17px; }
    .color-table th, .color-table td, .student-table th, .student-table td { padding: 4px; }
}
</style>';
echo "<table class='student-table'>";
echo "<thead><tr><th></th><th>Name</th><th>Phone</th><th>Address</th></tr></thead><tbody>";

foreach ($students as $id => $details) {
    // Clean up key display for duplicated student ID
    $displayId = ($id === "CA221_2") ? "CA221" : $id;
    
    echo "<tr>";
    echo "<th>" . $displayId . "</th>";
    echo "<td>" . $details["Name"] . "</td>";
    echo "<td>" . $details["Phone"] . "</td>";
    echo "<td>" . $details["Address"] . "</td>";
    echo "</tr>";
}
echo "</tbody></table>";
?>