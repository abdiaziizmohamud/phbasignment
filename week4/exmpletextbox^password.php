<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>

    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }

        form {
            border: 2px solid black;
            padding: 20px;
            width: 300px;
            border-radius: 10px;
        }

        input {
            width: 95%;
            padding: 8px;
        }

        button {
            background-color: red;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

    
    </style>
</head>

<body>

<form method="post" id="myForm">

    <label for="name">Enter your name</label><br>
    <input type="text" name="name" id="name"><br><br>

    <label for="password">Enter your password</label><br>
    <input type="password" name="password" id="password"><br><br>



    <label for="comment">comment</label><br>
    <input type="text" name="comment"><br><br>

    <label for="gender">Gender</label><br>
    <input type="radio" name="gender" value="male"> Male<br>
    <input type="radio" name="gender" value="female"> Female<br><br>

    <label for="subscribe">JUST IT</label><br>
    <input type="checkbox" name="JUST IT" value="yes"><br><br>


    <label for="subscribe">JUST Networking</label><br>
    <input type="checkbox" name="JUST Networking" value="yes"><br><br>

    <button type="reset" onclick="clearResult()">Reset Form</button>
    <button type="submit" name="register">Register</button>


</form>

<div id="result">
<?php

if (isset($_POST["register"])) {

    $name = $_POST["name"];
    $password = $_POST["password"];
    $comment = $_POST["comment"];
    $gender = $_POST["gender"];
    $JUST_IT = isset($_POST["JUST IT"]) ? $_POST["JUST IT"] : null;
    $JUST_Networking = isset($_POST["JUST Networking"]) ? $_POST["JUST Networking"] : null;


    echo "<div class='result'>";
    echo "Name: " . $name . "<br>";
    echo "Password: " . $password . "<br>";
    echo "Comment: " . $comment . "<br>";
    echo "Gender: " . $gender . "<br>";
    echo "JUST IT: " . $JUST_IT . "<br>";
    echo "JUST Networking: " . $JUST_Networking . "<br>";

    



    echo "</div>";
}

?>

</body>
</html>