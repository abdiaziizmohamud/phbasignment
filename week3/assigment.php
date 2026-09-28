<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Number Exercises</title>
</head>
<body>
<?php
// 1. Find the largest and smallest numbers
$a = 8;
$b = 14;
$c = 11;

$largest = max($a, $b, $c);
$smallest = min($a, $b, $c);

echo "Largest number: " . $largest . "<br>";
echo "Smallest number: " . $smallest . "<br>";

// 2. Check divisibility by 3 and 5
$value = 15;

if ($value % 3 == 0 && $value % 5 == 0) {
    echo "$value is divisible by both 3 and 5.<br>";
} elseif ($value % 3 == 0) {
    echo "$value is divisible by 3.<br>";
} elseif ($value % 5 == 0) {
    echo "$value is divisible by 5.<br>";
} else {
    echo "$value is divisible by neither 3 nor 5.<br>";
}

// 3. Print odd numbers from 1 to 20
for ($i = 1; $i <= 20; $i += 2) {
    echo $i . " ";
}
echo "<br>";

// Print even numbers from 35 down to 7
for ($i = 34; $i >= 7; $i -= 2) {
    echo $i . " ";
}
echo "<br>";

// 4. Print numbers divisible by both 2 and 5, from 50 down to 2
for ($i = 50; $i >= 2; $i--) {
    if ($i % 10 == 0) {
        echo $i . " ";
    }
}
echo "<br>";

// 5. Reverse a number without using a built-in function
$number = 5678;
$reversed = 0;

while ($number > 0) {
    $digit = $number % 10;
    $reversed = ($reversed * 10) + $digit;
    $number = (int)($number / 10);
}

echo "Reversed number: " . $reversed . "<br>";

// 6. Find the LCM of two numbers
$first = 8;
$second = 12;
$lcm = max($first, $second);

while ($lcm % $first != 0 || $lcm % $second != 0) {
    $lcm++;
}

echo "LCM of $first and $second: $lcm<br>";

// 7. Find the HCF of two numbers
$x = 18;
$y = 24;
$hcf = min($x, $y);

while ($x % $hcf != 0 || $y % $hcf != 0) {
    $hcf--;
}

echo "HCF of $x and $y: $hcf<br>";

// 8. Multiplication table up to 12 × 12
echo "<table border='1' cellpadding='5'>";

for ($row = 1; $row <= 12; $row++) {
    echo "<tr>";

    for ($column = 1; $column <= 12; $column++) {
        echo "<td>" . ($row * $column) . "</td>";
    }

    echo "</tr>";
}

echo "</table>";
?>
</body>
</html>