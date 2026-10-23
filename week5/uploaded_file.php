<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>File Upload</title>
</head>
<body>

<form action="" method="post" enctype="multipart/form-data">

    <label>Select File:</label>
    <input type="file" name="image" required>
    <br><br>

    <label>Rename File Name:</label>
    <input type="text" name="new_name" placeholder="Enter new file name" required>
    <br><br>

    <input type="submit" name="submit" value="Upload">

</form>

<?php
if (isset($_POST['submit'])) {

    if (!isset($_FILES['image'])) {
        echo "File lama helin.";

    } elseif ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        echo "Upload error code: " . $_FILES['image']['error'];

    } else {

        $name = $_FILES['image']['name'];
        $size = $_FILES['image']['size'];
        $temp = $_FILES['image']['tmp_name'];
        $type = $_FILES['image']['type'];

        // Check file size: 2 MB
        $maxSize = 2 * 1024 * 1024;

        if ($size > $maxSize) {
            die("File size waa weyn yahay! Ugu badnaan waa 2 MB.");
        }

        // Get extension
        $explode = explode(".", $name);
        $extension = strtolower(end($explode));

        // Rename file
        $newName = trim($_POST['new_name']);

        // Remove extension if user typed it
        $newName = pathinfo($newName, PATHINFO_FILENAME);

        // Keep only safe characters in the new name
        $newName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $newName);

        if ($newName === '') {
            die("Fadlan geli magaca cusub.");
        }

        $newName = $newName . "." . $extension;

        // Upload folder
        $folder = __DIR__ . "/uploads/";

        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        $destination = $folder . $newName;

        // Display file information
        echo "File Name: " . htmlspecialchars($name) . "<hr>";
        echo "File Size: " . round($size / 1024, 2) . " KB<hr>";
        echo "File Type: " . htmlspecialchars($type) . "<hr>";
        echo "File Temp: " . htmlspecialchars($temp) . "<hr>";
        echo "Check File Size: " .
            ($size <= $maxSize ? "Size is OK" : "File is too large") . "<hr>";
        echo "Rename File Name: " .
            htmlspecialchars($newName) . "<hr>";
        echo "Destination: " .
            htmlspecialchars($destination) . "<hr>";

        // Move uploaded file
        if (move_uploaded_file($temp, $destination)) {
            echo "<h3>Upload Successful!</h3>";
        } else {
            echo "<h3>Upload Failed!</h3>";
        }
    }
}
?>

</body>
</html>