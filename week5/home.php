<!DOCTYPE html>
<html>
<head>
    <title>Place of Birth</title>
</head>
<body>

<form method="POST" action="">
    <label>Select District:</label>

    <select name="pob[]" multiple>
        <option value="">Select District</option>
        <option value="Mogadishu">Mogadishu</option>
        <option value="Hodan">Hodan</option>
        <option value="Wadajir">Wadajir</option>
    </select>

    <br><br>
    <input type="submit" value="Submit">
</form>

<?php

if (!empty($_POST['pob'])) {

    foreach ($_POST['pob'] as $pop) {
        echo "<br>Your place of birth is: " . htmlspecialchars($pop);
    }

} else {
    echo "<br>Please select a place of birth.";
}

?>

</body>
</html>
